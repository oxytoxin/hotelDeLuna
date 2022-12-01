<?php

namespace App\Http\Livewire\V2\FrontDesk\CheckIn;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Deposit;
use Livewire\Component;
use App\Traits\WithCaching;
use Livewire\WithPagination;
use App\Models\RoomTransactionLog;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination, WithCaching;

    public $viewGuest=null;

    public $search;

    public $realSearch;


    public $searchBy = '1';

    public $guestTotalAmountToPay;

    public $guestGivenAmount;

    public $guestExcessAmount;

    public $saveToDeposit = false;
    
    protected $listeners = ['confirmCheckIn'];


    public $recentlyCheckedInGuests = [];

    public $terminatedGuests = [];



    public function getPendingCheckInsQueryProperty()
    {
        return Guest::where('branch_id', auth()->user()->branch->id)
        ->where('terminated_at', null)
        ->where('is_checked_in', false)
        ->with(['checkInDetail','transactions']);
    }

    public function getPendingCheckInsProperty()
    {
        if ($this->realSearch != '') {
            switch ($this->searchBy) {
                case '1':
                    $this->pendingCheckInsQuery->where('qr_code', $this->realSearch);
                    break;
                case '2':
                    $this->pendingCheckInsQuery->whereHas('checkInDetail.room', function ($query) {
                            $query->where('number', $this->realSearch);
                      });
                    break;
            }
        }
        return $this->cache(function () {
            return $this->pendingCheckInsQuery->with(['checkInDetail.room'])->paginate(9);
        }, 'guests');
    }

    public function search()
    {
        $this->realSearch = $this->search;
        $this->search = '';
    }

    public function clearSearch()
    {
        $this->realSearch = '';
    }

    public function viewGuest($guest_id)
    {
        $this->useCacheRows();
        $this->viewGuest = Guest::where('id',$guest_id)->withSum('transactions','payable_amount')->with(['checkInDetail.room','checkInDetail.rate','transactions'])->first();
        $this->guestTotalAmountToPay = $this->viewGuest->transactions_sum_payable_amount;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function updatedGuestGivenAmount()
    {
        $this->useCacheRows();
        $this->guestExcessAmount = $this->guestGivenAmount > $this->guestTotalAmountToPay ?  $this->guestGivenAmount - $this->guestTotalAmountToPay : 0;
    }

    public function confirmCheckIn()
    {
        

        $this->validate([
            'guestGivenAmount' => 'required|numeric|min:0|min:' . $this->guestTotalAmountToPay,
        ]);
        DB::beginTransaction();

        $check_in_transaction = $this->viewGuest->transactions()->where('transaction_type_id', 1)->first();
        $default_deposit = $this->viewGuest->transactions()->where('transaction_type_id', 2)->first();

        $check_in_transaction->update([
            'paid_amount' => $this->guestGivenAmount - 200,  // 200 pesos will be added to remote and key deposite
            'change_amount' => $this->guestExcessAmount,
            'paid_at' => Carbon::now()
        ]);

        $check_in_detail = $this->viewGuest->checkInDetail;

        $check_in_detail->update([
            'check_in_at' => Carbon::now(),
            'expected_check_out_at' => Carbon::now()->addHours($check_in_detail->static_hours_stayed),
        ]);

        Room::where('id', $check_in_detail->room_id)->update([
            'room_status_id' => 2,
        ]);

        $default_deposit->update([
            'paid_amount' => 200,
            'change_amount' => 0,
            'paid_at' => Carbon::now()
        ]);

        if ($this->saveToDeposit) {
            $this->viewGuest->transactions()->create([
                'room_id' => $check_in_detail->room_id,
                'branch_id' => auth()->user()->branch_id,
                'transaction_type_id' => 2,
                'payable_amount' => $this->guestExcessAmount,
                'paid_amount' => $this->guestExcessAmount,
                'change_amount' => 0,
                'paid_at' => Carbon::now(),
                'remarks' => 'Excess amount from check in',
            ]);

            Deposit::create([
                'guest_id' => $this->viewGuest->id,
                'amount' => $this->guestExcessAmount,
                'remarks' => 'Excess amount from check in',
                'remaining'=> $this->guestExcessAmount,
            ]);
            $this->viewGuest->update([
                'is_checked_in' => true,
                'check_in_at' => Carbon::now(),
                'total_deposits' => $this->viewGuest->total_deposits + $this->guestExcessAmount,
                'deposit_balance' => $this->viewGuest->deposit_balance + $this->guestExcessAmount,
            ]);
        }else{
            $this->viewGuest->update([
                'is_checked_in' => true,
                'check_in_at' => Carbon::now(),
            ]);
        }

        RoomTransactionLog::create([
            'branch_id' => auth()->user()->branch_id,
            'room_id' =>$check_in_detail->room_id,
            'room_number' => $check_in_detail->room->number,
            'check_in_detail_id' => $check_in_detail->id,
            'check_in_at' => $check_in_detail->check_in_at,
            'time_interval' => $check_in_detail->room->last_check_out_at ? $check_in_detail->check_in_at->diffInMinutes($check_in_detail->room->last_check_out_at) : 0,
        ]);

        $cleanedRoom = Room::whereHas('floor', function ($query) {
            $query->where('branch_id', auth()->user()->branch_id);
        })->where('room_status_id', 9)->first();

        if ($cleanedRoom) {
            $cleanedRoom->update([
                'room_status_id' => 1,
                'priority' => 1,
            ]);
        }

        DB::commit();

        $this->viewGuest=null;
        $this->guestGivenAmount = '';
        $this->guestExcessAmount = '';
        $this->loadRecentlyCheckedInGuests();

        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('notify-alert',[
            'type' => 'success',
            'title' => 'Check In Success',
            'message' => 'Guest has been checked in successfully.'
        ]);
    }

    public function loadRecentlyCheckedInGuests()
    {
        $this->recentlyCheckedInGuests = Guest::where('branch_id', auth()->user()->branch->id)
        ->where('terminated_at', null)
        ->where('is_checked_in', true)
        ->where('check_in_at', '>=', Carbon::now()->subMinutes(120))
        ->orderBy('check_in_at', 'desc')
        ->get();
    }

    public function loadTerminatedGuests()
    {
        $this->terminatedGuests = Guest::where('branch_id', auth()->user()->branch->id)
        ->where('terminated_at', '!=', null)
        ->orderBy('terminated_at', 'desc')
        ->take(10)
        ->get();
    }
    
    public function mount()
    {
        $this->loadRecentlyCheckedInGuests();
        $this->loadTerminatedGuests();
    }


    public function render()
    {
        return view('livewire.v2.front-desk.check-in.index',[
            'guests' => $this->pendingCheckIns
        ]);
    }
    // 
}

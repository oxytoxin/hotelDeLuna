<?php

namespace App\Http\Livewire\FrontDesk;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Guest;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Transaction;
use Livewire\WithPagination;
use App\Models\CheckInDetail;

class CheckIn extends Component
{
    use WithPagination, Actions;
    public $search, $searchBy = '1', $realSearch;
    protected $listeners = ['refreshRecentCheckInList' => 'clearSearches'];
    public $showModal = false;
    public $guest = null;

    public function searchReal()
    {
        $this->realSearch = $this->search;
        $this->reset('search');
    }
    public function clearSearches()
    {
        $this->realSearch = '';
        $this->search = '';
        $this->searchBy = '1';
    }
    public function setGuest($guest_id)
    {
        $this->guest = Guest::find($guest_id);
        $this->showModal = true;
    }
    // public function pay($transaction_id)
    // {
    //     $transaction = Transaction::find($transaction_id);
    //     $transaction->paid_at = Carbon::now();
    //     $transaction->save();
    // }
    // public function cancelPayment($transaction_id)
    // {
    //     $transaction = Transaction::find($transaction_id);
    //     $transaction->paid_at = null;
    //     $transaction->save();
    // }
    public function confirmCheckIn()
    {
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Are you sure you want to check in this guest?',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Yes, Check In',
                'method' => 'checkIn',
            ],
            'reject' => [
                'label'  => 'No, cancel',
            ],
        ]);
    }
    public function checkIn()
    {
        $this->guest->transactions()->update(['paid_at' => Carbon::now()]);
        foreach ($this->guest->transactions->where('transaction_type_id', 1) as  $check_in_transaction) {
            $check_in_detail = CheckInDetail::where('transaction_id', $check_in_transaction->id)->first();
            $check_in_detail->update([
                'check_in_at' => Carbon::now(),
                'expected_check_out_at' => Carbon::now()->addHours($check_in_transaction->check_in_detail->static_hours_stayed),
            ]);
            Room::where('id', $check_in_detail->room_id)->update([
                'room_status_id' => 2,
            ]);
        }
        $this->guest->update([
            'is_checked_in' => true,
            'check_in_at' => Carbon::now(),
        ]);
        $this->showModal = false;
        $this->notification()->success(
            $title = 'Success!',
            $description = 'Guest has been checked in.',
        );
    }

    public function render()
    {
        return view('livewire.front-desk.check-in', [
            'guests' => Guest::query()
                ->when($this->realSearch, function ($query) {
                    switch ($this->searchBy) {
                        case '1':
                            return $query->where('qr_code', $this->realSearch);
                            break;
                        case '2':
                            return $query->where('name', 'like', '%' . $this->realSearch . '%');
                            break;
                        case '3':
                            return $query->where('contact_number', $this->realSearch);
                            break;
                    }
                })
                ->where('is_checked_in', false)
                ->paginate(10),
            'transactions'=>$this->showModal !=false ?
                $this->guest->transactions()
                ->with(['transaction_type', 'check_in_detail.room'])
                ->orderBy('created_at', 'desc')->get() : [],
            'recent_check_in_list'=>Guest::query()
                ->where('is_checked_in', true)
                ->orderBy('check_in_at', 'desc')
                ->paginate(10),
        ]);
    }
}
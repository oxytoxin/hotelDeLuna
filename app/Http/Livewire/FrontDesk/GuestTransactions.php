<?php

namespace App\Http\Livewire\FrontDesk;


use App\Models\{Guest,RoomChange};
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Traits\WithCaching;
use App\Traits\Extend\TransferRoom;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GuestTransactions extends Component
{

    use Actions, WithCaching, TransferRoom;

    protected $listeners = ['transactionUpdated'=>'$refresh'];


    public $tabs = [
        '0' => 'Information',
        '1' => 'Transactions',
        '2' => 'Transfer Room',
        '3' => 'Extend Stay',
        '4' => 'Damage Charges',
        '5' => 'Amenities',
        '6' => 'Food and Beverage',
        '7' => 'Deposit',
    ];

    public $search = null, $searchBy = "qr_code";

    public $queryString = ['search', 'searchBy'];

    public $grouped_transaction;

    public $changeRoom;

    public $transactionTabIsVisible = false;

    public function getGuestQueryProperty()
    {
        return Guest::whereNotNull('check_in_at')
            ->whereNull('check_out_at');
    }

    public function search($searchBy)
    {
        $this->searchBy = $searchBy;
    }

    public function getGuestProperty()
    {
        if (is_null($this->search)) return null;

        if ($this->searchBy == "qr_code") {
            $this->guestQuery->where('qr_code', $this->search);
        } else {
            $this->guestQuery->whereHas('checkInDetail.room', function ($query) {
                    $query->where('number', $this->search);
             });
        }

        return $this->cache(function () {
            return $this->guestQuery->with(['checkInDetail','transactions.transaction_type'])->first();
        });
    }

    public function getCheckInDetailProperty()
    {
        return $this->guest->checkInDetail;
    }

    public function clear()
    {
        $this->search = null;
        $this->searchBy = "";
        $this->transactionTabIsVisible = false;
    }

    public function payTransaction($transaction_id)
    {
        $this->useCacheRows();

        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'This will mark the transaction as paid.',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Yes, continue',
                'method' => 'confirmPayTransaction',
                'params' => $transaction_id,
            ],
            'reject' => [
                'label'  => 'No, cancel',
            ],
        ]);
    }

    public function confirmPayTransaction($transaction_id)
    {
        $transaction = $this->guest->transactions->find($transaction_id);

        $transaction->update([
            'paid_at' => Carbon::now(),
        ]);

        $this->dialog()->success(
            $title = 'Success',
            $description= 'Transaction has been marked as paid.',
        );
    }

    public function mount()
    {
        if ($this->search && $this->searchBy) {
            $this->search($this->searchBy);
        }
    }

    public function useNavigatedToTransactions()
    {
        $this->useCacheRows();
        $this->transactionTabIsVisible = true;
    }

    public function render()
    {
        return view('livewire.front-desk.guest-transactions',[
            'guest_transactions' => $this->transactionTabIsVisible ? $this->guest->transactions->groupBy('transaction_type_id') :  [],
            'transaction_types' => $this->transactionTabIsVisible ? \App\Models\TransactionType::get() : [],
        ]);
    }
}

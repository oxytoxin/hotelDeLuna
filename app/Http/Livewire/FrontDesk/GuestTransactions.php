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

    protected $listeners = ['room_changed'=>'$refresh'];

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
            $this->guestQuery->whereHas('transactions', function ($query) {
                $query->where('transaction_type_id', 1)
                    ->whereHas('check_in_detail.room', function ($query) {
                        $query->where('number', $this->search);
                    });
            });
        }

        return $this->cache(function () {
            return $this->guestQuery->with(['transactions.transaction_type'])->first();
        });
    }
    public function getCheckInDetailProperty()
    {
        return $this->guest->transactions->first()->check_in_detail->load(['room.type']);
    }
    public function clear()
    {
        $this->search = null;
        $this->searchBy = "";
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

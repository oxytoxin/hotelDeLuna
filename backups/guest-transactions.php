<?php

namespace App\Http\Livewire\FrontDesk;

use App\Models\Room;
use App\Models\Guest;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Transaction;
use App\Traits\WithCaching;
use App\Models\CheckInDetail;
use App\Models\RoomChange;
use App\Models\TransactionType;

class GuestTransactions extends Component
{
    use Actions, WithCaching;

    public $search = '';

    public $searchBy = null;

    public $changeRoom;

    public $transaction;

    protected $queryString = ['search', 'searchBy'];

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

    public $current_tab = '0';

    public $transactionsGroupedByType = [];

    public $transactionTypes = [];

    public function switchTab($tab)
    {
        if ($tab!=0) $this->useCacheRows();

        if ($tab == 2) {
            $this->transaction = Transaction::make([
                'transaction_type_id' => 7,
                'guest_id' => $this->searchedGuest->id,
            ]);
            $this->changeRoom = RoomChange::make([
                'transaction_id' => $this->transaction->id,
            ]);
        }
        
        $this->current_tab = $tab;
    }

    public function hasQuery()
    {
        return $this->search != '' || $this->searchBy != null;
    }

    public function getSearchedGuestQueryProperty()
    {
        if (!$this->hasQuery()) {
            return null;
        }
        return Guest::where('terminated_at', null)
                ->where('check_in_at', '!=', null)
                ->where('totaly_checked_out', false);
    }

    public function getSearchedGuestProperty()
    {
        if (!$this->hasQuery()) {
            return null;
        }
        if ($this->searchBy == 'qr_code') {
            $this->searchedGuestQuery->where('qr_code', $this->search);
        }

        if ($this->searchBy == 'room_number') {
            $this->searchedGuestQuery->whereHas('transactions', function($query) {
                $query->where('transaction_type_id', 1)
                    ->whereHas('check_in_detail.room', function($query) {
                        $query->where('number', $this->search);
                    });
            });
        }

        if(!$this->searchedGuestQuery) return null;

        $this->searchedGuestQuery->with([
                'transactions' => function($query) {
                       return $query->where('transaction_type_id', 1);
                  },
        ]);

        return $this->cache(function () {
            return $this->searchedGuestQuery->first();
        });
    }

    public function searchByQrCode()
    {
        $this->searchBy = 'qr_code';
    }

    public function searchByRoomNumber()
    {
        $this->searchBy = 'room_number';
    }

    public function clear()
    {
        $this->search = '';
        $this->searchBy = null;
    }

    // public function toogleTransactionOrder()
    // {
    //     if ($this->transaction_order == 'ASC') {
    //         $this->transaction_order = 'DESC';
    //     } else {
    //         $this->transaction_order = 'ASC';
    //     }
    // }

    // public function payTransaction($transaction_id)
    // {
    //     $this->dialog()->confirm([
    //         'title'       => 'Are you Sure?',
    //         'description' => 'This will mark this transaction as paid',
    //         'icon'        => 'question',
    //         'accept'      => [
    //             'label'  => 'Yes, Pay',
    //             'method' => 'confirmPayTransaction',
    //             'params' => $transaction_id,
    //         ],
    //         'reject' => [
    //             'label'  => 'No, cancel',
    //         ],
    //     ]);
    // }

    // public function confirmPayTransaction($transaction_id)
    // {
    //     $transaction = $this->guest->transactions()->find($transaction_id);
    //     $transaction->update([
    //         'paid_at' => now(),
    //     ]);
    //     $this->notification()->success(
    //         $title = 'Transaction Paid',
    //         $description = 'Transaction has been marked as paid'
    //     );
    // }

    // public function clear()
    // {
    //     $this->search = '';
    //     $this->action = null;
    //     $this->guest = null;
    // }


    public function render()
    {
        return view('livewire.front-desk.guest-transactions',[
            'guest' => $this->searchedGuest,
        ]);
    }
}

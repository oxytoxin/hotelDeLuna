<?php

namespace App\Http\Livewire\FrontDesk;

use App\Models\CheckInDetail;
use App\Models\Guest;
use App\Models\Room;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Traits\WithCaching;
class GuestTransactions extends Component
{
    use Actions, WithCaching;

    public $search = '';

    public $searchBy = null;

    public $guest = null;

    protected $queryString = ['search', 'searchBy'];

    public $action = null;

    public $transaction_order = 'ASC';

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

    public function switchTab($tab)
    {
        $this->useCacheRows();
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
        return Guest::where('branch_id', auth()->user()->branch_id);
    }

    public function getSearchedGuestProperty()
    {
        if (!$this->hasQuery()) {
            return null;
        }
        if ($this->searchBy == 'qr_code') {
            $this->searchedGuestQuery->where('qr_code', $this->search)
                ->where('terminated_at', null)
                ->where('check_in_at', '!=', null)
                ->where('totaly_checked_out', false);
        }

        if ($this->searchBy == 'room_number') {
            $this->searchedGuestQuery->whereHas('transactions', function($query) {
                $query->where('transaction_type_id', 1)
                    ->whereHas('check_in_detail.room', function($query) {
                        $query->where('number', $this->search);
                    });
            });
        }

        if (!$this->hasQuery()) {
            $this->guest = null;
        }

        return $this->cache(function () {
            return $this->searchedGuestQuery->first();
        });
    }

    public function searchByQrCode()
    {
        $this->searchBy = 'qr_code';
       $this->guest = $this->searchedGuest ?? null;
    }

    public function searchByRoomNumber()
    {
        $this->searchBy = 'room_number';
        $this->guest = $this->searchedGuest;
    }

    public function clear()
    {
        $this->search = '';
        $this->searchBy = null;
        $this->guest = null;
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


    public function mount()
    {
        $this->guest = $this->searchedGuest;
    }

    public function render()
    {
        return view('livewire.front-desk.guest-transactions');
    }
}

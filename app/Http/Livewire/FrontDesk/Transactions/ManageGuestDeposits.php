<?php

namespace App\Http\Livewire\FrontDesk\Transactions;

use Livewire\Component;

class ManageGuestDeposits extends Component
{
    public $guest_id;
    public function render()
    {
        return view('livewire.front-desk.transactions.manage-guest-deposits');
    }
}

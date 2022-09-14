<?php

namespace App\Http\Livewire\Kitchen;

use Livewire\Component;
use App\Models\Transaction;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.kitchen.dashboard',[
            'transactions' => Transaction::where('transaction_type_id', 3)->where('branch_id', auth()->user()->branch_id)->with('orders')->get(),
        ]);
    }
}

<?php

namespace App\Http\Livewire\Kitchen;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.kitchen.dashboard', [
            'transactions' => Transaction::where('transaction_type_id', 3)->where('branch_id', auth()->user()->branch_id)->with('orders')->paginate(6),
        ]);
    }
}

<?php

namespace App\Http\Livewire\BackOffice;

use Livewire\Component;
use App\Models\Floor;
use App\Models\Transaction;
use App\Models\Guest;

class Sales extends Component
{
    public $report_type;
    public $floors = [];
    public $floor_id;

    public function mount()
    {
        $this->floors = Floor::where(
            'branch_id',
            auth()->user()->branch_id
        )->get();
    }

    public function render()
    {
        return view('livewire.back-office.sales', [
            'transactions' => $this->getTransactions(),
        ]);
    }

    public function getTransactions()
    {
        if ($this->report_type == null) {
            return Transaction::where('branch_id', auth()->user()->branch_id)
                ->whereIn('transaction_type_id', [1, 3, 4, 5, 6, 7, 8])
                ->whereNotNull('paid_at')
                ->with('room.floor', 'guest')
                ->get();
        } else {
            return [];
        }
    }
}

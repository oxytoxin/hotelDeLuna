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
        $data = Floor::first()->rooms;
        dd($data[0]->check_in_details);
        return view('livewire.back-office.sales', [
            'transactions' => $this->getTransactions(),
        ]);
    }

    public function getTransactions()
    {
        if ($this->report_type == null) {
            return Guest::whereBranchId(auth()->user()->branch_id)
                ->with('transactions')
                ->get();
        } else {
            return [];
        }
    }
}

<?php

namespace App\Http\Livewire\BackOffice;

use Livewire\Component;
use App\Models\Floor;
use App\Models\Transaction;
use App\Models\Guest;
use Carbon\Carbon;

class Sales extends Component
{
    public $report_type;
    public $floors = [];
    public $floor_id;
    public $datefrom;
    public $dateto;

    public function mount()
    {
        $this->datefrom = Carbon::now()->format('Y-m-d') . ' 20:01:00';
        $this->dateto =
            Carbon::now()
                ->addDay()
                ->format('Y-m-d') . ' 08:00:00';
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
        } elseif ($this->report_type == 1) {
            return Transaction::where('branch_id', auth()->user()->branch_id)
                ->whereIn('transaction_type_id', [1, 3, 4, 5, 6, 7, 8])
                ->whereTime('paid_at', '>=', '08:01:00')
                ->whereTime('paid_at', '<=', '20:00:00')
                ->whereNotNull('paid_at')
                ->when($this->floor_id, function ($query) {
                    return $query->whereHas('room', function ($query) {
                        return $query->where('floor_id', $this->floor_id);
                    });
                })
                ->with('room.floor', 'guest')
                ->get();
        } else {
            return Transaction::where('branch_id', auth()->user()->branch_id)
                ->whereIn('transaction_type_id', [1, 3, 4, 5, 6, 7, 8])
                ->where('paid_at', '>=', $this->datefrom)
                ->where('paid_at', '<=', $this->dateto)
                ->whereNotNull('paid_at')
                ->when($this->floor_id, function ($query) {
                    return $query->whereHas('room', function ($query) {
                        return $query->where('floor_id', $this->floor_id);
                    });
                })
                ->with('room.floor', 'guest')
                ->get();
            //carbon now and change the time
        }
    }
}

<?php

namespace App\Http\Livewire\BackOffice;

use Livewire\Component;
use App\Models\Cleaning;
use Carbon\Carbon;
use App\Exports\OverdueExport;
use Maatwebsite\Excel\Facades\Excel;

class Overdue extends Component
{
    public $date;
    public $apply_date = false;
    public $generate_query;

    public function updatedDate()
    {
        $this->apply_date = false;
    }

    public function render()
    {
        return view('livewire.back-office.overdue', [
            'overdues' => Cleaning::where('delayed', 1)
                ->whereHas('room', function ($query) {
                    $query->whereHas('floor', function ($query) {
                        $query->where('branch_id', auth()->user()->branch_id);
                    });
                })
                ->with(['room', 'room.floor'])
                ->when($this->apply_date == true, function ($query) {
                    $query->whereDate('created_at', $this->date);
                })
                ->get(),
        ]);
    }

    public function generate()
    {
        $this->apply_date = true;
    }

    public function export()
    {
        return Excel::download(
            new OverdueExport($this->date),
            'OverdueExport ' . Carbon::parse(now())->format('M. d, Y') . '.xlsx'
        );
    }
}

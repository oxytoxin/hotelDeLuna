<?php

namespace App\Http\Livewire\BackOffice;

use Livewire\Component;
use App\Models\Guest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GuestReport as GuestReportExport;
use Carbon\Carbon;

class GuestReport extends Component
{
    public $report_type;
    public $date;
    public $generate_query;
    public function render()
    {
        return view('livewire.back-office.guest-report', [
            'guests' =>
                $this->report_type == 1
                    ? ($this->generate_query == null
                        ? Guest::where('branch_id', auth()->user()->branch_id)
                            ->with('transactions')
                            ->get()
                        : $this->generate_query)
                    : Guest::where('branch_id', auth()->user()->branch_id)
                        ->whereDate('created_at', now())
                        ->get(),
        ]);
    }

    public function generate()
    {
        $this->validate([
            'date' => 'required',
        ]);
        $this->generate_query = Guest::where(
            'branch_id',
            auth()->user()->branch_id
        )
            ->with('transactions')
            ->whereDate('created_at', $this->date)
            ->get();
    }

    public function export()
    {
        switch ($this->report_type) {
            case '1':
                $this->validate([
                    'date' => 'required',
                ]);
                // dd($this->report_type);
                return Excel::download(
                    new GuestReportExport($this->date, $this->report_type),
                    'Guest_per_day ' .
                        Carbon::parse(now())->format('M. d, Y') .
                        '.xlsx'
                );
                break;

            default:
                return Excel::download(
                    new GuestReportExport($this->date, $this->report_type),
                    'New_guest ' .
                        Carbon::parse(now())->format('M. d, Y') .
                        '.xlsx'
                );
                break;
        }
    }
}

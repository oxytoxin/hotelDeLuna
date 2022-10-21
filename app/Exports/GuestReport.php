<?php

namespace App\Exports;

use App\Models\Guest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GuestReport implements FromCollection, WithMapping, WithHeadings
{
    public $date, $report_type;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($date, $type)
    {
        $this->date = $date;
        $this->report_type = $type;
    }

    public function collection()
    {
        if ($this->report_type == 1) {
            return Guest::where('branch_id', auth()->user()->branch_id)
                ->with('transactions')
                ->whereDate('created_at', $this->date)
                ->get();
        } else {
            return Guest::where('branch_id', auth()->user()->branch_id)
                ->whereDate('created_at', now())
                ->get();
        }
    }

    public function map($guest): array
    {
        return [$guest->name, $guest->contact_number];
    }

    public function headings(): array
    {
        return ['Guest Name', 'Contact_number'];
    }
}

<?php

namespace App\Exports;

use App\Models\Cleaning;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OverdueExport implements FromCollection, WithMapping, WithHeadings
{
    public $date;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function collection()
    {
        return Cleaning::where('delayed', 1)
            ->whereHas('room', function ($query) {
                $query->whereHas('floor', function ($query) {
                    $query->where('branch_id', auth()->user()->branch_id);
                });
            })
            ->with(['room', 'room.floor'])
            ->when($this->date, function ($query) {
                $query->whereDate('created_at', $this->date);
            })
            ->get();
    }

    public function map($cleaning): array
    {
        return [
            'RM #' .
            $cleaning->room->number .
            ' | ' .
            ordinal($cleaning->room->floor->number) .
            ' Floor',
            $cleaning->room_boy->user->name,
        ];
    }

    public function headings(): array
    {
        return ['Overdue Room', 'Assigned Roomboy', 'Date', 'Time'];
    }
}

<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OccupiedRoomExport implements FromCollection, WithMapping, WithHeadings
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
        return Transaction::where('transaction_type_id', 1)
            ->whereHas('check_in_detail', function ($query) {
                $query->whereHas('room', function ($query) {
                    $query->where('branch_id', auth()->user()->branch_id);
                });
            })
            ->with([
                'check_in_detail.room.floor',
                'guest',
                'check_in_detail',
                'check_in_detail.room',
            ])
            ->when($this->date != false, function ($query) {
                $query->whereDate('created_at', $this->date);
            })
            ->get();
    }

    public function map($transaction): array
    {
        return [
            $transaction->guest->qr_code,
            'Rm #' .
            $transaction->check_in_detail->room->room_number .
            ' | ' .
            ordinal($transaction->check_in_detail->room->floor->number) .
            'Floor',
        ];
    }

    public function headings(): array
    {
        return ['TR-Number', 'Room'];
    }
}

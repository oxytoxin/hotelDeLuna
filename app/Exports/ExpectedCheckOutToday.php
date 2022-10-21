<?php

namespace App\Exports;
use App\Models\Guest;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExpectedCheckOutToday implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Guest::where('branch_id', auth()->user()->branch_id)
            ->whereHas('transactions', function($query){
                $query->where('transaction_type_id', 1)
                ->whereHas('check_in_detail', function($query){
                    $query->where('expected_check_out_at', '>=', now()->startOfDay());
                });
            })
            ->with([
               'transactions'=>[
                    'check_in_detail'=>[
                        'room'=>[
                            'floor',
                            'type',
                        ],
                        'rate'=>[
                            'staying_hour'
                        ]
                    ]
               ]
            ])
            ->get();
    }

    public function map($guest): array
    {
        return [
            Carbon::parse($guest->check_in_at)->format('M, d y h:i A'),
            $guest->name,
            $guest->contact_number,
            $guest->transactions->where('transaction_type_id', 1)->first()->check_in_detail->room->number,
            $guest->transactions->where('transaction_type_id', 1)->first()->check_in_detail->rate->staying_hour->number,
            Carbon::parse($guest->transactions->where('transaction_type_id', 1)->first()->check_in_detail->expected_check_out_at)->format('M, d y h:i A'),
        ];
    }

    public function headings(): array
    {
        return [
            'Time Check In',
            'Name',
            'Phone',
            'Room',
            'Hours',
            'Expected Check Out'
        ];
    }
}

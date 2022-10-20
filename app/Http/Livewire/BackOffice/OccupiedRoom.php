<?php

namespace App\Http\Livewire\BackOffice;

use Livewire\Component;
use App\Models\Transaction;

class OccupiedRoom extends Component
{
    public $date;
    public $generate_query;

    public function render()
    {
        return view('livewire.back-office.occupied-room', [
            'rooms' =>
                $this->generate_query == null
                    ? Transaction::where('transaction_type_id', 1)
                        ->whereHas('check_in_detail', function ($query) {
                            $query->whereHas('room', function ($query) {
                                $query
                                    ->where(
                                        'branch_id',
                                        auth()->user()->branch_id
                                    )
                                    ->where('room_status_id', 2);
                            });
                        })
                        ->with([
                            'check_in_detail.room.floor',
                            'guest',
                            'check_in_detail',
                            'check_in_detail.room',
                        ])
                        ->get()
                    : $this->generate_query,
        ]);
    }

    public function generate()
    {
        $this->generate_query = Transaction::where('transaction_type_id', 1)
            ->whereHas('check_in_detail', function ($query) {
                $query->whereHas('room', function ($query) {
                    $query
                        ->where('branch_id', auth()->user()->branch_id)
                        ->where('room_status_id', 2);
                });
            })
            ->with([
                'check_in_detail.room.floor',
                'guest',
                'check_in_detail',
                'check_in_detail.room',
            ])
            ->whereDate('created_at', $this->date)
            ->get();
    }
}

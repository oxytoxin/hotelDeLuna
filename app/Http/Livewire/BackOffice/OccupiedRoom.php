<?php

namespace App\Http\Livewire\BackOffice;

use Livewire\Component;
use App\Models\Transaction;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OccupiedRoomExport;
use Carbon\Carbon;

class OccupiedRoom extends Component
{
    public $date = null;
    public $generate_query;

    public function render()
    {
        return view('livewire.back-office.occupied-room', [
            'transactions' =>
                $this->generate_query == null
                    ? Transaction::where('transaction_type_id', 1)
                        ->whereHas('guest.checkInDetail', function ($query) {
                            $query->whereHas('room', function ($query) {
                                $query
                                    ->where(
                                        'branch_id',
                                        auth()->user()->branch_id
                                    )
                                    ->where('room_status_id', 2);
                            });
                        })
                        ->with(['room.floor', 'guest'])
                        ->get()
                    : $this->generate_query,
        ]);
    }

    public function generate()
    {
        $this->generate_query = Transaction::where('transaction_type_id', 1)
            ->whereHas('guest.checkInDetail', function ($query) {
                $query->whereHas('room', function ($query) {
                    $query
                        ->where('branch_id', auth()->user()->branch_id)
                        ->where('room_status_id', 2);
                });
            })

            ->whereDate('created_at', $this->date)
            ->get();
    }

    public function export($ext)
    {
        switch ($ext) {
            case 'pdf':
                if ($this->date == null) {
                    return Excel::download(
                        new OccupiedRoomExport($this->date),
                        'occupied-room-' .
                            Carbon::parse(now())->format('M. d, Y') .
                            '.' .
                            $ext,
                        \Maatwebsite\Excel\Excel::DOMPDF
                    );
                } else {
                    return Excel::download(
                        new OccupiedRoomExport($this->date),
                        'occupied-room-' .
                            Carbon::parse(now())->format('M. d, Y') .
                            '.' .
                            $ext
                    );
                }
                break;

            default:
                if ($this->date == null) {
                    return Excel::download(
                        new OccupiedRoomExport($this->date),
                        'occupied-room-' .
                            Carbon::parse(now())->format('M. d, Y') .
                            '.' .
                            $ext
                    );
                } else {
                    return Excel::download(
                        new OccupiedRoomExport($this->date),
                        'occupied-room-' .
                            Carbon::parse(now())->format('M. d, Y') .
                            '.' .
                            $ext
                    );
                }
                break;
        }
    }
}

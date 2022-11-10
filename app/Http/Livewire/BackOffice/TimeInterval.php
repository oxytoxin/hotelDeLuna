<?php

namespace App\Http\Livewire\BackOffice;

use Livewire\Component;
use App\Models\CheckInDetail;
use Carbon\Carbon;

class TimeInterval extends Component
{
    public $shift;
    public $date;
    public $date_from;
    public $date_to;

    public function render()
    {
        return view('livewire.back-office.time-interval', [
            'checkInDetails' => $this->generatedQuery(),
        ]);
    }

    public function updatedDate()
    {
        $this->shift = null;
    }

    public function updatedShift()
    {
        if ($this->shift == 1) {
            $this->datefrom =
                Carbon::parse($this->date)->format('Y-m-d') . ' 08:01:00';
            $this->dateto =
                Carbon::parse($this->date)->format('Y-m-d') . ' 20:00:00';
        } else {
            $this->datefrom =
                Carbon::parse($this->date)->format('Y-m-d') . ' 20:01:00';
            $this->dateto =
                Carbon::parse($this->date)
                    ->addDay()
                    ->format('Y-m-d') . ' 08:00:00';
        }
    }

    public function generatedQuery()
    {
        if ($this->shift == 1) {
            return CheckInDetail::whereHas('room.floor', function ($query) {
                $query->where('branch_id', auth()->user()->branch_id);
            })
                ->where('check_in_at', '>=', $this->datefrom)
                ->where('check_out_at', '<=', $this->dateto)
                ->with('room.floor', 'guest')
                ->get()
                ->pluck('room_id')
                ->toArray();
        } elseif ($this->shift == 2) {
            return CheckInDetail::whereHas('room.floor', function ($query) {
                $query->where('branch_id', auth()->user()->branch_id);
            })
                ->where('check_in_at', '>=', $this->datefrom)
                ->where('check_out_at', '<=', $this->dateto)
                ->with('room.floor', 'guest')
                ->get()
                ->pluck('room_id')
                ->toArray();
        } else {
            return CheckInDetail::whereHas('room.floor', function ($query) {
                $query->where('branch_id', auth()->user()->branch_id);
            })
                ->when($this->date, function ($query) {
                    return $query->whereDate('created_at', $this->date);
                })
                ->with('room.floor', 'guest')
                ->get()
                ->pluck('room_id')
                ->toArray();
        }
    }
}

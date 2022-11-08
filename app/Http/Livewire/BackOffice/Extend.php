<?php

namespace App\Http\Livewire\BackOffice;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\StayExtension;

class Extend extends Component
{
    public $date;
    public $shift;
    public $date_from;
    public $date_to;
    public function render()
    {
        return view('livewire.back-office.extend', [
            'stays' => $this->generatedQuery(),
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
            // return RoomChange::where('created_at', '>=', $this->datefrom)
            //     ->where('created_at', '<=', $this->dateto)
            //     ->get();
            return StayExtension::whereHas('guest', function ($query) {
                return $query->where('branch_id', auth()->user()->branch_id);
            })
                ->where('created_at', '>=', $this->datefrom)
                ->where('created_at', '<=', $this->dateto)
                ->with('guest')
                ->pluck('guest_id')
                ->toArray();
        } elseif ($this->shift == 2) {
            return StayExtension::whereHas('guest', function ($query) {
                return $query->where('branch_id', auth()->user()->branch_id);
            })
                ->where('created_at', '>=', $this->datefrom)
                ->where('created_at', '<=', $this->dateto)
                ->with('guest')
                ->pluck('guest_id')
                ->toArray();
        } else {
            return StayExtension::whereHas('guest', function ($query) {
                return $query->where('branch_id', auth()->user()->branch_id);
            })
                ->with('guest')
                ->pluck('guest_id')
                ->toArray();
        }
    }
}

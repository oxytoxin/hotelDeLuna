<?php

namespace App\Http\Livewire\BackOffice;

use Livewire\Component;
use App\Models\RoomChange;
use Carbon\Carbon;

class Transfer extends Component
{
    public $date;
    public $shift;
    public $date_from;
    public $date_to;

    public function render()
    {
        return view('livewire.back-office.transfer', [
            'roomChanges' => $this->generatedQuery(),
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
            return RoomChange::where('check_in_at', '>=', $this->datefrom)
                ->where('check_out_at', '<=', $this->dateto)
                ->pluck('from_room_id')
                ->toArray();
        } elseif ($this->shift == 2) {
            return RoomChange::where('check_in_at', '>=', $this->datefrom)
                ->where('check_out_at', '<=', $this->dateto)
                ->pluck('from_room_id')
                ->toArray();
        } else {
            return RoomChange::get();
        }
    }
}

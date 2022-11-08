<?php

namespace App\Http\Livewire\BackOffice;

use Livewire\Component;
use App\Models\RoomChange;

class Transfer extends Component
{
    public $date;
    public $shift;

    public function render()
    {
        return view('livewire.back-office.transfer', [
            'roomChanges' => $this->generatedQuery(),
        ]);
    }

    public function generatedQuery()
    {
        if ($this->shift == 1) {
            # code...
        } elseif ($this->shift == 2) {
            # code...
        } else {
            return RoomChange::whereDate('created_at', $this->date)->get();
        }
    }
}

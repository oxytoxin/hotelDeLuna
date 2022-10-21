<?php

namespace App\Http\Livewire\BackOffice;

use Livewire\Component;
use App\Models\RoomBoy;

class RoomboyReport extends Component
{
    public function render()
    {
        return view('livewire.back-office.roomboy-report', [
            'roomboys' => RoomBoy::whereHas('user', function ($query) {
                $query->where('branch_id', auth()->user()->branch_id);
            })
                ->with('cleanings')
                ->get(),
        ]);
    }
}

<?php

namespace App\Http\Livewire\FrontDesk;

use App\Models\Room;
use Livewire\Component;

class PriorityRoom extends Component
{
    public function render()
    {
        return view('livewire.front-desk.priority-room',[
            'rooms' => Room::where('room_status_id',1)
                        ->whereHas('floor', function ($query) {
                            return $query->where('branch_id', auth()->user()->branch_id);
                        })
                        ->with([
                            'floor',
                        ])
                        ->get()
        ]);
    }
}

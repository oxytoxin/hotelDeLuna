<?php

namespace App\Http\Livewire\Housekeeping;

use App\Models\Room;
use Livewire\Component;
use Livewire\WithPagination;

class RoomMonitoring extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.housekeeping.room-monitoring', [
            'rooms' => Room::whereHas('floor', function ($query) {
                $query->where('branch_id', auth()->user()->branch_id);
            })->paginate(10),
        ]);
    }
}

<?php

namespace App\Http\Livewire\FrontDesk;

use App\Models\Room;
use Livewire\Component;
use App\Models\RoomStatus;
use Livewire\WithPagination;

class PriorityRoom extends Component
{

    use WithPagination;

    public $search = '';

    public $status_filter = '';

    public $statuses = [];

    public function mount()
    {
        $this->statuses = RoomStatus::where('id', '!=', 6)->get();
    }

    public function render()
    {
        return view('livewire.front-desk.priority-room', [
            'rooms' => Room::where('room_status_id', 1)
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

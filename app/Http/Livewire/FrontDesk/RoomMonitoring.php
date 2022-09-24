<?php

namespace App\Http\Livewire\FrontDesk;

use App\Models\Room;
use App\Models\RoomStatus;
use Livewire\Component;
use Livewire\WithPagination;

class RoomMonitoring extends Component
{
    use WithPagination;

    public $search = '';

    public $status_filter = '';

    public $statuses = [];

    public function mount()
    {
        $this->statuses = RoomStatus::get();
    }

    public function render()
    {
        return view('livewire.front-desk.room-monitoring', [
            'rooms' => Room::query()
                ->when($this->status_filter != '', function ($query) {
                    $query->where('room_status_id', $this->status_filter);
                })
                ->when($this->search != '', function ($query) {
                    return $query->where('number', 'like', '%' . $this->search . '%');
                })
                ->whereHas('floor', function ($query) {
                    return $query->where('branch_id', auth()->user()->branch_id);
                })
                ->with([
                    'floor',
                    'room_status',
                    'check_in_details' => function ($query) {
                        return $query->where('check_out_at', null)->first();
                    },
                ])
                ->paginate(10),
        ]);
    }
}

<?php

namespace App\Http\Livewire\FrontDesk;

use App\Models\Room;
use Livewire\Component;
use App\Models\RoomStatus;
use WireUi\Traits\Actions;
class PriorityRoom extends Component
{

    use Actions;

    public function setAsPriority($room_id)
    {
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'This will set the room as priority room.',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Yes, save it',
                'method' => 'confirmSetAsPriority',
                'params' => $room_id,
            ],
            'reject' => [
                'label'  => 'No, cancel',
            ],
        ]);
    }

    public function confirmSetAsPriority($room_id)
    {
        $room = Room::find($room_id);
        $room->priority = true;
        $room->room_status_id=1;
        $room->save();
        $this->notification()->success(
            $title ='Success',
            $description = 'Room has been set as priority room.',
        );
    }


    public function render()
    {
        return view('livewire.front-desk.priority-room', [
            'rooms' => Room::whereIn('room_status_id', [1,9])
                ->whereHas('floor', function ($query) {
                    return $query->where('branch_id', auth()->user()->branch_id);
                })
                ->with([
                    'floor',
                ])
                ->orderBy('updated_at', 'ASC')
                ->get()
        ]);
    }
}

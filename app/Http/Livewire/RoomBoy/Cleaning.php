<?php

namespace App\Http\Livewire\RoomBoy;

use App\Models\Cleaning as CleaningModel;
use App\Models\Designation;
use App\Models\Room;
use Carbon\Carbon;
use Livewire\Component;
use WireUi\Traits\Actions;

class Cleaning extends Component
{
    use Actions;

    public $current_assigned_floor;
    public $filter = 'ASC';
    public $room;
    

    public function getDesignationProperty()
    {
        return Designation::query()
            ->where('room_boy_id', auth()->user()->room_boy->id)
            ->where('current', 1)
            ->with(['floor'])
            ->first();
    }

    public function startRoomCleaning($room_id)
    {
        if (auth()->user()->room_boy->is_cleaning) {
            $this->notification()->error(
                $title = 'Cleaning Room',
                $description = 'You are not able to clean this room. please make sure you dont have pending unclean room.',
            );
            return;
        }
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Do you want to continue this action?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, save it',
                'method' => 'confirmStartRoomCleaning',
                'params' => $room_id,
            ],
            'reject' => [
                'label' => 'No, cancel',
            ],
        ]);
    }

    public function confirmStartRoomCleaning($room_id)
    {
        $room = Room::where('id', $room_id)->first();
        $room->update([
            'room_status_id' => 8,
        ]);
        CleaningModel::create([
            'room_boy_id' => auth()->user()->room_boy->id,
            'room_id' => $room->id,
            'suppose_to_start' => $room->time_to_clean,
            'started_at' => Carbon::now(),
        ]);
        auth()->user()->room_boy->update([
            'is_cleaning' => 1,
            'room_id' => $room_id,
        ]);
    }

    public function finish($room_id)
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Do you want to continue this action?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, save it',
                'method' => 'confirmFinish',
                'params' => $room_id,
            ],
            'reject' => [
                'label' => 'No, cancel',
            ],
        ]);
    }

    public function confirmFinish($room_id)
    {
        $room = Room::where('id', $room_id)->first();
        if ($room->room_status_id == 8 && $room->updated_at->diffInMinutes(Carbon::now()) < 20) {
            $this->notification()->error(
                $title  = 'Error',
                $description = 'You can not finish this room before 20 minutes',
            );
            return;
        }
        $delayed = $room->time_to_clean < Carbon::now();
        $room->update([
            'room_status_id' => 1,
            'time_to_clean' => null,
        ]);
        $cleaning = CleaningModel::where('room_id', $room_id)->where('finish_at', null)->first();
        $cleaning->update([
            'finish_at' => Carbon::now(),
            'delayed' => $delayed,
        ]);
        auth()->user()->room_boy->update([
            'is_cleaning' => 0,
            'room_id' => null,
        ]);
        $this->notification()->success(
            $title = 'Finish',
            $description = 'Room is now ready to use',
        );
    }

    public function test(){
        dd('sdsdsd');
    }

    public function render()
    {
        return view('livewire.room-boy.cleaning', [
            'rooms' => $this->designation ? Room::query()
                ->where('floor_id', $this->designation->floor_id)
                ->whereIn('room_status_id', [7, 8])
                ->get() : [],
                'history' => CleaningModel::query()->where('room_boy_id', auth()->user()->room_boy->id)->orderBy('id', $this->filter)->get(),
        ]);
    }
}

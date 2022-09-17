<?php

namespace App\Http\Livewire\Housekeeping;

use App\Models\Designation;
use App\Models\Floor;
use App\Models\RoomBoy;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Designations extends Component
{
    use WithPagination, Actions;

    public $showModal = false;

    public $users = [];

    public $room_boy = '';

    public $floor_id = null;

    public function manageFloorDesignations($floor_id)
    {
        $this->showModal = true;
        $this->floor_id = $floor_id;
        $this->users = User::where('branch_id', auth()->user()->branch_id)
            ->where('role_id', 5)
            ->get(['id', 'name'])
            ->toArray();
    }

    public function save()
    {
        $this->validate([
            'room_boy' => 'required',
        ]);
        $room_boy = RoomBoy::where('user_id', $this->room_boy)->first();
        $alreadyAssigned = Designation::where('room_boy_id', $room_boy->id)
            ->where('floor_id', $this->floor_id)
            ->where('current', 1)
            ->exists();
        if ($alreadyAssigned) {
            $this->notification()->error(
                $title = 'Failed',
                $description = 'User already assigned to this floor'
            );

            return;
        }
        Designation::where('room_boy_id', $room_boy->id)
            ->where('current', 1)->update([
                'current' => 0,
            ]);
        Designation::create([
            'room_boy_id' => $room_boy->id,
            'floor_id' => $this->floor_id,
        ]);
        $this->notification()->success(
            $title = 'Success',
            $description = 'User has been assigned successfully'
        );
        $this->reset('room_boy');
    }

    public function render()
    {
        return view('livewire.housekeeping.designations', [
            'floors' => Floor::where('branch_id', auth()->user()->branch_id)->withCount('rooms')->paginate(10),
            'designations' => $this->showModal ?
                Designation::query()
                ->where('floor_id', $this->floor_id)
                ->where('current', 1)
                ->with(['room_boy.user'])
                ->get() : [],
        ]);
    }
}

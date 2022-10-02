<?php

namespace App\Http\Livewire\Superadmin;

use App\Models\Floor;
use App\Models\Room;
use App\Models\RoomStatus;
use App\Models\Type;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class BranchRoom extends Component
{
    use Actions;
    use WithPagination;
    public $branch_id;
    public $floor_modal = false;
    public $create_modal = false;
    public $edit_modal = false;
    public $floor_number;
    public $floor_id = 1;
    public $room_status = 1;
    public $description;
    public $type_id = 1;
    public $room_id;


    public function editRoom($id){
        $this->edit_modal = true;
        $room = Room::where('id',$id)->first();
        $this->floor_number = $room->number;
        $this->floor_id = $room->floor_id;
        $this->room_status = $room->room_status_id;
        $this->description = $room->description;
        $this->type_id = $room->type_id;
        $this->room_id = $room->id;
    }

    public function mount($branch)
    {
        $this->branch_id = $branch;
    }

    public function render()
    {
        return view('livewire.superadmin.branch-room',[
            'rooms' => Room::whereHas('floor', function($query){
                $query->where('branch_id', $this->branch_id);
            })->with(['floor', 'room_status','type'])->paginate(10),
            'floors' => Floor::where('branch_id', $this->branch_id)->get(),
            'room_statuses' => RoomStatus::all(),
            'types' => Type::where('branch_id', $this->branch_id)->get(),
        ]);
    }
    public function saveFloor()
    {
        $this->validate([
            'floor_number' => 'required|numeric|min:1|unique:floors,number',
        ]);
        // auth()->user()->branch->floors()->create([
        //     'number' => $this->floor_number,
        // ]);
        Floor::create([
            'number' => $this->floor_number,
            'branch_id' => $this->branch_id,
        ]);
        $this->reset('floor_number');
        $this->create_modal = false;
        $this->notification()->success(
            $title = 'Success',
            $description = 'Floor created successfully',
        );
    }

    public function updateRoom(){

        $this->validate([
            'floor_number' => 'required|numeric|min:1',
            'floor_id' => 'required',
            'room_status' => 'required',
            'type_id' => 'required',
        ]);
        $room = Room::find($this->room_id);
        $room->update([
            'number' => $this->floor_number,
            'floor_id' => $this->floor_id,
            'room_status_id' => $this->room_status,
            'type_id' => $this->type_id,
            'description' => $this->description,
        ]);
        $this->edit_modal = false;
        $this->reset('floor_number','floor_id','room_status','type_id','description');
        $this->notification()->success(
            $title = 'Success',
            $description = 'Room updated successfully',
        );
    }

    public function saveRoom(){
       
        $this->validate([
            'floor_number' => 'required|numeric|min:1|unique:rooms,number',
            'floor_id' => 'required',
            'room_status' => 'required',
            'type_id' => 'required',
        ]);
        Room::create([
            'floor_id' => $this->floor_id,
            'number' => $this->floor_number,
            'room_status_id' => $this->room_status,
            'description' => $this->description,
            'type_id' => $this->type_id,
        ]);
      
        $this->reset('floor_number', 'floor_id', 'room_status', 'type_id', 'description');
        $this->notification()->success(
            $title = 'Success',
            $description = 'Room created successfully',
        );
        $this->create_modal = false;
    }
}

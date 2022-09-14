<?php

namespace App\Http\Livewire\BranchAdmin;

use App\Models\Room;
use App\Models\RoomStatus;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;

class RoomList extends Component
{
    use WithPagination, Actions;
    public $floors=[],$roomStatuses=[];
    public $filter=[
        'floor'=>'all',
        'room_status'=>'all',
    ];
    public $search='';
    public $showModal=false;
    public $mode='create';
    public $number, $description, $floor_id="", $room_status_id="",$type_id="";
    public $edit_id=null;
    public $roomTypes=[];
    public function getModeTitle()
    {
        return $this->mode=='create' ? 'Create Room' : 'Update Room';
    }
    public function add()
    {
        $this->reset('number', 'description', 'floor_id', 'room_status_id','type_id');
        $this->mode='create';
        $this->showModal=true;
    }
    public function edit($edit_id)
    {
        $this->mode = 'update';
        $this->edit_id = $edit_id;
        $room = Room::find($edit_id);
        $this->number = $room->number;
        $this->description = $room->description;
        $this->floor_id = $room->floor_id;
        $this->room_status_id = $room->room_status_id;
        $this->type_id = $room->type_id;
        $this->showModal = true;
    }
    public function save()
    {
        $this->validate([
            'number' => 'required|numeric|min:1|unique:rooms,number,'.$this->edit_id,
            'floor_id' => 'required',
            'room_status_id' => 'required',
            'type_id' => 'required',
        ]);
        if ($this->mode=='create') {
            $this->create();
        }else{
            $this->update();
        }
    }
    public function create()
    {
        Room::create([
            'number' => $this->number,
            'floor_id' => $this->floor_id,
            'room_status_id' => $this->room_status_id,
            'type_id' => $this->type_id,
        ]);
        $this->showModal = false;
        $this->reset('number', 'floor_id', 'room_status_id', 'type_id');
        $this->notification()->success(
            $title = 'Success',
            $description = 'Room created successfully',
        );
    }
    public function update()
    {
        $room = Room::find($this->edit_id);
        $room->update([
            'number' => $this->number,
            'floor_id' => $this->floor_id,
            'room_status_id' => $this->room_status_id,
            'type_id' => $this->type_id,
        ]);
        $this->showModal = false;
        $this->reset('number', 'floor_id', 'room_status_id', 'type_id');
        $this->notification()->success(
            $title = 'Success',
            $description = 'Room updated successfully',
        );
    }
    public function mount()
    {
        $this->floors = auth()->user()->branch->floors;
        $this->roomStatuses = RoomStatus::all();
        $this->roomTypes = auth()->user()->branch->types;
    }
    public function render()
    {
        return view('livewire.branch-admin.room-list',[
            'rooms'=>Room::query()
                    ->when($this->filter['floor']!='all',function($query){
                        return $query->where('floor_id',$this->filter['floor']);
                    })
                    ->when($this->filter['room_status']!='all',function($query){
                        return $query->where('room_status_id',$this->filter['room_status']);
                    })
                    ->when($this->search!='',function($query){
                        return $query->where('number','like','%'.$this->search.'%');
                    })
                    ->with(['floor','room_status','type'])
                    ->paginate(10)
        ]);
    }
}

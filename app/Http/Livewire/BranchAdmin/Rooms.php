<?php

namespace App\Http\Livewire\BranchAdmin;

use App\Models\Room;
use App\Models\RoomStatus;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Rooms extends Component
{
    use WithPagination, Actions;

    public $mode = 'create';

    public $showModal = false;

    public $floors = [];

    public $roomStatuses = [];

    public $filter = [
        'floor' => 'all',
        'room_status' => 'all',
    ];

    public $search = '';

    public $number;

    public $description;

    public $floor_id = '';

    public $room_status_id = '';

    public $type_id = '';

    public $edit_id = null;

    public $roomTypes = [];

    public $floor_number;

    public $manageFloorModal = false;

    public $room = null;

    protected function rules()
    {
        if ($this->mode == 'create') {
            return [
                'number' => 'required|numeric|min:1',
                'floor_id' => 'required',
                'room_status_id' => 'required',
                'type_id' => 'required',
            ];
        } else {
            return [
                'number' => 'required|numeric|min:1|unique:rooms,number,' . $this->edit_id,
                'floor_id' => 'required',
                'room_status_id' => 'required',
                'type_id' => 'required',
            ];
        }
    }

    public function edit($edit_id)
    {
        $this->edit_id = $edit_id;
        $this->room = Room::find($edit_id);
        // if ($this->room->status_is() != available() 
        // && $this->room->status_is() != unavailable()
        // &&  $this->room->status_is() != maintenance()
        // &&  $this->room->status_is() != reserved()
        // &&  $this->room->status_is() != uncleaned()
        // ) {
        //     $this->dialog()->error(
        //         $title = 'Error',
        //         $description = 'Room is not available for editing',
        //     );
        //     return;
        // }
        $this->number = $this->room->number;
        $this->description = $this->room->description;
        $this->floor_id = $this->room->floor_id;
        $this->room_status_id = $this->room->room_status_id;
        $this->type_id = $this->room->type_id;
        $this->mode = 'edit';
        $this->showModal = true;
    }

    public function create()
    {
        $this->validate();

        $room_exist_in_this_branch = Room::where('number', $this->number)
            ->whereHas('floor', function ($query) {
                $query->where('branch_id', auth()->user()->branch_id);
            })->exists();

        if ($room_exist_in_this_branch) {
            $this->notification()->error(
                $title = 'Error',
                $description = 'Room number already exist in this branch',
            );
            return;
        }

        Room::create([
            'number' => $this->number,
            'floor_id' => $this->floor_id,
            'room_status_id' => $this->room_status_id,
            'type_id' => $this->type_id,
        ]);

        $this->clear_fields_and_close_modal();

        $this->notification()->success(
            $title = 'Success',
            $description = 'Room created successfully',
        );

    }

    public function update()
    {
        $this->validate();

        $this->room->update([
            'number' => $this->number,
            'floor_id' => $this->floor_id,
            'room_status_id' => $this->room_status_id,
            'type_id' => $this->type_id,
        ]);

        $this->clear_fields_and_close_modal();

        $this->notification()->success(
            $title = 'Success',
            $description = 'Successfully Updated'
        );

    }

    public function mount()
    {
        $this->roomStatuses = RoomStatus::get();
        $this->roomTypes = auth()->user()->branch->types;
    }

    public function saveFloor()
    {
        $this->validate([
            'floor_number' => 'required|numeric|min:1',
        ]);

        $floor_exist_in_this_branch = auth()->user()->branch->floors()->where('number', $this->floor_number)->exists();

        if ($floor_exist_in_this_branch) {
            $this->notification()->error(
                $title = 'Error',
                $description = 'Floor number already exist in this branch',
            );
            return;
        }

        auth()->user()->branch->floors()->create([
            'number' => $this->floor_number,
        ]);

        $this->reset('floor_number');

        $this->notification()->success(
            $title = 'Success',
            $description = 'Floor created successfully',
        );
    }

    public function render()
    {
        $this->floors = auth()->user()->branch->floors;
        return view('livewire.branch-admin.rooms', [
            'rooms' => Room::query()
                ->when($this->filter['floor'] != 'all', function ($query) {
                    return $query->where('floor_id', $this->filter['floor']);
                })
                ->when($this->filter['room_status'] != 'all', function ($query) {
                    return $query->where('room_status_id', $this->filter['room_status']);
                })
                ->when($this->search != '', function ($query) {
                    return $query->where('number', 'like', '%' . $this->search . '%');
                })
                ->with(['floor', 'room_status', 'type'])
                ->paginate(10),
        ]);
    }

    public function add()
    {
        $this->reset('number', 'description', 'floor_id', 'room_status_id', 'type_id');
        $this->mode = 'create';
        $this->showModal = true;
    }

    public function getModeTitle()
    {
        return $this->mode == 'create' ? 'Add New Room' : 'Edit Room';
    }

    public function clear_fields_and_close_modal()
    {
        $this->showModal = false;
        $this->reset('number', 'floor_id', 'room_status_id', 'type_id');
    }
}

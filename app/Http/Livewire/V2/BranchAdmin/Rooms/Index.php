<?php

namespace App\Http\Livewire\V2\BranchAdmin\Rooms;

use App\Models\Room;
use App\Models\Type;
use App\Models\Floor;
use Livewire\Component;
use App\Models\RoomStatus;
use App\Traits\WithCaching;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithCaching;

    public $search = '';

    public $editMode = false;

    public $floors =[], $types = [], $roomStatuses = [];

    public $form;

    public function rules()
    {
        return [
            'form.number' => 'required',
            'form.description' => 'nullable',
            'form.time_to_clean' => 'nullable',
            'form.type_id' => 'required',
            'form.floor_id' => 'required',
            'form.room_status_id' => 'required',
            'form.time_to_terminate_in_queue' => 'nullable',
            'form.priority' => 'nullable',
            'form.last_check_out_at' => 'nullable',
        ];
    }

    public function makeForm()
    {
        $this->form = Room::make(['priority' => 0]);
    }

    public function getRoomsQueryProperty()
    {
        return Room::query();
    }

    public function getRoomsProperty()
    {
        if ($this->search != '') {
            $this->roomsQuery->where('number', 'like', '%' . $this->search . '%');
        }
        return $this->cache(function () {
            return $this->roomsQuery->with(['room_status', 'floor'])->paginate(10);
        }, 'rooms');
    }

    public function create()
    {
        $this->useCacheRows();
        $this->editMode = false;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function save()
    {

        if ($this->editMode) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function store()
    {
        $this->validate();

        $this->form->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('notify',[
            'type' => 'success',
            'title' => 'Room Created',
            'message' => 'Room created successfully'
        ]);
    }

    public function edit(Room $room)
    {
        $this->useCacheRows();
        $this->editMode = true;
        $this->form = $room;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function update()
    {
        $this->validate();

        $this->form->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('notify',[
            'type' => 'success',
            'title' => 'Room Updated',
            'message' => 'Room updated successfully'
        ]);
    }

    public function mount()
    {
        $this->roomStatuses = RoomStatus::all();
        $this->floors = Floor::where('branch_id', auth()->user()->branch_id)->get();
        $this->types = Type::where('branch_id', auth()->user()->branch_id)->get();
        $this->makeForm();
    }

    public function render()
    {
        return view('livewire.v2.branch-admin.rooms.index', [
            'rooms' => $this->rooms,
        ]);
    }
}

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

    // done validation attributes
    use WithPagination, WithCaching;

    public $search = '';

    public $editMode = false;

    public $floors =[], $types = [], $roomStatuses = [];

    public $form;

    public $filters = [
        'floor_id' => '',
        'type_id' => '',
        'room_status_id' => '',
    ];

    protected $validationAttributes = [
        'form.number' => 'room number',
        'form.floor_id' => 'floor',
        'form.type_id' => 'type',
        'form.room_status_id' => 'room status',
    ];

    public function rules()
    {
        if ($this->editMode) {
            return [
                'form.number' => 'required|numeric|unique:rooms,number,' . $this->form['id'],
                'form.description' => 'nullable',
                'form.time_to_clean' => 'nullable',
                'form.type_id' => 'required',
                'form.floor_id' => 'required',
                'form.room_status_id' => 'required',
                'form.time_to_terminate_in_queue' => 'nullable',
                'form.priority' => 'nullable',
                'form.last_check_out_at' => 'nullable',
            ];
        }else{
            return [
                'form.number' => 'required|numeric|unique:rooms,number',
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
    }

    public function clearFilter()
    {
        $this->reset('filters');
    }

    public function hasFilters()
    {
        return $this->filters['floor_id'] || $this->filters['type_id'] || $this->filters['room_status_id'];
    }

    public function makeForm()
    {
        $this->form = Room::make(['priority' => 0]);
    }

    public function getRoomsQueryProperty()
    {
        return Room::whereHas('floor', function ($query) {
            $query->where('branch_id', auth()->user()->branch_id);
        });
    }

    public function getRoomsProperty()
    {
        if ($this->search != '') {
            $this->roomsQuery->where('number', 'like', '%' . $this->search . '%');
        }

        if ($this->filters['room_status_id'] != '') {
            $this->roomsQuery->where('room_status_id', $this->filters['room_status_id']);
        }
    
        if ($this->filters['floor_id'] != '') {
            $this->roomsQuery->where('floor_id', $this->filters['floor_id']);
        }

        return $this->cache(function () {
            return $this->roomsQuery->with(['room_status', 'floor','type'])->paginate(10);
        }, 'rooms');
    }

    public function create()
    {
        $this->useCacheRows();
        $this->makeForm();
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

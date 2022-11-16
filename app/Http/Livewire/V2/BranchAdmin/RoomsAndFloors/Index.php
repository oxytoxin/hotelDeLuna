<?php

namespace App\Http\Livewire\V2\BranchAdmin\RoomsAndFloors;

use App\Models\Room;
use App\Models\Type;
use App\Models\Floor;
use Livewire\Component;
use App\Models\RoomStatus;
use App\Traits\WithCaching;
use Livewire\WithPagination;

class Index extends Component
{
    use WithCaching, WithPagination;

    public $floors=[];

    public $types=[];

    public $form;

    public $roomStatuses = [];

    public $editMode = false;

    public function rules()
    {
        return [
            'form.floor_id' => 'nullable',
            'form.number' => 'required|unique:rooms,number,' . $this->form->id,
            'form.description' => 'nullable',
            'form.time_to_clean' => 'nullable',
            'form.type_id' => 'required',
            'form.time_to_terminate_in_queue' => 'nullable',
            'form.priority' => 'nullable',
            'form.last_check_out_at' => 'nullable',
        ];
    }

    public function getRoomsQueryProperty()
    {
        return Room::query();
    }

    public function getRoomsProperty()
    {
        return $this->cache(function () {
            return $this->roomsQuery->with(['room_status','floor'])->paginate(10);
        },'rooms');
    }

    public function makeForm()
    {
        $this->form =  Room::make();
    }

    public function create()
    {
        $this->makeForm();
        $this->useCacheRows();
        $this->editMode = false;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function save()
    {
        if($this->editMode){
            $this->update();
        }else{
            $this->store();
        }
    }

    public function store()
    {

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
        return view('livewire.v2.branch-admin.rooms-and-floors.index',[
            'rooms' => $this->rooms,
        ]);
    }
}

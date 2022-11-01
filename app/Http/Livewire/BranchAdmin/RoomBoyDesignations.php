<?php

namespace App\Http\Livewire\BranchAdmin;

use Livewire\Component;
use App\Models\{Designation,RoomBoy,Floor,User};

use Livewire\WithPagination;
use WireUi\Traits\Actions;
use App\Traits\WithCaching;

class RoomBoyDesignations extends Component
{
    use WithPagination, Actions, WithCaching;

    public $designation;

    public $manageDesignationModal = false;

    public $searchRoomBoy;

    public $roomBoysList = [];

    public $floors = [];

    public $floors_filter = [];

    public $filter = [
        'floor_id'=>''
    ];

    public $room_boy;

    public $search;

    protected $validationAttributes = [
        'floor_id'=>'Floor'
    ];

    public function rules()
    {
        return [
            'designation.floor_id' => 'required',
            'designation.room_boy_id' => 'required',
            'designation.current' => 'required',
        ];
    }

    public function updatedSearchRoomBoy()
    {
        $this->useCacheRows();
        $this->roomBoysList = User::where('branch_id', auth()->user()->branch_id)
            ->where('role_id', 5)
            ->where('name', 'like', '%' . $this->searchRoomBoy . '%')
            ->orWhere('email', 'like', '%' . $this->searchRoomBoy . '%')
            ->with(['room_boy'])
            ->get(['id', 'name']);
    }

    public function getRoomBoysQueryProperty()
    {
        return RoomBoy::whereHas('user', function ($query) {
            $query->where('branch_id', auth()->user()->branch_id);
        })->with(['user', 'designations'=>function($query){
            $query->where('current',1)
            ->with(['floor']);
        }]);
    }

    public function getRoomBoysProperty()
    {
        if ($this->search) {
            $this->roomBoysQuery->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filter['floor_id']) {
            $this->roomBoysQuery->whereHas('designations', function ($query) {
                $query->where('floor_id', $this->filter['floor_id'])
                    ->where('current', 1);
            });
        }

        return $this->cache(function () {
            return $this->roomBoysQuery->paginate(10);
        });
    }

    public function manageDesignation($room_boy_id)
    {
        $this->useCacheRows();
        $this->designation = Designation::make([
            'room_boy_id'=>$room_boy_id,
            'current' => 1,
        ]);

        $this->room_boy = $this->roomBoys->find($room_boy_id);
        $curren_designated_floors = $this->room_boy->designations()->where('current',1)->pluck('floor_id')->toArray();
        $this->floors = Floor::where('branch_id', auth()->user()->branch_id)
            ->whereNotIn('id',$curren_designated_floors)
            ->get();

        $this->manageDesignationModal = true;
    }

    public function save()
    {
        $this->validate();
        $this->room_boy->designations()->where('current',1)->update([
            'current' => 0,
        ]);

        $this->designation->save();

        $this->manageDesignationModal = false;

        $this->notification()->success( 'Save successfully');

    }

    public function mount()
    {
        $this->floors_filter = Floor::where('branch_id', auth()->user()->branch_id)->get();
    }

    public function render()
    {
        return view('livewire.branch-admin.room-boy-designations',[
            'roomBoys' => $this->roomBoys,
        ]);
    }
}

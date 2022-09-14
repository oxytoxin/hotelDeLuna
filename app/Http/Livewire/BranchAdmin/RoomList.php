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
    protected $listeners = [
        'refreshTable' => '$refresh',
    ];
    public $filter=[
        'floor'=>'all',
        'room_status'=>'all',
    ];
    public $search='';
    public function mount()
    {
        $this->floors = auth()->user()->branch->floors;
        $this->roomStatuses = RoomStatus::all();
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

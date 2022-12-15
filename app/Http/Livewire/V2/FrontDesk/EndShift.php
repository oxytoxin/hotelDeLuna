<?php

namespace App\Http\Livewire\V2\FrontDesk;

use App\Models\User;
use Livewire\Component;
use App\Models\ShiftLog;
use App\Models\Frontdesk;
use App\Traits\WithCaching;
use Illuminate\Support\Facades\DB;

class EndShift extends Component
{
    //traits
    use WithCaching;

    //listeners

    //public properties
    public $show= false;
    public $floors = [];

    //protected properties

    protected $listeners=['confirmEndShift'];

    public function endShift()
    {
        $this->dispatchBrowserEvent('confirm',[
            'title' => 'Are you sure?',
            'message' => 'Are you sure you want to end your shift?',
            'confirmButtonText' => 'Continue', // default 'Confirm'
            'cancelButtonText' => 'No', // default 'Cancel',
            'confirmMethod' => 'confirmEndShift', // must register in protected $listeners property of livewire ex. protected $listener = ['confirm'];
        ]);
    }

    public function confirmEndShift()
    {
        DB::beginTransaction();
        // convert assigned_frontdesks to array and format like this [1,2,3]
        $ids = json_decode(auth()->user()->assigned_frontdesks);
        $frontdesks = Frontdesk::whereIn('id',$ids)->get();
        ShiftLog::create([
            'name' => $frontdesks->pluck('name')->implode(' and '),
            'ids' => auth()->user()->assigned_frontdesks,
            'time_in' => auth()->user()->time_in,
            'time_out' => now(),
        ]);

        auth()->user()->update([
            'assigned_frontdesks' => null,
            'time_in' => null
        ]);
        DB::commit();

        return redirect()->route('front-desk.assign-frontdesk');
    }

    public function render()
    {
        if ($this->show) {
            $this->floors = \App\Models\Floor::where('branch_id',auth()->user()->branch_id)->get();
        }
        return view('livewire.v2.front-desk.end-shift',[
           'frontdesks' => $this->show ? Frontdesk::whereIn('id',json_decode(auth()->user()->assigned_frontdesks))->get() : [],
           'transactions' => $this->show ? \App\Models\Transaction::where('paid_at','!=',null)->where('paid_at','>=',auth()->user()->time_in)
           ->where('paid_at','<=',now())
           ->where('branch_id',auth()->user()->branch_id)
           ->with(['room.floor'])
            ->get()
            ->groupBy('room.floor_id') : [],
            'new_guest_count' => $this->show ? \App\Models\Guest::where('branch_id',auth()->user()->branch_id)
            ->where('check_in_at','!=',null)
            ->where('check_in_at','>=',auth()->user()->time_in)
            ->count() : [],
            'total_extended_guest_count' => $this->show ? \App\Models\Guest::whereHas('stayExtensions')->where('branch_id',auth()->user()->branch_id)->count() : [],
            'unoccupied_rooms' => $this->show ? \App\Models\Room::whereHas('floor',function($q){
                $q->where('branch_id',auth()->user()->branch_id);
            })->whereDoesntHave('check_in_details',function($q){
                $q->where('check_in_at','!=',null)->where('check_in_at','>=',auth()->user()->time_in);
            })->get('number') : [],
        ]);
    }
}

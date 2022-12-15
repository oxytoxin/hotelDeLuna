<?php

namespace App\Http\Livewire\V2\FrontDesk;

use Livewire\Component;
use App\Traits\WithCaching;
use App\Models\Frontdesk;
class AssignFrontDesk extends Component
{
    //traits
    use WithCaching;

    //listeners

    //protected properties

    //public properties
    public $search = '';
    public $frontdesks =[];
    public $selecteds =[];

    public function select($id,$name)
    {
        // push with key
        $this->selecteds[$id] = $name;
        // remove from frontdesks
        $this->frontdesks = $this->frontdesks->filter(function($value, $key) use ($id) {
            return $value->id != $id;
        });
    }

    public function startShift()
    {
        auth()->user()->update([
            'assigned_frontdesks' => json_encode(array_keys($this->selecteds)),
            'time_in' => now()
        ]);

        return redirect()->route('branch.dashboard');
    }

    public function mount()
    {
        //code ....
    }
    public function render()
    {
        $this->frontdesks = Frontdesk::where('name','like','%'.$this->search.'%')
                    ->where('branch_id',auth()->user()->branch_id)
                    ->whereNotIn('id',array_keys($this->selecteds))
                    ->get()->take(5);
        return view('livewire.v2.front-desk.assign-front-desk');
    }
}

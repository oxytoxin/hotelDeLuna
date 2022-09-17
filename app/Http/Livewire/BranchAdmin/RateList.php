<?php

namespace App\Http\Livewire\BranchAdmin;

use App\Models\Rate;
use App\Models\StayingHour;
use App\Models\Type;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class RateList extends Component
{
    use WithPagination, Actions;

    public $staying_hour_id = '';

    public $room_type_id = '';

    public $amount;

    public $mode = 'create';

    public $showModal = false;

    public $hours = [];

    public $types = [];

    public $edit_id = null;

    public function getModeTitle()
    {
        return $this->mode == 'create' ? 'Create Rate' : 'Update Rate';
    }

    public function add()
    {
        $this->reset('staying_hour_id', 'room_type_id', 'amount');
        $this->mode = 'create';
        $this->showModal = true;
    }

    public function edit($edit_id)
    {
        $this->mode = 'update';
        $this->edit_id = $edit_id;
        $rate = Rate::find($edit_id);
        $this->staying_hour_id = $rate->staying_hour_id;
        $this->room_type_id = $rate->type_id;
        $this->amount = $rate->amount;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'staying_hour_id' => 'required',
            'room_type_id' => 'required',
            'amount' => 'required|numeric|min:1',
        ]);
        if ($this->mode == 'create') {
            $this->create();
        } else {
            $this->update();
        }
    }

    public function create()
    {
        Rate::create([
            'branch_id' => auth()->user()->branch->id,
            'staying_hour_id' => $this->staying_hour_id,
            'type_id' => $this->room_type_id,
            'amount' => $this->amount,
        ]);
        $this->showModal = false;
        $this->reset('staying_hour_id', 'room_type_id', 'amount');
        $this->notification()->success(
            $title = 'Success',
            $description = 'Rate created successfully'
        );
    }

    public function update()
    {
        Rate::find($this->edit_id)->update([
            'staying_hour_id' => $this->staying_hour_id,
            'type_id' => $this->room_type_id,
            'amount' => $this->amount,
        ]);
        $this->showModal = false;
        $this->reset('staying_hour_id', 'room_type_id', 'amount');
        $this->notification()->success(
            $title = 'Success',
            $description = 'Rate updated successfully'
        );
    }

     public function mount()
     {
         $this->hours = StayingHour::all();
         $this->types = Type::where('branch_id', auth()->user()->branch->id)->get();
     }

    public function render()
    {
        return view('livewire.branch-admin.rate-list', [
            'rates' => Rate::query()
                    ->where('branch_id', auth()->user()->branch_id)
                    ->with('staying_hour', 'type')
                    ->paginate(10),
        ]);
    }
}

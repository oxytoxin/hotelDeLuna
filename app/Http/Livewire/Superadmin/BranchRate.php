<?php

namespace App\Http\Livewire\Superadmin;

use App\Models\StayingHour;
use App\Models\Type;
use App\Models\Rate;
use Livewire\Component;
use WireUi\Traits\Actions;

class BranchRate extends Component
{
    use Actions;
    public $branch_id;
    public $create_modal = false;
    public $edit_modal = false;
    public $hours_id = 1;
    public $type_id;
    public $edit_id;
    public $rate;
    public $search_rate = '';

    public function mount($branch)
    {
        $this->branch_id = $branch;
    }

    public function render()
    {
        return view('livewire.superadmin.branch-rate', [
            'types' => Type::where('branch_id', $this->branch_id)->with(['rates.staying_hour', 'branch'])->get(),
            'hours' => StayingHour::all(),
        ]);
    }

    public function saveRate()
    {
        $this->validate([
            'hours_id' => 'required',
            'type_id' => 'required',
            'rate' => 'required',
        ]);
        $query = Rate::where('staying_hour_id', $this->hours_id)
                ->where('type_id', $this->type_id)
                ->where('amount', $this->rate)
                ->where('branch_id', $this->branch_id)
                ->first();

            if ($query) {
                $this->notification()->error(
                    $title = 'Rate already exists',
                    $description = 'The rate you are trying to add already exists.'
                );
                return;
            }
            Rate::create([
                'branch_id' => $this->branch_id,
                'staying_hour_id' => $this->hours_id,
                'type_id' => $this->type_id,
                'amount' => $this->rate,
            ]);
            $this->create_modal = false;
            $this->reset('hours_id', 'type_id', 'rate');
            $this->notification()->success(
                $title = 'Success',
                $description = 'Rate created successfully'
            );
    }

    public function editRate($id)
    {
        $rate = Rate::where('id',$id)->first();
        $this->hours_id = $rate->staying_hour_id;
        $this->type_id = $rate->type_id;
        $this->rate = $rate->amount;
        $this->edit_id = $id;
        $this->edit_modal = true;
    }

    public function updateRate()
    {
        
        $this->validate([
            'hours_id' => 'required',
            'type_id' => 'required',
            'rate' => 'required',
        ]);
        $query = Rate::where('staying_hour_id', $this->hours_id)
        ->where('type_id', $this->type_id)
        ->where('amount', $this->rate)
        ->where('branch_id', $this->branch_id)
        ->where('id', '!=', $this->edit_id)
        ->first();

    if ($query) {
        $this->notification()->error(
            $title = 'Rate already exists',
            $description = 'The rate you are trying to add already exists.'
        );
        return;
    }
            Rate::find($this->edit_id)->update([
                'staying_hour_id' => $this->hours_id,
                'type_id' => $this->type_id,
                'amount' => $this->rate,
            ]);
            $this->edit_modal = false;
            $this->reset('hours_id', 'type_id', 'rate');
            $this->notification()->success(
                $title = 'Success',
                $description = 'Rate updated successfully'
            );
    }
}

<?php

namespace App\Http\Livewire\V2\BranchAdmin\Rates;

use App\Models\Rate;
use App\Models\Type;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\StayingHour;
use App\Traits\WithCaching;

class Index extends Component
{
    use WithCaching, Actions;

    public $editMode = false;

    public $stayingHours = [];

    public $roomTypes = [];

    public $form;

    public function rules()
    {
        return [
            'form.branch_id' => 'nullable',
            'form.staying_hour_id' => 'required',
            'form.type_id' => 'required',
            'form.amount' => 'required',
        ];
    }

    public function makeForm()
    {
        $this->form = Rate::make(['branch_id' => auth()->user()->branch_id]);
    }

    public function getRateGroupedByTypeQueryProperty()
    {
        return  Type::where('branch_id', auth()->user()->branch->id)->with(['rates.staying_hour']);
    }

    public function getRateGroupedByTypeProperty()
    {
        return $this->cache(function () {
            return $this->rateGroupedByTypeQuery->get();
        },'rateGroupedByType');
    }

    public function save()
    {
         if($this->editMode){
            $this->update();
         }else{
            $this->store();
         }
    }

    public function create()
    {
        $this->makeForm();
        $this->useCacheRows();
        $this->editMode = false;
        $this->dispatchBrowserEvent('show-create-modal');
    }

    public function store()
    {
        $this->validate();

        $rateExist = Rate::where('branch_id', $this->form->branch_id)
            ->where('type_id', $this->form->type_id)
            ->where('staying_hour_id', $this->form->staying_hour_id)
            ->first();

        if($rateExist){
            session()->flash('error', 'Rate already exist !');
            return;
        }

        $rateExist = Rate::where('branch_id', $this->form->branch_id)
            ->where('type_id', $this->form->type_id)
            ->where('staying_hour_id', $this->form->staying_hour_id)
            ->where('amount', $this->form->amount)
            ->first();
        
        if($rateExist){
            session()->flash('error', 'Rate already exist !');
            return;
        }

        $this->form->save();
        $this->dispatchBrowserEvent('close-create-modal');
        $this->dispatchBrowserEvent('notify',[
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Rate created successfully!'
        ]);
    }

    public function edit(Rate $rate)
    {
        $this->form = $rate;
        $this->useCacheRows();
        $this->editMode = true;
        $this->dispatchBrowserEvent('show-edit-modal');
    }

    public function update()
    {
        $this->validate();

        $rateExist = Rate::where('branch_id', $this->form->branch_id)
            ->where('type_id', $this->form->type_id)
            ->where('staying_hour_id', $this->form->staying_hour_id)
            ->where('id', '!=', $this->form->id)
            ->first();

        if($rateExist){
            session()->flash('error', 'Rate already exist !');
            return;
        }

        $rateExist = Rate::where('branch_id', $this->form->branch_id)
            ->where('type_id', $this->form->type_id)
            ->where('staying_hour_id', $this->form->staying_hour_id)
            ->where('amount', $this->form->amount)
            ->where('id', '!=', $this->form->id)
            ->first();
        
        if($rateExist){
            session()->flash('error', 'Rate already exist !');
            return;
        }

        $this->form->save();
        $this->dispatchBrowserEvent('close-edit-modal');
        $this->dispatchBrowserEvent('notify',[
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Rate updated successfully!'
        ]);
    }

   


    public function mount()
    {
        $this->stayingHours = StayingHour::where('branch_id', auth()->user()->branch->id)->get('id', 'number');
        $this->roomTypes = Type::where('branch_id', auth()->user()->branch->id)->get('id', 'name');
        $this->makeForm();
    }

    public function render()
    {
        return view('livewire.v2.branch-admin.rates.index',[
            'types' => $this->rateGroupedByType,
        ]);
    }
}

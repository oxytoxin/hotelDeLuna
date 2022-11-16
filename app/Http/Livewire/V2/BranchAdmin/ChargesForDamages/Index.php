<?php

namespace App\Http\Livewire\V2\BranchAdmin\ChargesForDamages;

use App\Models\HotelItem;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithCaching;
class Index extends Component
{
    use WithCaching, WithPagination;

    public $editMode = false;

    public $search = '';

    public $form;

    public $listeners = ['deleteChargesForDamages'];

    public function rules()
    {
        return [
            'form.branch_id' => 'required',
            'form.name' => 'required|unique:hotel_items,name,' . $this->form->id,
            'form.price' => 'required',
        ];
    }

    public function getChargesForDamagesQueryProperty()
    {
        return HotelItem::where('branch_id', auth()->user()->branch_id);
    }

    public function getChargesForDamagesProperty()
    {

        if ($this->search) {
            $this->chargesForDamagesQuery->where('name', 'like', '%' . $this->search . '%');
        }

        return $this->cache(function () {
            return $this->chargesForDamagesQuery->paginate(10);
        },'chargesForDamages');
    }

    public function makeForm()
    {
        $this->form = HotelItem::make([
            'branch_id' => auth()->user()->branch->id,
        ]);
    }

    public function create()
    {
        $this->useCacheRows();
        $this->editMode = false;
        $this->makeForm();
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
        $this->validate();

        $this->form->save();

        $this->dispatchBrowserEvent('close-modal');

        $this->makeForm();

        $this->dispatchBrowserEvent('notify',[
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Record created successfully',
        ]);

    }

    public function edit(HotelItem $chargesForDamages)
    {
        $this->useCacheRows();
        $this->editMode = true;
        $this->form = $chargesForDamages;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function update()
    {
        $this->validate();

        $this->form->save();

        $this->dispatchBrowserEvent('close-modal');

        $this->makeForm();

        $this->dispatchBrowserEvent('notify',[
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Record Updated Successfully',
        ]);
    }

    public function deleteChargesForDamages($chargesForDamageId)
    {
        $chargesForDamages = HotelItem::find($chargesForDamageId);

        $chargesForDamages->delete();

        $this->dispatchBrowserEvent('notify',[
            'type' => 'success',
            'title' => 'Deleted Successfully',
            'message' => 'Record has been deleted Successfully',
        ]);
    }


    public function render()
    {
        return view('livewire.v2.branch-admin.charges-for-damages.index',[
            'chargesForDamages' => $this->chargesForDamages,
        ]);
    }
}

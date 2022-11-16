<?php

namespace App\Http\Livewire\V2\BranchAdmin\Amenities;

use App\Models\RequestableItem;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithCaching;
class Index extends Component
{
    use WithCaching, WithPagination;

    public $editMode = false;

    public $search = '';

    public $form;

    public $listeners = ['deleteAmenity'];

    public function rules()
    {
        return [
            'form.branch_id' => 'required',
            'form.name' => 'required|unique:requestable_items,name,' . $this->form->id,
            'form.price' => 'required',
        ];
    }

    public function getAmenitiesQueryProperty()
    {
        return RequestableItem::where('branch_id', auth()->user()->branch_id);
    }


    public function getAmenitiesProperty()
    {

        if ($this->search) {
            $this->amenitiesQuery->where('name', 'like', '%' . $this->search . '%');
        }

        return $this->cache(function () {
            return $this->amenitiesQuery->paginate(10);
        },'amenities');
    }

    public function makeForm()
    {
        $this->form = RequestableItem::make([
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

    public function edit(RequestableItem $amenity)
    {
        $this->useCacheRows();
        $this->editMode = true;
        $this->form = $amenity;
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
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Record has been created successfully',
        ]);
    }

    public function update()
    {
        $this->validate();

        $this->form->save();

        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Record has been updated successfully',
        ]);
    }

    public function deleteAmenity(RequestableItem $amenity)
    {
        $amenity->delete();
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Record has been deleted successfully',
        ]);
    }
    public function render()
    {
        return view('livewire.v2.branch-admin.amenities.index',[
            'amenities' => $this->amenities,
        ]);
    }
}

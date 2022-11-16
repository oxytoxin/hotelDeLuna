<?php

namespace App\Http\Livewire\V2\BranchAdmin\Discounts;

use Livewire\Component;
use App\Models\Discount;
use App\Traits\WithCaching;
use Livewire\WithPagination;

class Index extends Component
{
    use WithCaching, WithPagination;

    public $editMode = false;

    public $search = '';

    public $form;

    protected $listeners = ['confirmMakeUnavailable', 'confirmMakeAvailable','deleteDiscount'];

    public function rules()
    {
        return [
            'form.branch_id' => 'required',
            'form.name' => 'required|unique:discounts,name,' . $this->form->id,
            'form.description' => 'required',
            'form.amount' => 'required|numeric',
            'form.is_percentage' => 'required|in:0,1',
            'form.is_available' => 'required',
        ];
    }

    public function makeForm()
    {
        $this->form = Discount::make([
            'branch_id' => auth()->user()->branch->id,
            'is_percentage' => 0,
            'is_available' => 1,
        ]);
    }

    public function getDiscountsQueryProperty()
    {
        return Discount::where('branch_id', auth()->user()->branch_id);
    }

    public function getDiscountsProperty()
    {

        if ($this->search) {
            $this->discountsQuery->where('name', 'like', '%' . $this->search . '%');
        }

        return $this->cache(function () {
            return $this->discountsQuery->paginate(10);
        },'discounts');

    }

    public function create()
    {
        $this->useCacheRows();
        $this->makeForm();
        $this->editMode = false;
        $this->dispatchBrowserEvent('show-modal');
    }

    public function save()
    {
        if ($this->editMode) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function store()
    {
        $this->validate();

        $this->form->save();

        $this->dispatchBrowserEvent('hide-modal');
        $this->editMode = false;
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'title' => 'Discount Created',
            'message' => 'Discount has been created successfully',
        ]);
        $this->dispatchBrowserEvent('close-modal');
    }

    public function edit(Discount $discount)
    {
        $this->form = $discount;
        $this->editMode = true;
        $this->dispatchBrowserEvent('show-modal');
        $this->useCacheRows();
    }

    public function update()
    {
        $this->validate();

        $this->form->save();

        $this->dispatchBrowserEvent('hide-modal');
        $this->editMode = false;
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'title' => 'Discount Updated',
            'message' => 'Discount has been updated successfully',
        ]);
        $this->dispatchBrowserEvent('close-modal');
        $this->makeForm();
    }

    public function mount()
    { 
        $this->makeForm();
    }

    public function makeUnavailable($discount_id)
    {
        $this->useCacheRows();
        $this->dispatchBrowserEvent('confirm',[
            'title' => 'Are you sure?',
            'message' => 'This discount will be unavailable',
            'confirmButtonText' => 'Continue', // default 'Confirm'
            'cancelButtonText' => 'No', // default 'Cancel',
            'confirmMethod' => 'confirmMakeUnavailable',
            'confirmParams' => $discount_id,
         ]);
    }

    public function confirmMakeUnavailable($discount_id)
    {
        $discount = Discount::find($discount_id);
        $discount->is_available = 0;
        $discount->save();
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'title' => 'Discount Unavailable',
            'message' => 'Discount has been made unavailable successfully',
        ]);
    }

    public function makeAvailable($discount_id)
    {
        $this->useCacheRows();
        $this->dispatchBrowserEvent('confirm',[
            'title' => 'Are you sure?',
            'message' => 'This discount will be available',
            'confirmButtonText' => 'Continue', // default 'Confirm'
            'cancelButtonText' => 'No', // default 'Cancel',
            'confirmMethod' => 'confirmMakeAvailable',
            'confirmParams' => $discount_id,
         ]);
    }

    public function deleteDiscount($discount_id)
    {
        $discount = Discount::find($discount_id);

        $discount->delete();

        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'title' => 'Discount Deleted',
            'message' => 'Discount has been deleted successfully',
        ]);
    }

    public function confirmMakeAvailable($discount_id)
    {
        $discount = Discount::find($discount_id);
        $discount->is_available = 1;
        $discount->save();
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'title' => 'Discount Available',
            'message' => 'Discount has been made available successfully',
        ]);
    }

    public function render()
    {
        return view('livewire.v2.branch-admin.discounts.index',[
            'discounts' => $this->discounts,
        ]);
    }
}

<?php

namespace App\Http\Livewire\BranchAdmin;

use App\Models\Discount;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Discounts extends Component
{
    use WithPagination, Actions;

    public $showModal = false;

    public $mode='create';

    public $name;

    public $type = 'percentage';

    public $amount;

    public $description;

    public $is_available = true;

    public $edit_id = null;

    public $discount=null;

    public $search = "";


    public function getModalTitle()
    {
        return $this->mode == 'create' ? 'Create Discount' : 'Update Discount';
    }

    public function amountLabel()
    {
        return $this->type == 'percentage' ? 'Percentage' : 'Amount';
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'amount' => 'required|numeric|min:1',
            'description' => 'required',
            'type' => 'in:percentage,amount'
        ]);

        if ($this->mode == 'create') {
            $this->create();
        } else {
            $this->update();
        }
    }

    public function add()
    {
        $this->reset('name', 'amount', 'description');
        $this->mode = 'create';
        $this->showModal = true;
    }

    public function edit($edit_id)
    {
        $this->edit_id = $edit_id;
        $this->discount = Discount::find($edit_id);
        $this->name = $this->discount->name;
        $this->amount = $this->discount->amount;
        $this->description = $this->discount->description;
        $this->is_available = $this->discount->is_available;
        $this->type = $this->discount->is_percentage ? 'percentage' : 'amount';
        $this->mode = 'update';
        $this->showModal = true;
    }

    public function create()
    {
        Discount::create([
            'branch_id' => auth()->user()->branch_id,
            'name' => $this->name,
            'amount' => $this->amount,
            'description' => $this->description,
            'is_percentage' => $this->type == 'percentage' ? true : false,
            'is_available' => $this->is_available,
        ]);

        $this->notification()->success(
            $title = 'Discount Created',
            $description = 'Discount has been created successfully'
        );

        $this->reset('name', 'amount', 'description');

        $this->showModal = false;
    }

    public function update()
    {
       
        $this->discount->update([
            'name' => $this->name,
            'amount' => $this->amount,
            'description' => $this->description,
            'is_percentage' => $this->type == 'percentage' ? true : false,
            'is_available' => $this->is_available,
        ]);

        $this->notification()->success(
            $title = 'Discount Updated',
            $description = 'Discount has been Successfully Updated'
        );

        $this->reset('name', 'amount', 'description');

        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.branch-admin.discounts', [
            'discounts' => Discount::query()
                ->where('name', 'like', "%{$this->search}%")
                ->where('branch_id', auth()->user()->branch->id)
                ->paginate(10),
        ]);
    }
}

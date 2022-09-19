<?php

namespace App\Http\Livewire\BranchAdmin;

use App\Models\Discount;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
use App\Traits\Modal;

class DiscountList extends Component
{
    use WithPagination, Actions, Modal;

    public $name;

    public $type = 'percentage';

    public $amount;

    public $description;

    public $is_available = true;

    public $edit_id = null;

    public $search = "";

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

    public function onClickAdd()
    {
        $this->reset('name', 'amount', 'description');
    }

    public function onClickEdit($edit_id)
    {
        $this->edit_id = $edit_id;
        $discount = Discount::find($edit_id);
        $this->name = $discount->name;
        $this->amount = $discount->amount;
        $this->description = $discount->description;
        $this->is_available = $discount->is_available;
        $this->type = $discount->is_percentage ? 'percentage' : 'amount';
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
        $discount = Discount::find($this->edit_id);
        $discount->update([
            'name' => $this->name,
            'amount' => $this->amount,
            'description' => $this->description,
            'is_percentage' => $this->type == 'percentage' ? true : false,
            'is_available' => $this->is_available,
        ]);

        $this->notification()->success(
            $title = 'Discount Updated',
            $description = 'Discount has been updated successfully'
        );

        $this->reset('name', 'amount', 'description');

        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.branch-admin.discount-list', [
            'discounts' => Discount::query()
                ->where('name', 'like', "%{$this->search}%")
                ->where('branch_id', auth()->user()->branch->id)
                ->paginate(10),
        ]);
    }
}

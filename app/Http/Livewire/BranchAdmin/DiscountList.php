<?php

namespace App\Http\Livewire\BranchAdmin;

use App\Models\Discount;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class DiscountList extends Component
{
    use WithPagination, Actions;

    public function render()
    {
        return view('livewire.branch-admin.discount-list', [
            'discounts' => Discount::where('branch_id', auth()->user()->branch->id)->paginate(10),
        ]);
    }
}

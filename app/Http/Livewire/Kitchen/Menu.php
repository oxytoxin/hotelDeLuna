<?php

namespace App\Http\Livewire\Kitchen;

use App\Models\FoodCategory;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Menu extends Component
{
    use Actions;
    use WithPagination;

    public $name;
    public $add_modal = false;
    public $edit_modal = false;
    public $category_id;

    public $searchCategory = '';

    public function render()
    {
        return view('livewire.kitchen.menu', [
            'foodCategories' => FoodCategory::where(
                'name',
                'like',
                '%' . $this->searchCategory . '%'
            )->paginate(6),
        ]);
    }

    public function editCategory($category_id)
    {
        $this->category_id = $category_id;
        $category = FoodCategory::where('id', $this->category_id)->first();
        $this->name = $category->name;
        $this->edit_modal = true;
    }

    public function saveCategory()
    {
        $this->validate([
            'name' => 'required|unique:food_categories,name',
        ]);

        FoodCategory::create([
            'name' => $this->name,
        ]);

        $this->name = '';
        $this->notification()->success(
            $title = 'Success',
            $description = 'The Category awas successfull saved'
        );
    }

    public function updateCategory()
    {
        $this->validate([
            'name' =>
                'required|unique:food_categories,name,' . $this->category_id,
        ]);

        FoodCategory::where('id', $this->category_id)->update([
            'name' => $this->name,
        ]);
        $this->name = '';
        $this->edit_modal = false;
        $this->notification()->success(
            $title = 'Success',
            $description = 'The Category awas successfull updated'
        );
    }
}

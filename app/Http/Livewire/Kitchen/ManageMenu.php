<?php

namespace App\Http\Livewire\Kitchen;

use App\Models\FoodCategory;
use App\Models\Meal;
use Livewire\Component;

class ManageMenu extends Component
{
    public $category_id;

    public $name;

    public $price;

    public $searchMenu = '';

    public function mount($id)
    {
        $this->category_id = $id;
    }

    public function render()
    {
        return view('livewire.kitchen.manage-menu', [
            'category' => FoodCategory::where('id', $this->category_id)->first(),
            'menus' => Meal::where('food_category_id', $this->category_id)->where('name', 'like', '%'.$this->searchMenu.'%')->get(),
        ]);
    }

    public function saveMenu()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required',
        ]);

        Meal::create([
            'name' => $this->name,
            'price' => $this->price,
            'food_category_id' => $this->category_id,
        ]);

        $this->name = '';
        $this->price = '';
    }
}

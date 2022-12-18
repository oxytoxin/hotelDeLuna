<?php

namespace App\Http\Livewire\Kitchen;

use App\Models\FoodCategory;
use App\Models\Meal;
use Livewire\Component;
use WireUi\Traits\Actions;

class ManageMenu extends Component
{
    public $category_id;
    use Actions;
    public $add_modal = false;
    public $edit_modal = false;
    public $name;
    public $meal_id;
    public $price;

    public $searchMenu = '';

    public function mount($id)
    {
        $this->category_id = $id;
    }

    public function render()
    {
        return view('livewire.kitchen.manage-menu', [
            'category' => FoodCategory::where(
                'id',
                $this->category_id
            )->first(),
            'menus' => Meal::where('food_category_id', $this->category_id)
                ->where('name', 'like', '%' . $this->searchMenu . '%')
                ->get(),
        ]);
    }

    public function saveMenu()
    {
        $this->validate([
            'name' => 'required|unique:meals,name',
            'price' => 'required',
        ]);

        Meal::create([
            'name' => $this->name,
            'price' => $this->price,
            'food_category_id' => $this->category_id,
        ]);

        $this->name = '';
        $this->price = '';
        $this->notification()->success(
            $title = 'Success',
            $description = 'The menu awas successfull saved'
        );
    }

    public function editMenu($menu_id)
    {
        $this->meal_id = $menu_id;
        $menu = Meal::where('id', $this->meal_id)->first();
        $this->name = $menu->name;
        $this->price = $menu->price;
        $this->edit_modal = true;
    }

    public function updateMenu()
    {
        $this->validate([
            'name' => 'required|unique:meals,name,' . $this->meal_id,
            'price' => 'required',
        ]);

        Meal::where('id', $this->meal_id)->update([
            'name' => $this->name,
            'price' => $this->price,
        ]);

        $this->name = '';
        $this->price = '';
        $this->notification()->success(
            $title = 'Success',
            $description = 'The menu was successfull updated'
        );
        $this->edit_modal = false;
    }
}

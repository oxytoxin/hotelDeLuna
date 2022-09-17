<?php

namespace App\Http\Livewire\Kitchen;

use App\Models\FoodCategory;
use Livewire\Component;
use Livewire\WithPagination;

class Menu extends Component
{
    use WithPagination;

    public $name;

    public $searchCategory = '';

    public function render()
    {
        return view('livewire.kitchen.menu', [
            'foodCategories' => FoodCategory::where('name', 'like', '%'.$this->searchCategory.'%')->paginate(6),
        ]);
    }

    public function saveCategory()
    {
        $this->validate([
            'name' => 'required',
        ]);

        FoodCategory::create([
            'name' => $this->name,
        ]);

        $this->name = '';
    }
}

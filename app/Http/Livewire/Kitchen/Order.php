<?php

namespace App\Http\Livewire\Kitchen;

use App\Models\FoodCategory;
use App\Models\Guest;
use App\Models\Meal;
use App\Models\Order as ModelsOrder;
use App\Models\Transaction;
use Livewire\Component;

class Order extends Component
{
    public $searchMenu = "";
    public $category_id;
    public $meals_get = [
        'name' => '',
        'price' => '',
        'qty' => 1,
        'total' => '',
    ];

    public $meals;
    public $transaction = [];
    public $meal_key;
    public $customer = [];
    public $customerpanel = false;
    public $guestSearch = "";
    public $confirmModal = false;

    public function render()
    {
        $this->meals = Meal::where('food_category_id', 'like', '%' . $this->category_id . '%')->where('name', 'like', '%' . $this->searchMenu . '%')->get();
        return view('livewire.kitchen.order', [
            'categories' => FoodCategory::get(),
            'meals' => $this->meals,
            'guests' => Guest::where('qr_code', 'like', '%' . $this->guestSearch . '%')->get(),
        ]);
    }

    public function selectMeal($id)
    {
        $meal = $this->meals->where('id', $id)->first();
        if ($this->customer == null) {
            $this->customerpanel = true;
        } else {
            foreach ($this->transaction as $key => $order) {
                if ($order['id'] == $meal->id) {
                    $this->transaction[$key]['qty'] += 1;
                    $this->transaction[$key]['total'] = $this->transaction[$key]['price'] * $this->transaction[$key]['qty'];

                    return;
                }
            }
            $this->transaction[] = [
                'id' => $id,
                'name' => $meal->name,
                'price' => $meal->price,
                'qty' => 1,
                'total' => $meal->price,
            ];
        }
    }

    public function addQty($key)
    {
        $this->transaction[$key]['qty'] += 1;
        $this->transaction[$key]['total'] = $this->transaction[$key]['price'] * $this->transaction[$key]['qty'];
    }

    public function minusQty($key)
    {
        if ($this->transaction[$key]['qty'] > 1) {
            $this->transaction[$key]['qty'] -= 1;
            $this->transaction[$key]['total'] = $this->transaction[$key]['price'] * $this->transaction[$key]['qty'];
        } else {
            unset($this->transaction[$key]);
        }
    }

    public function removeOrder($key)
    {
        unset($this->transaction[$key]);
    }

    public function selectCustomer($id)
    {
        $this->customer = Guest::where('id', $id)->first();
        // $this->customerpanel = false;
    }

    public function checkoutOrder()
    {

        $transaction = Transaction::create([
            'branch_id' => auth()->user()->branch_id,
            'guest_id' => $this->customer['id'],
            'transaction_type_id' => 3,
            'payable_amount' => collect($this->transaction)->sum('total'),

        ]);
        foreach ($this->transaction as $key => $item) {
            ModelsOrder::create([
                'transaction_id' => $transaction->id,
                'meal_id' => $item['id'],
                'quantity' => $item['qty'],
            ]);
        }
        $this->transaction = [];
        $this->customer = [];
        $this->confirmModal = true;
    }
}

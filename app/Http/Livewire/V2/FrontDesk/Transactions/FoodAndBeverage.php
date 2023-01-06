<?php

namespace App\Http\Livewire\V2\FrontDesk\Transactions;

use Livewire\Component;
use App\Models\Frontdesk;
use App\Models\Transaction;
use App\Traits\WithCaching;
use Illuminate\Support\Facades\DB;
use App\Models\FoodAndBeverage as ModelFoodAndBeverage;

class FoodAndBeverage extends Component
{
    use WithCaching;

    public $guestId;

    public $guestCheckInRoomId;

    public $form;

    //     Cornsilog	99
    // Tapsilog	99
    // Longsilog	99
    // Hotsilog	99
    // Bangus (Daing)	99
    // Danggit (Dried Fish)	99
    // Beef Steak	99
    // Fried Chicken	99
    // Chicken adobo	99
    // Sweet and Sour Fish	99
    // Fish Tinola	99
    // Instant Nodles with Egg	50
    // Extra Egg	20
    // Extra Rice 1 cup	20
    // Exrea Rice 1/2 cup	15
    // French fries with sauce	59
    // Tempura (6 PCS)	59
    // Junkfoods 	39
    // Four Seasons	39
    // Mango Nector	39
    // Pineoranger	39
    // Sweetened Pineapple	39
    // Coke	39
    // Sprite	39
    // Royal	39
    // 7-UP	39
    // Mountain Dew	39
    // 1L Mineral Water	39
    // 500ML Mineral Water	29
    // 3in1 Coffee	29
    // Milo	29
    // C2	39
    // Fit 'N Right	39
    // Cobra	39

    public $foods = [
        ['name' => 'Tapsilog', 'price' => 99],

        ['name' => 'Longsilog', 'price' => 99],

        ['name' => 'Hotsilog', 'price' => 99],

        ['name' => 'Bangus (Daing)', 'price' => 99],

        ['name' => 'Danggit (Dried Fish)', 'price' => 99],

        ['name' => 'Beef Steak', 'price' => 99],

        ['name' => 'Fried Chicken', 'price' => 99],

        ['name' => 'Chicken adobo', 'price' => 99],

        ['name' => 'Sweet and Sour Fish', 'price' => 99],

        ['name' => 'Fish Tinola', 'price' => 99],

        ['name' => 'Instant Nodles with Egg', 'price' => 50],

        ['name' => 'Extra Egg', 'price' => 20],

        ['name' => 'Extra Rice 1 cup', 'price' => 20],

        ['name' => 'Exrea Rice 1/2 cup', 'price' => 15],

        ['name' => 'French fries with sauce', 'price' => 59],

        ['name' => 'Tempura (6 PCS)', 'price' => 59],

        ['name' => 'Junkfoods', 'price' => 39],

        ['name' => 'Four Seasons', 'price' => 39],

        ['name' => 'Mango Nector', 'price' => 39],

        ['name' => 'Pineoranger', 'price' => 39],

        ['name' => 'Sweetened Pineapple', 'price' => 39],

        ['name' => 'Coke', 'price' => 39],

        ['name' => 'Sprite', 'price' => 39],

        ['name' => 'Royal', 'price' => 39],

        ['name' => '7-UP', 'price' => 39],

        ['name' => 'Mountain Dew', 'price' => 39],

        ['name' => '1L Mineral Water', 'price' => 39],

        ['name' => '500ML Mineral Water', 'price' => 29],

        ['name' => '3in1 Coffee', 'price' => 29],

        ['name' => 'Milo', 'price' => 29],

        ['name' => 'C2', 'price' => 39],

        ['name' => 'Fit N Right', 'price' => 39],

        ['name' => 'Cobra', 'price' => 39],
    ];

    public $foodAndBeverages;

    protected $listeners = [
        'confirmSaveRecord',
        'payTransaction',
        'depositDeducted' => '$refresh',
    ];

    public function payWithDeposit($transaction_id, $payable_amount)
    {
        $this->emit('payWithDeposit', [
            'guest_id' => $this->guestId,
            'transaction_id' => $transaction_id,
            'payable_amount' => $payable_amount,
        ]);
    }

    public function payTransaction(Transaction $transaction)
    {
        $transaction->update([
            'paid_at' => now(),
        ]);
        $this->emit('transactionUpdated');

        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Transaction Paid',
            'message' => 'Transaction has been paid',
        ]);
    }

    public function rules()
    {
        return [
            'form.guest_id' => 'required',
            'form.name' => 'required',
            'form.quantity' => 'required|numeric',
            'form.price' => 'required|numeric',
            'form.front_desk_names' => 'nullable',
        ];
    }

    public function makeForm()
    {
        $ids = json_decode(auth()->user()->assigned_frontdesks);
        $frontdesks = Frontdesk::whereIn('id', $ids)->get();
        $this->form = ModelFoodAndBeverage::make([
            'guest_id' => $this->guestId,
            'quantity' => 1,
            'front_desk_names' => $frontdesks->pluck('name')->implode(' and '),
        ]);
    }

    public function mount()
    {
        $this->makeForm();
    }

    public function getTransactionsQueryProperty()
    {
        return \App\Models\Transaction::query();
    }

    public function getTransactionsProperty()
    {
        return $this->cache(function () {
            return $this->transactionsQuery
                ->where('transaction_type_id', 9)
                ->where('guest_id', $this->guestId)
                ->get();
        });
    }

    public function confirmSaveRecord()
    {
        $this->validate();

        DB::beginTransaction();

        Transaction::create([
            'branch_id' => auth()->user()->branch_id,
            'guest_id' => $this->guestId,
            'transaction_type_id' => 9,
            'room_id' => $this->guestCheckInRoomId,
            'payable_amount' => $this->form->price * $this->form->quantity,
            'remarks' => $this->form->name,
            'assigned_frontdesks' => auth()->user()->assigned_frontdesks,
        ]);

        $this->form->save();

        DB::commit();

        $this->makeForm();

        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Record saved successfully',
        ]);

        $this->dispatchBrowserEvent('close-form');

        $this->emit('transactionsUpdated');
    }

    public function updatedFormName()
    {
        $this->form->price = $this->foodAndBeverages
            ->where('name', $this->form->name)
            ->first()['price'];
    }

    public function render()
    {
        $this->foodAndBeverages = collect($this->foods);
        return view('livewire.v2.front-desk.transactions.food-and-beverage', [
            'transactions' => $this->transactions,
        ]);
    }
}

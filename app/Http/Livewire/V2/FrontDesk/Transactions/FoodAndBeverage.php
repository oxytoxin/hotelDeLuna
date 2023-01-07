<?php

namespace App\Http\Livewire\V2\FrontDesk\Transactions;

use Livewire\Component;
use App\Models\Frontdesk;
use App\Models\Transaction;
use App\Traits\WithCaching;
use App\Models\Deposit;
use App\Models\Guest;
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

    public $transactionToPay;
    public $transactionToPayAmount = 0;
    public $transactionToPayGivenAmount = 0;
    public $transactionToPayExcessAmount = 0;
    public $transactionToPaySaveExcessAmount = false;

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
        $this->transactionToPay = $transaction;

        $this->transactionToPayAmount = $transaction->payable_amount;
        $this->transactionToPayGivenAmount = 0;
        $this->transactionToPayExcessAmount = 0;

        $this->dispatchBrowserEvent('show-pay-modal');
    }

    public function updatedTransactionToPayGivenAmount()
    {
        if (
            $this->transactionToPayGivenAmount > $this->transactionToPayAmount
        ) {
            $this->transactionToPayExcessAmount =
                $this->transactionToPayGivenAmount -
                $this->transactionToPayAmount;
        } else {
            $this->transactionToPayExcessAmount = 0;
        }
    }

    public function payTransactionConfirm()
    {
        if (
            $this->transactionToPayGivenAmount < $this->transactionToPayAmount
        ) {
            $this->dispatchBrowserEvent('show-alert', [
                'type' => 'error',
                'title' => 'Invalid Amount',
                'message' => 'Given amount is less than the payable amount.',
            ]);
            return;
        }

        if ($this->transactionToPayExcessAmount) {
            $ids = json_decode(auth()->user()->assigned_frontdesks);
            $active_frontdesk = Frontdesk::where(
                'branch_id',
                auth()->user()->branch_id
            )
                ->where('is_active', 1)
                ->get();
            Deposit::create([
                'guest_id' => $this->guestId,
                'amount' => $this->transactionToPayExcessAmount,
                'remarks' =>
                    'Excess amount from transaction :' .
                    $this->transactionToPay->remarks,
                'remaining' => $this->transactionToPayExcessAmount,
                'front_desk_names' => $active_frontdesk
                    ->pluck('name')
                    ->implode(' and '),
            ]);

            $guest = Guest::find($this->guestId);
            $guest->update([
                'total_deposits' =>
                    $guest->total_deposits +
                    $this->transactionToPayExcessAmount,
                'deposit_balance' =>
                    $guest->deposit_balance +
                    $this->transactionToPayExcessAmount,
            ]);
        }

        $this->transactionToPay->update([
            'paid_at' => now(),
        ]);

        $this->dispatchBrowserEvent('close-pay-modal');
        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Transaction Paid',
            'message' => 'Transaction has been paid.',
        ]);

        $this->emit('transactionUpdated');
    }

    // public function payTransaction(Transaction $transaction)
    // {
    //     $transaction->update([
    //         'paid_at' => now(),
    //     ]);
    //     $this->emit('transactionUpdated');

    //     $this->dispatchBrowserEvent('notify-alert', [
    //         'type' => 'success',
    //         'title' => 'Transaction Paid',
    //         'message' => 'Transaction has been paid',
    //     ]);
    // }

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
        $active_frontdesk = Frontdesk::where(
            'branch_id',
            auth()->user()->branch_id
        )
            ->where('is_active', 1)
            ->get();
        $this->form = ModelFoodAndBeverage::make([
            'guest_id' => $this->guestId,
            'quantity' => 1,
            'front_desk_names' => $active_frontdesk
                ->pluck('name')
                ->implode(' and '),
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
        $active_frontdesk = Frontdesk::where(
            'branch_id',
            auth()->user()->branch_id
        )
            ->where('is_active', 1)
            ->get();
        DB::beginTransaction();

        Transaction::create([
            'branch_id' => auth()->user()->branch_id,
            'guest_id' => $this->guestId,
            'transaction_type_id' => 9,
            'room_id' => $this->guestCheckInRoomId,
            'payable_amount' => $this->form->price * $this->form->quantity,
            'remarks' => $this->form->name,
            'assigned_frontdesks' => $active_frontdesk->pluck('id'),
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

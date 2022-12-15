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

    protected $listeners = ['confirmSaveRecord', 'payTransaction','depositDeducted'=>'$refresh'];

    public function payWithDeposit($transaction_id,$payable_amount)
    {
        $this->emit('payWithDeposit',[
            'guest_id' => $this->guestId,
            'transaction_id' => $transaction_id,
            'payable_amount' => $payable_amount
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
            'message' => 'Transaction has been paid'
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
        $frontdesks = Frontdesk::whereIn('id',$ids)->get();
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
            return $this->transactionsQuery->where('transaction_type_id', 9)->where('guest_id', $this->guestId)->get();
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

    public function render()
    {
        return view('livewire.v2.front-desk.transactions.food-and-beverage', [
            'transactions' => $this->transactions,
        ]);
    }
}

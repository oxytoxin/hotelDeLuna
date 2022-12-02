<?php

namespace App\Http\Livewire\V2\FrontDesk\Transactions;

use Carbon\Carbon;
use App\Models\Guest;
use App\Models\Amenity;
use App\Models\Deposit;
use Livewire\Component;
use App\Models\Transaction;
use App\Traits\WithCaching;
use App\Models\RequestableItem;

class Amenities extends Component
{
    use WithCaching;

    public $guestId;

    public $checkInRoomId;

    public $form;

    public $requestableItems = [];

    public $transactionToPay;

    protected $listeners = ['confirmSaveRecord','payTransaction','depositDeducted'=>'$refresh'];

    public $transactionToPayAmount = 0;
    public $transactionToPayGivenAmount = 0;
    public $transactionToPayExcessAmount = 0;
    public $transactionToPaySaveExcessAmount = false;

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
        if ($this->transactionToPayGivenAmount > $this->transactionToPayAmount) {
            $this->transactionToPayExcessAmount = $this->transactionToPayGivenAmount - $this->transactionToPayAmount;
        } else {
            $this->transactionToPayExcessAmount = 0;
        }
    }

    public function payTransactionConfirm()
    {
        if ($this->transactionToPayGivenAmount < $this->transactionToPayAmount) {
            $this->dispatchBrowserEvent('show-alert', [
                'type' => 'error',
                'title' => 'Invalid Amount',
                 'message' => 'Given amount is less than the payable amount.'
             ]);
             return;
        }

        if ($this->transactionToPayExcessAmount) {
            Deposit::create([
                'guest_id' => $this->guestId,
                'amount' => $this->transactionToPayExcessAmount,
                'remarks' => 'Excess amount from transaction :'.$this->transactionToPay->remarks,
                'remaining'=> $this->transactionToPayExcessAmount,
            ]);

            $guest = Guest::find($this->guestId);
            $guest->update([
                'total_deposits' => $guest->total_deposits + $this->transactionToPayExcessAmount,
                'deposit_balance' => $guest->deposit_balance + $this->transactionToPayExcessAmount,
            ]);
        };

        $this->transactionToPay->update([
            'paid_at' => Carbon::now(),
        ]);

        $this->dispatchBrowserEvent('close-pay-modal');
        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Transaction Paid',
            'message' => 'Transaction has been paid.'
        ]);

        $this->emit('transactionUpdated');
    }

    public function payWithDeposit($transaction_id,$payable_amount)
    {
        $this->emit('payWithDeposit',[
            'guest_id' => $this->guestId,
            'transaction_id' => $transaction_id,
            'payable_amount' => $payable_amount
        ]);
    }

    public function rules()
    {
        return [
            'form.guest_id' => 'nullable',
            'form.requestable_item_id' => 'required',
            'form.quantity' => 'required|numeric',
            'form.price' => 'required|numeric',
            'form.additional_charge' => 'nullable|numeric',
            'form.front_desk_name' => 'nullable',
            'form.user_id' => 'nullable',
        ];
    }

    public function makeForm()
    {
        $this->form = Amenity::make([
            'guest_id' => $this->guestId,
            'quantity' => 1,
            'front_desk_name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
        ]);
    }

    public function mount()
    {
         $this->makeForm();
        $this->requestableItems = RequestableItem::where('branch_id', auth()->user()->branch_id)->get();
    }
    public function getTransactionsQueryProperty()
    {
        return \App\Models\Transaction::where('transaction_type_id', 8)->where('guest_id', $this->guestId);
    }

    public function getTransactionsProperty()
    {
        return $this->cache(function () {
            return $this->transactionsQuery->get();
        }, 'transactions');
    }

    public function updatedFormRequestableItemId()
    {
        $this->form->price = $this->requestableItems->find($this->form->requestable_item_id)->price * $this->form->quantity;
    }

    public function updatedFormQuantity()
    {
        $this->form->price = $this->requestableItems->find($this->form->requestable_item_id)->price * $this->form->quantity;
    }

    public function confirmSaveRecord()
    {
        $this->validate();

        Transaction::create([
            'branch_id' => auth()->user()->branch_id,
            'guest_id' => $this->guestId,
            'transaction_type_id' => 8,
            'room_id' => $this->checkInRoomId,
            'payable_amount' => $this->form->additional_charge !='' ? $this->form->price + $this->form->additional_charge : $this->form->price,
            'remarks' => "Amenity : {$this->requestableItems->find($this->form->requestable_item_id)->name}",
            'front_desk_name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
        ]);

        $this->form->save();

        $this->makeForm();

        $this->dispatchBrowserEvent('notify-alert',[
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Record saved successfully',
        ]);

        $this->dispatchBrowserEvent('close-form');

        $this->emit('transactionsUpdated');

    }
    public function render()
    {
        return view('livewire.v2.front-desk.transactions.amenities',[
            'transactions' => $this->transactions,
        ]);
    }
}

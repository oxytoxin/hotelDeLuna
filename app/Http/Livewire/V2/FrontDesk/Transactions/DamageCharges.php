<?php

namespace App\Http\Livewire\V2\FrontDesk\Transactions;

use Carbon\Carbon;
use App\Models\Guest;
use App\Models\Damage;
use App\Models\Deposit;
use Livewire\Component;
use App\Models\HotelItem;
use App\Models\Transaction;
use App\Traits\WithCaching;

class DamageCharges extends Component
{
    use WithCaching;

    public $guestId;

    public $searchHotelItem = '';

    public $hotelItemId,$hotelItemPrice,$hotelItemAdditionalAmount,$occurredAt;

    public $hotelItems = [];

    public $checkInRoomId;

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

    public function updatedHotelItemId()
    {
        $this->useCacheRows();
        $this->hotelItemPrice = $this->hotelItems->find($this->hotelItemId)->price;
    }

    public function mount()
    {
        $this->hotelItems = HotelItem::where('branch_id', auth()->user()->branch->id)->get();
    }

    public function confirmSaveRecord()
    {
        $this->validate([
            'hotelItemId' => 'required',
            'hotelItemPrice' => 'required',
            'hotelItemAdditionalAmount' => 'nullable|numeric',
            'occurredAt' => 'required',
        ]);

        Damage::create([
            'guest_id' => $this->guestId,
            'hotel_item_id' => $this->hotelItemId,
            'occurred_at' => $this->occurredAt,
            'price' => $this->hotelItemPrice,
            'additional_charge' => $this->hotelItemAdditionalAmount,
            'front_desk_name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
        ]);

        Transaction::create([
            'branch_id' => auth()->user()->branch_id,
            'guest_id' => $this->guestId,
            'transaction_type_id' => 4,
            'payable_amount' => $this->hotelItemPrice + $this->hotelItemAdditionalAmount,
            'room_id' => $this->checkInRoomId,
            'remarks' => "Damage Charge for {$this->hotelItems->find($this->hotelItemId)->name}",
            'front_desk_name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
        ]);

        $this->reset('hotelItemId','hotelItemPrice','hotelItemAdditionalAmount','occurredAt');

        $this->dispatchBrowserEvent('notify-alert',[
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Damage Charge has been added successfully.',
        ]);

        $this->dispatchBrowserEvent('close-form');

        $this->emit('transactionUpdated');

    }

    public function getTransactionsProperty()
    {
        return $this->cache(function () {
            return Transaction::where('transaction_type_id',4)->where('guest_id', $this->guestId)->get();
        });
    }
   
    public function render()
    {
        return view('livewire.v2.front-desk.transactions.damage-charges',[
            'transactions' => $this->transactions,
        ]);
    }
}

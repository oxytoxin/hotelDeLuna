<?php

namespace App\Http\Livewire\V2;

use App\Models\Guest;
use App\Models\Deposit;
use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class PayWithDeposits extends Component
{
    protected $listeners = ['payWithDeposit'];

    public $guestId;
    public $transactionId;
    public $payableAmount;

    public $additionalAmount = 0;
    public $additionalAmountChange = 0;
    public $additionalAmountChangeSaveToDeposit = false;

    public $guest;

    public function payWithDeposit($data)
    {
        $this->guestId = $data['guest_id'];
        $this->transactionId = $data['transaction_id'];
        $this->payableAmount = $data['payable_amount'];
        $this->guest = Guest::find($this->guestId);
        $this->dispatchBrowserEvent('show-deposits-modal');
    }

    public function updatedAdditionalAmount()
    {
        if ($this->additionalAmount == '') {
            $this->additionalAmount = 0;
        }else{
            $this->additionalAmountChange = $this->additionalAmount + $this->guest->deposit_balance - $this->payableAmount;
        }
    }

    public function save()
    {
        if ($this->payableAmount  >= $this->guest->deposit_balance + $this->additionalAmount) {
            return;
        }

        $this->guest->update([
            'deposit_balance' => $this->payableAmount > $this->guest->deposit_balance ? 0 : $this->guest->deposit_balance - $this->payableAmount,
        ]);

        Transaction::find($this->transactionId)->update([
            'paid_at' => now(),
        ]);

        if ($this->additionalAmountChangeSaveToDeposit) {
            Deposit::create([
                'guest_id' => $this->guestId,
                'amount' => $this->additionalAmountChange,
                'remarks' => 'Excess amount from paying with deposits',
                'remaining' => $this->additionalAmountChange,
                'front_desk_name' => auth()->user()->name,
                'user_id' => auth()->user()->id,
            ]);

            $this->guest->refresh();

            $this->guest->update([
                'total_deposits' => $this->guest->total_deposits + $this->additionalAmountChange,
                'deposit_balance' => $this->guest->deposit_balance + $this->additionalAmountChange,
            ]);
        }

        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Deposit Deducted',
            'message' => 'Deposit has been deducted'
        ]);

        $this->dispatchBrowserEvent('close-deposits-modal');

        $this->emit('transactionUpdated');
        $this->emit('depositDeducted');
        $this->guestId = null;
        $this->transactionId = null;
        $this->payableAmount = null;
        $this->additionalAmount = 0;
        $this->additionalAmountChange = 0;
        $this->additionalAmountChangeSaveToDeposit = false;
    }

    public function render()
    {
        return view('livewire.v2.pay-with-deposits');
    }
}

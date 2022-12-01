<?php

namespace App\Http\Livewire\V2;

use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\Guest;
use Livewire\Component;

class PayWithDeposits extends Component
{
    protected $listeners = ['payWithDeposit'];

    public $guestId;
    public $transactionId;
    public $payableAmount;

    public $guest;

    public function payWithDeposit($data)
    {
        $this->guestId = $data['guest_id'];
        $this->transactionId = $data['transaction_id'];
        $this->payableAmount = $data['payable_amount'];
        $this->guest = Guest::find($this->guestId);
        $this->dispatchBrowserEvent('show-deposits-modal');
    }

    public function save()
    {
        if ($this->payableAmount >= $this->guest->deposit_balance) {
            return;
        }

        $this->guest->update([
            'deposit_balance' => $this->guest->deposit_balance - $this->payableAmount,
        ]);

        Transaction::find($this->transactionId)->update([
            'paid_at' => now(),
        ]);

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
    }

    public function render()
    {
        return view('livewire.v2.pay-with-deposits');
    }
}

<?php

namespace App\Http\Livewire\V2;

use App\Models\Deposit;
use App\Models\Transaction;
use Livewire\Component;

class PayWithDeposits extends Component
{
    protected $listeners = ['payWithDeposit'];

    public $guestId;
    public $transactionId;
    public $payableAmount;

    public function payWithDeposit($data)
    {
        $this->guestId = $data['guest_id'];
        $this->transactionId = $data['transaction_id'];
        $this->payableAmount = $data['payable_amount'];
        $this->dispatchBrowserEvent('show-deposits-modal');
    }

    public function select(Deposit $deposit)
    {
        $balance = $deposit->amount - $deposit->deducted;
        if ($this->payableAmount > $balance) {
            $this->dispatchBrowserEvent('notify-alert', [
                'type' => 'error',
                'title' => 'Insufficient Balance',
                'message' => 'Insufficient balance in deposit'
            ]);
            return;
        }

        $deposit->update([
            'deducted' => $deposit->deducted + $this->payableAmount
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

        $this->guestId = null;
        $this->transactionId = null;
        $this->payableAmount = null;
    }

    public function render()
    {
        return view('livewire.v2.pay-with-deposits',[
            'deposits' => $this->guestId ? Deposit::where('guest_id',$this->guestId)->get() : []
        ]);
    }
}

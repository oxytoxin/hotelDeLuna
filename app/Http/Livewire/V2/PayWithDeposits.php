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
    public $selectedDeposits = [];
    public $enoughDeposits = false;
    public $totalSelectedDepositAmount = 0;

    public function payWithDeposit($data)
    {
        $this->guestId = $data['guest_id'];
        $this->transactionId = $data['transaction_id'];
        $this->payableAmount = $data['payable_amount'];
        $this->dispatchBrowserEvent('show-deposits-modal');
    }

    public function updatedSelectedDeposits()
    {
        $this->totalSelectedDepositAmount = Deposit::whereIn('id', $this->selectedDeposits)->sum('remaining');
        $this->enoughDeposits = $this->totalSelectedDepositAmount >= $this->payableAmount;
    }

    public function save()
    {
        $this->validate([
            'selectedDeposits' => 'required',
            'enoughDeposits' =>  'accepted',
        ], [
            'enoughDeposits.accepted' => 'The selected deposits are not enough to pay the transaction. Please select more deposits.',
        ]);


        $transaction = Transaction::find($this->transactionId);

        foreach ($this->selectedDeposits as $deposit) {
          if ($this->payableAmount>0) {
                $deposit = Deposit::find($deposit);
                $deducted = $deposit->remaining >= $this->payableAmount ? $this->payableAmount : $deposit->remaining;
                $this->payableAmount -= $deducted;
                $deposit->update([
                    'deducted' => $deposit->deducted + $deducted,
                    'remaining' => $deposit->remaining - $deducted,
                    'claimed_at' =>   $deposit->remaining - $deducted == 0 ? now() : null,
                ]);
                if ($this->payableAmount == 0) {
                    $transaction->update([
                        'paid_at' => now(),
                    ]);
                }
            }
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
    }

    public function clearSelected()
    {
        $this->selectedDeposits = [];
        $this->enoughDeposits = false;
    }

    public function render()
    {
        return view('livewire.v2.pay-with-deposits',[
            'deposits' => $this->guestId ? Deposit::where('guest_id',$this->guestId)->where('remaining','>',0)->get() : []
        ]);
    }
}

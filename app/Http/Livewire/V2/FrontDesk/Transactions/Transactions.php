<?php

namespace App\Http\Livewire\V2\FrontDesk\Transactions;

use Livewire\Component;
use App\Models\Transaction;
use App\Traits\WithCaching;
use App\Models\TransactionType;
use App\Models\Frontdesk;

class Transactions extends Component
{
    use WithCaching;

    public $guest_id;

    public $transactionTypes = [];

    public $transactionToPayAmount = 0;
    public $transactionToPayGivenAmount = 0;
    public $transactionToPayExcessAmount = 0;
    public $transactionToPaySaveExcessAmount = false;

    protected $listeners = ['payTransaction', 'depositDeducted' => '$refresh'];

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
    public function payTransaction(Transaction $transaction)
    {
        $this->transactionToPay = $transaction;

        $this->transactionToPayAmount = $transaction->payable_amount;
        $this->transactionToPayGivenAmount = 0;
        $this->transactionToPayExcessAmount = 0;

        $this->dispatchBrowserEvent('show-pay-modal');
    }

    public function payTransactionConfirm()
    {
        $ids = json_decode(auth()->user()->assigned_frontdesks);
        $active_frontdesk = Frontdesk::where(
            'branch_id',
            auth()->user()->branch_id
        )
            ->where('is_active', 1)
            ->get();
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

    public function payWithDeposit($transaction_id, $payable_amount)
    {
        $this->emit('payWithDeposit', [
            'guest_id' => $this->guest_id,
            'transaction_id' => $transaction_id,
            'payable_amount' => $payable_amount,
        ]);
    }

    public function getTransactionsProperty()
    {
        return $this->cache(function () {
            return Transaction::query()
                ->where('guest_id', $this->guest_id)
                ->get()
                ->groupBy('transaction_type_id');
        }, 'transactions');
    }

    public function mount()
    {
        $this->transactionTypes = TransactionType::all();
    }

    public function render()
    {
        return view('livewire.v2.front-desk.transactions.transactions', [
            'guest_transactions' => $this->transactions,
        ]);
    }
}

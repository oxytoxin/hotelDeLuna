<?php

namespace App\Http\Livewire\V2\FrontDesk\Transactions;

use Livewire\Component;
use App\Models\Transaction;
use App\Traits\WithCaching;
use App\Models\TransactionType;

class Transactions extends Component
{
    use WithCaching;

    public $guest_id;

    public $transactionTypes = [];

    protected $listeners = [ 'payTransaction'];

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

    public function getTransactionsProperty()
    {
        return $this->cache(function () {
            return Transaction::query()
            ->where('guest_id', $this->guest_id)->get()->groupBy('transaction_type_id');
        },'transactions');
    }

    public function mount()
    {
        $this->transactionTypes = TransactionType::all();
    }

    public function render()
    {
        return view('livewire.v2.front-desk.transactions.transactions',[
            'guest_transactions' => $this->transactions,
        ]);
    }
}

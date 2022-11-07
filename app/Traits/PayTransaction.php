<?php

namespace App\Traits;
use App\Models\Transaction;
use Carbon\Carbon;

trait PayTransaction
{
    public function payTransaction($transaction_id)
    {
        $this->useCacheRows();

        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'This will mark the transaction as paid.',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Yes, continue',
                'method' => 'confirmPayTransaction',
                'params' => $transaction_id,
            ],
            'reject' => [
                'label'  => 'No, cancel',
            ],
        ]);
    }

    public function confirmPayTransaction($transaction_id)
    {
        $transaction = Transaction::find($transaction_id);

        $transaction->update([
            'paid_at' => Carbon::now(),
        ]);

        $this->dialog()->success(
            $title = 'Success',
            $description = 'Transaction has been marked as paid.',
        );

        $this->emit('transactionUpdated');
    }
}
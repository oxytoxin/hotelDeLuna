<?php

namespace App\Http\Livewire\V2\FrontDesk\CheckOut;

use Carbon\Carbon;
use App\Models\Guest;
use App\Models\Deposit;
use Livewire\Component;
use App\Models\Transaction;
use App\Models\TransactionType;

class Index extends Component
{

    public $search = '';

    public $searchBy = '1';

    public $transactionTypes=[];

    public $guest = null;

    public $overrideAmount ='',$transaction;

    public $totalAmountToPay,$balance;



    protected $listeners = ['claimDeposit','payTransaction'];

    public function payTransaction(Transaction $transaction)
    {
        $transaction->update([
            'paid_at' => Carbon::now(),
        ]);
        $this->emit('transactionUpdated');

        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Transaction Paid',
            'message' => 'Transaction has been paid'
        ]);
    }

    public function searchGuest()
    {
        if ($this->search != '') {
            switch ($this->searchBy) {
                case '1':
                    $this->guest = Guest::where('qr_code', $this->search)
                                    ->where('check_in_at', '!=', null)
                                    ->where('check_out_at', null)
                                    ->first();
                              
                    break;
                case '2':
                    $this->guest = Guest::where('check_in_at', '!=', null)
                                     ->where('check_out_at', null)
                                      ->whereHas('checkInDetail.room', function ($query) {
                                            $query->where('number', $this->search);
                                      })->first();
                    break;
            }

            if ($this->guest) {
                $this->totalAmountToPay = $this->guest->transactions()->sum('payable_amount');
                $this->balance = $this->guest->transactions()->where('paid_at', null)->sum('payable_amount');

            }
        }
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->guest = null;
    }

    public function showOverrideModal(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->overrideAmount = $transaction->payable_amount;
        $this->dispatchBrowserEvent('show-override-modal');
    }
    public function saveOverride()
    {
        $this->transaction->update([
            'payable_amount' => $this->overrideAmount,
        ]);
        $this->emit('transactionUpdated');
        $this->dispatchBrowserEvent('close-override-modal');
        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Transaction Updated',
            'message' => 'Transaction has been updated'
        ]);
    }

    public function getTransactionsProperty()
    {
        return Transaction::query()
            ->where('guest_id', $this->guest->id)->get()->groupBy('transaction_type_id');
    }

    public function mount()
    {
        $this->transactionTypes = TransactionType::all();
    }

    public function claimDeposit(Deposit $deposit)
    {

        if ($deposit->claimed_at) {
            $this->dispatchBrowserEvent('notify-alert', [
                'type' => 'error',
                'title' => 'Failed',
                'message' => 'Deposit is already claimed',
            ]);
            return;
        }
        
        if ($deposit->amount == $deposit->deducted) {
            $this->dispatchBrowserEvent('notify-alert', [
                'type' => 'error',
                'title' => 'Failed',
                'message' => 'Deposit is already fully deducted',
            ]);
            return;
        }

        $deposit->update([
            'claimed_at' => Carbon::now(),
        ]);

        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Deposit claimed successfully',
        ]);
    }

    public function render()
    {
        return view('livewire.v2.front-desk.check-out.index',[
            'transactionsGroup' => $this->guest ? $this->transactions : [],
            'deposits'=> $this->guest ? Deposit::where('guest_id',$this->guest->id)->get() : [],
        ]);
    }
}

<?php

namespace App\Http\Livewire\V2\FrontDesk\CheckOut;

use Carbon\Carbon;
use App\Models\Guest;
use App\Models\Deposit;
use Livewire\Component;
use App\Models\Transaction;
use App\Models\TransactionType;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $search = '';

    public $searchBy = '1';

    public $transactionTypes = [];

    public $guest = null;

    public $overrideAmount = '',
        $transaction;

    public $totalAmountToPay,
        $balance,
        $defaultDeposit = 200;

    protected $listeners = ['claimDeposit', 'payTransaction', 'checkOut'];

    public $queryString = ['search', 'searchBy'];

    public function payTransaction(Transaction $transaction)
    {
        $transaction->update([
            'paid_at' => Carbon::now(),
        ]);
        $this->emit('transactionUpdated');

        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Transaction Paid',
            'message' => 'Transaction has been paid',
        ]);
        $this->balance = $this->guest
            ->transactions()
            ->where('paid_at', null)
            ->sum('payable_amount');
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
                        })
                        ->first();
                    break;
            }

            if ($this->guest) {
                $this->totalAmountToPay = $this->guest
                    ->transactions()
                    ->whereNot('transaction_type_id', 2)
                    ->sum('payable_amount');
                $this->balance = $this->guest
                    ->transactions()
                    ->where('paid_at', null)
                    ->sum('payable_amount');
            } else {
                $this->dispatchBrowserEvent('notify-alert', [
                    'type' => 'error',
                    'title' => 'Guest Not Found',
                    'message' => 'Guest not found',
                ]);
                $this->guest = null;
                $this->search = '';
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
            'message' => 'Transaction has been updated',
        ]);
    }

    public function getTransactionsProperty()
    {
        return Transaction::query()
            ->where('guest_id', $this->guest->id)
            ->with('transaction_type')
            ->get()
            ->groupBy('transaction_type_id');
    }

    // public function claimDeposit(Deposit $deposit)
    // {

    //     if ($deposit->claimed_at) {
    //         $this->dispatchBrowserEvent('notify-alert', [
    //             'type' => 'error',
    //             'title' => 'Failed',
    //             'message' => 'Deposit is already claimed',
    //         ]);
    //         return;
    //     }

    //     if ($deposit->amount == $deposit->deducted) {
    //         $this->dispatchBrowserEvent('notify-alert', [
    //             'type' => 'error',
    //             'title' => 'Failed',
    //             'message' => 'Deposit is already fully deducted',
    //         ]);
    //         return;
    //     }

    //     $deposit->update([
    //         'claimed_at' => Carbon::now(),
    //     ]);

    //     $this->dispatchBrowserEvent('notify-alert', [
    //         'type' => 'success',
    //         'title' => 'Success',
    //         'message' => 'Deposit claimed successfully',
    //     ]);
    // }

    public function claimAllDeposits()
    {
        $this->guest->deposits->first()->update([
            'claimed_at' => now(),
        ]);

        $this->guest->update([
            'deposit_balance' => 0,
        ]);

        $this->guest->refresh();
    }

    public function payAllUnpaid()
    {
        $this->guest
            ->transactions()
            ->where('paid_at', null)
            ->update([
                'paid_at' => Carbon::now(),
            ]);
        $this->emit('transactionUpdated');
        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'All unpaid transactions paid successfully',
        ]);
        // return redirect()->route('front-desk.check-out');
    }

    public function validateCheckOut()
    {
        $has_unpaid_transaction = $this->guest
            ->transactions()
            ->where('paid_at', null)
            ->exists();
        if ($has_unpaid_transaction) {
            $this->dispatchBrowserEvent('notify-alert', [
                'type' => 'error',
                'title' => 'Failed',
                'message' => 'Guest has unpaid transaction',
            ]);
            return;
        }

        $has_unclaimed_deposit = $this->guest->deposit_balance > 0;

        if ($has_unclaimed_deposit) {
            $this->dispatchBrowserEvent('notify-alert', [
                'type' => 'error',
                'title' => 'Failed',
                'message' => 'Guest has unclaimed deposit',
            ]);
            return;
        }

        $this->dispatchBrowserEvent('show-reminder');
    }

    public function checkOut()
    {
        DB::beginTransaction();
        $this->guest->update([
            'totaly_checked_out' => true,
            'check_out_at' => now(),
        ]);
        $check_in_detail = $this->guest->checkInDetail;
        $check_in_detail->update([
            'check_out_at' => now(),
        ]);
        $check_in_detail->room->update([
            'room_status_id' => 7,
            'time_to_clean' => Carbon::now()->addHours(3),
            'last_check_out_at' => Carbon::now(),
        ]);

        $check_in_detail->room
            ->roomTransactionLogs()
            ->latest()
            ->first()
            ->update([
                'check_out_at' => now(),
            ]);

        DB::commit();
        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Guest checked out successfully',
        ]);
        $this->guest = null;
        $this->search = '';
        $this->searchBy = null;
        $this->dispatchBrowserEvent('close-reminder');
    }
    public function render()
    {
        return view('livewire.v2.front-desk.check-out.index', [
            'transactionsGroup' => $this->guest ? $this->transactions : [],
            'has_unpaid_transaction' => $this->guest
                ? $this->guest
                    ->transactions()
                    ->where('paid_at', null)
                    ->exists()
                : false,
            'deposits' => $this->guest
                ? Deposit::where('guest_id', $this->guest->id)->get()
                : [],
        ]);
    }

    public function mount()
    {
        $this->transactionTypes = TransactionType::all();

        if ($this->search && $this->searchBy) {
            $this->searchGuest();
        }
    }
}

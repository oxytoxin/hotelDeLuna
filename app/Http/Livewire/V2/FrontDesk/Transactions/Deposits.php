<?php

namespace App\Http\Livewire\V2\FrontDesk\Transactions;

use Carbon\Carbon;
use App\Models\Deposit;
use Livewire\Component;
use App\Models\Transaction;
use App\Traits\WithCaching;
use Illuminate\Support\Facades\DB;

class Deposits extends Component
{
    use WithCaching;

    public $guestId;

    public $guestCheckInRoomId;

    public $depositAmount,$depositRemarks;

    public $deductionAmount;

    public $deposit;


    protected $listeners = ['confirmSaveRecord','claimDeposit'];


    public function getDepositsQuery()
    {
        return Deposit::query()
            ->where('guest_id', $this->guestId)
            ->orderBy('created_at', 'DESC');
    }

    public function getDepositsProperty()
    {
        return $this->cache(function () {
            return $this->getDepositsQuery()->get();
        });
    }

    public function confirmSaveRecord()
    {
        $this->validate([
            'depositAmount' => 'required|numeric',
            'depositRemarks' => 'required',
        ]);

        DB::beginTransaction();

        \App\Models\Transaction::create([
            'branch_id' => auth()->user()->branch_id,
            'guest_id' => $this->guestId,
            'transaction_type_id' => 2,
            'room_id' => $this->guestCheckInRoomId,
            'payable_amount' => $this->depositAmount,
            'paid_at' => Carbon::now(),
            'remarks' => $this->depositRemarks,
            'front_desk_name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
        ]);
        Deposit::create([
            'guest_id' => $this->guestId,
            'amount' => $this->depositAmount,
            'remarks' => $this->depositRemarks,
            'front_desk_name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
        ]);

        DB::commit();

        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Record saved successfully',
        ]);

        $this->dispatchBrowserEvent('close-form');

        $this->emit('transactionsUpdated');

    }

    public function showDeductionModal(Deposit $deposit)
    {
        $this->useCacheRows();
        $this->deposit = $deposit;
        $this->deductionAmount = '';
        $this->dispatchBrowserEvent('show-deduction-modal');
    }

    public function saveDeduction()
    {
        if ($this->deposit->amount == $this->deposit->deducted) {

            $this->dispatchBrowserEvent('notify-alert', [
                'type' => 'error',
                'title' => 'Failed',
                'message' => 'Deposit is already fully deducted',
            ]);
            return;
        }

        if ($this->deductionAmount + $this->deposit->deducted > $this->deposit->amount) {
            $this->dispatchBrowserEvent('notify-alert', [
                'type' => 'error',
                'title' => 'Failed',
                'message' => 'Deduction exceeds deposit amount',
            ]);
            return;
        }

        $this->validate([
            'deductionAmount' => 'required|numeric|max:' . $this->deposit->amount,
        ]);

        $this->deposit->update([
            'deducted' => $this->deposit->deducted + $this->deductionAmount,
            'claimed_at'=>  $this->deductionAmount + $this->deposit->deducted == $this->deposit->amount ? Carbon::now() : null,
        ]);

        $this->emit('transactionUpdated');

        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Deduction saved successfully',
        ]);
        $this->dispatchBrowserEvent('close-deduction-modal');

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

        $this->emit('transactionUpdated');

        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Deposit claimed successfully',
        ]);
    }

    public function render()
    {
        return view('livewire.v2.front-desk.transactions.deposits',[
            'deposits' => $this->deposits,
        ]);
    }
}

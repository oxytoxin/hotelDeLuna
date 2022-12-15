<?php

namespace App\Http\Livewire\V2\FrontDesk\Transactions;

use Carbon\Carbon;
use App\Models\Guest;
use App\Models\Deposit;
use Livewire\Component;
use App\Models\Frontdesk;
use App\Models\Transaction;
use App\Traits\WithCaching;
use Illuminate\Support\Facades\DB;

class Deposits extends Component
{
    use WithCaching;

    public $guestId;

    public $guest;

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
        $ids = json_decode(auth()->user()->assigned_frontdesks);
        $frontdesks = Frontdesk::whereIn('id',$ids)->get();
        \App\Models\Transaction::create([
            'branch_id' => auth()->user()->branch_id,
            'guest_id' => $this->guestId,
            'transaction_type_id' => 2,
            'room_id' => $this->guestCheckInRoomId,
            'payable_amount' => $this->depositAmount,
            'paid_at' => Carbon::now(),
            'remarks' => $this->depositRemarks,
            'assigned_frontdesks' => auth()->user()->assigned_frontdesks,
        ]);
        $deposit = Deposit::create([
            'guest_id' => $this->guestId,
            'amount' => $this->depositAmount,
            'remarks' => $this->depositRemarks,
            'remaining' => $this->depositAmount,
            'front_desk_names' => $frontdesks->pluck('name')->implode(' and '),
        ]);
        Guest::find($this->guestId)->update([
            'total_deposits' => DB::raw('total_deposits + ' . $this->depositAmount),
            'deposit_balance' => DB::raw('deposit_balance + ' . $this->depositAmount),
        ]);
        DB::commit();

        $this->depositAmount = null;
        $this->depositRemarks = null;

        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Record saved successfully',
        ]);
        $this->dispatchBrowserEvent('close-form');
        $this->emit('transactionsUpdated');
    }

    public function showDeductionModal()
    {
        $this->useCacheRows();
        $this->deductionAmount = '';
        $this->dispatchBrowserEvent('show-deduction-modal');
    }

    public function saveDeduction()
    {
        $this->validate([
            'deductionAmount'=>'required',
        ]);

       if ($this->deductionAmount > $this->guest->deposit_balance) {
            $this->dispatchBrowserEvent('notify-alert', [
                'type' => 'error',
                'title' => 'error',
                'message' => 'Invalid Amount',
            ]);
            return;
       }

       $this->guest->update([
            'deposit_balance'=>$this->guest->deposit_balance - $this->deductionAmount,
       ]);

       $this->guest->refresh();

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

    public function mount()
    {
        $this->guest = Guest::find($this->guestId);
    }

    public function render()
    {
        return view('livewire.v2.front-desk.transactions.deposits',[
            'deposits' => $this->deposits,
            'deposit_balance'=> $this->guest->deposit_balance,
            'total_deposits'=>$this->guest->total_deposits,
            'total_deduction'=>$this->guest->total_deposits - $this->guest->deposit_balance
        ]);
    }
}

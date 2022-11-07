<?php

namespace App\Http\Livewire\FrontDesk\Transactions;

use App\Models\Deposit;
use Livewire\Component;
use App\Traits\{WithCaching, PayTransaction};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use WireUi\Traits\Actions;

class GuestDeposits extends Component
{
    use WithCaching, Actions, PayTransaction;

    public $guest_id;
    public $current_room_id;

    public $form;

    public $loaded = false;

    public function rules()
    {
        return [
            'form.guest_id' => 'required|numeric',
            'form.amount' => 'required|numeric',
            'form.remarks' => 'nullable|string',
            'form.deducted' => 'nullable',
            'form.retrieved' => 'nullable',
        ];
    }

    public function componentIsLoaded()
    {
        $this->loaded = true;
    }

    public function getTransactionsQueryProperty()
    {
        return \App\Models\Transaction::where('transaction_type_id',2)->where('guest_id', $this->guest_id);
    }

    public function getTransactionsProperty()
    {
        return $this->transactionsQuery->get();
    }

    public function makeNewForm()
    {
        $this->form = Deposit::make([
            'guest_id' => $this->guest_id,
            'retrieved' => false,
        ]);
    }

    public function save()
    {
        $this->validate();
        DB::beginTransaction();

        \App\Models\Transaction::create([
            'branch_id' => auth()->user()->branch_id,
            'guest_id' => $this->guest_id,
            'transaction_type_id' => 2,
            'room_id' => $this->current_room_id,
            'payable_amount' => $this->form->amount,
            'paid_at' => Carbon::now(),
            'remarks' => $this->form->remarks,
        ]);

        $this->form->save();

        DB::commit();

        $this->makeNewForm();

        $this->emit('transactionUpdated');

        $this->dialog()->success(
            $title = 'Success',
            $message = 'Deposit has been saved successfully',
        );
    }


    public function mount()
    {
        $this->makeNewForm();
    }

    public function render()
    {
        return view('livewire.front-desk.transactions.guest-deposits',[
            'transactions' => $this->loaded ? $this->transactions : [],
        ]);
    }
}

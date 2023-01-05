<?php

namespace App\Http\Livewire\FrontDesk\Transactions;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Transaction;
use App\Traits\WithCaching;
use App\Traits\PayTransaction;
use Illuminate\Support\Facades\DB;
use App\Models\FoodAndBeverage as ModelsFoodAndBeverage;

class FoodAndBeverage extends Component
{
    use WithCaching, Actions, PayTransaction;
    public $guest_id;

    public $current_room_id;

    public $form;
    public function rules()
    {
        return [
            'form.guest_id' => 'required',
            'form.name' => 'required',
            'form.quantity' => 'required|numeric',
            'form.price' => 'required|numeric',
            'form.front_desk_names' => 'nullable',
        ];
    }

    public function getTransactionsQueryProperty()
    {
        return \App\Models\Transaction::query();
    }
    
    public function getTransactionsProperty()
    {
        return $this->cache(function () {
            return $this->transactionsQuery->where('transaction_type_id',9)->where('guest_id', $this->guest_id)->get();
        });
    }

    public function save()
    {
        $this->validate();
        DB::beginTransaction();
       
        Transaction::create([
            'branch_id' => auth()->user()->branch_id,
            'guest_id' => $this->guest_id,
            'transaction_type_id' => 9,
            'room_id' => $this->current_room_id,
            'payable_amount' => $this->form->price,
            'remarks' => $this->form->name,
            'assigned_frontdesks'=>auth()->user()->assigned_frontdesks
       ]);

       $this->form->save();
    
       DB::commit();

       $this->makeNewForm();
       
        $this->dialog()->success(
            $title='Success',
            $description='Food and Beverage has been added.'
        );
        
    }

    public function makeNewForm()
    {
        $ids = json_decode(auth()->user()->assigned_frontdesks);
        $frontdesks = Frontdesk::whereIn('id',$ids)->get();
        $this->form = ModelsFoodAndBeverage::make([
            'guest_id' => $this->guest_id,'quantity' => 1,
            'front_desk_names' => $frontdesks->pluck('name')->implode(' and '),
        ]);
    }

    public function mount()
    {
        $this->makeNewForm();
    }


    public function render()
    {
        return view('livewire.front-desk.transactions.food-and-beverage',[
            'transactions' => $this->transactions,
        ]);
    }
}

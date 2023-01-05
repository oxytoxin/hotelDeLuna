<?php

namespace App\Http\Livewire\FrontDesk\Transactions;

use App\Models\Damage;
use App\Models\HotelItem;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Traits\{WithCaching, PayTransaction};
class AddDamages extends Component
{
    use Actions, WithCaching, PayTransaction;

    public $guest_id;

    public $current_room_id;

    public $remarks;

    public $loaded = false;

    public $damagesOrderBy = 'DESC';

    public $form;

    public function rules()
    {
        return [
            'form.guest_id' => 'required',
            'form.hotel_item_id' => 'required',
            'form.occured_at' => 'required|date',
            'form.price' => 'required|numeric',
            'form.additional_charge' => 'nullable|numeric',
            'form.front_desk_names' => 'nullable',
        ];
    }

    public $hotel_items = [];

    public function makeNewForm()
    {
        $ids = json_decode(auth()->user()->assigned_frontdesks);
        $frontdesks = Frontdesk::whereIn('id',$ids)->get();
        $this->form = Damage::make([
            'guest_id' => $this->guest_id,
            'front_desk_names' => $frontdesks->pluck('name')->implode(' and '),
        ]);
    }
    
    public function save()
    {
        $this->validate();
        DB::beginTransaction();
      
        \App\Models\Transaction::create([
            'branch_id' => auth()->user()->branch_id,
            'guest_id' => $this->guest_id,
            'transaction_type_id' => 4,
            'payable_amount' => $this->form->price + $this->form->additional_charge,
            'room_id' => $this->current_room_id,
            'remarks' => $this->remarks,
            'assigned_frontdesks'=>auth()->user()->assigned_frontdesks,
        ]);

        $this->form->save();
        DB::commit();

        $this->makeNewForm();
        $this->dialog()->success(
            $title = 'Success',
            $message = 'Damage has been added successfully'
        );
    }
     
    public function getTransactionsQueryProperty()
    {
        return \App\Models\Transaction::where('transaction_type_id',4)->where('guest_id', $this->guest_id);
    }
    
    public function getTransactionsProperty()
    {
        return $this->cache(function () {
            return $this->transactionsQuery->get();
        });
    }

    public function updatedFormHotelItemId()
    {
        $this->useCacheRows();
        $hotelItems = HotelItem::find($this->form->hotel_item_id);
        $this->form->price = $hotelItems->price;
        $this->remarks= 'Damage :'.$hotelItems->name;
    }

    public function componentIsLoaded()
     {
        $this->loaded = true;
         $this->hotel_items = HotelItem::where('branch_id', auth()->user()->branch_id)->get();
     }

    public function mount()
    {
       $this->makeNewForm();
    }

    public function render()
    {
        return view('livewire.front-desk.transactions.add-damages',[
            'transactions' => $this->loaded ? $this->transactions : [],
        ]);
    }
}

<?php

namespace App\Http\Livewire\FrontDesk\Transactions;

use App\Models\Damage;
use App\Models\HotelItem;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\Actions;

class AddDamages extends Component
{
    use Actions;

    public $guest_id;

    public $damagesOrderBy = 'DESC';

    public $form = [
        'item_id' => null,
        'occured_at' => null,
        'amount' => null,
        'additional_amount' => null,
        'paid' => false,
    ];

    protected $validationAttributes = [
        'form.item_id' => 'item',
        'form.occured_at' => 'occured at field',
        'form.amount' => 'amount',
        'form.additional_amount' => 'additional amount',
        'form.paid' => 'paid',
    ];

    public $hotel_items = [];

    public function toogleDamagesOrderBy()
    {
        $this->damagesOrderBy = $this->damagesOrderBy == 'DESC' ? 'ASC' : 'DESC';
    }

    public function save()
    {
        $check_in_detail = Transaction::where('guest_id', $this->guest_id)->where('transaction_type_id', 1)->first();
        $this->validate([
            'form.item_id' => 'required',
            'form.amount' => 'required|numeric',
            'form.additional_amount' => 'nullable|numeric',
            'form.occured_at' => 'required|date|after_or_equal:' . $check_in_detail->created_at,
        ]);
        DB::beginTransaction();
        $damage_transaction = Transaction::create([
            'branch_id' => auth()->user()->branch_id,
            'guest_id' => $this->guest_id,
            'transaction_type_id' => 4,
            'payable_amount' => $this->form['amount'] + $this->form['additional_amount'],
            'paid_at' => $this->form['paid'] ? now() : null,
        ]);
        Damage::create([
            'transaction_id' => $damage_transaction->id,
            'hotel_item_id' => $this->form['item_id'],
            'amount' => $this->form['amount'],
            'additional_amount' => $this->form['additional_amount'],
            'occured_at' => $this->form['occured_at'],
        ]);
      
        DB::commit();
        $this->reset('form');
        $this->notification()->success(
            $title = 'Success',
            $message = 'Damage has been added successfully'
        );
    }

    public function clear_form()
    {
        $this->reset('form');
    }

    public function mount()
    {
        $this->hotel_items = HotelItem::where('branch_id', auth()->user()->branch_id)->get();
    }

    public function updatedFormItemId()
    {
        $this->form['amount'] = HotelItem::find($this->form['item_id'])->price;
    }

    public function render()
    {
        return view('livewire.front-desk.transactions.add-damages', [
            'damages' => Damage::whereHas('transaction', function ($query) {
                $query->where('guest_id', $this->guest_id);
            })
            ->orderBy('created_at', $this->damagesOrderBy)
            ->get()
        ]);
    }
}

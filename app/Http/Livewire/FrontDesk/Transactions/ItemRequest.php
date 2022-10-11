<?php

namespace App\Http\Livewire\FrontDesk\Transactions;

use App\Models\GuestRequestItem;
use App\Models\RequestableItem;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\Actions;
class ItemRequest extends Component
{
    use Actions;

    public $guest_id = null;

    public $form = ['requestable_item_id' => null, 'quantity' => '1','additional_amount'=>null,'paid' => false];

    public $requestOrder = "DESC";

    protected $validationAttributes = [
        'form.requestable_item_id' => 'item',
        'form.quantity' => 'quantity',
        'form.additional_amount' => 'additional amount',
        'form.paid' => 'paid',
    ];

    public $requestable_items = [];

    public function mount()
    {
        $this->requestable_items = RequestableItem::where('branch_id', auth()->user()->branch_id)->get();
    }

    public function toggleToggleRequestOrder()
    {
        $this->requestOrder = $this->requestOrder == "DESC" ? "ASC" : "DESC";
    }

    public function saveRecord()
    {
        $this->validate([
            'form.requestable_item_id' => 'required',
            'form.quantity' => 'required|numeric',
            'form.additional_amount' => 'nullable|numeric',
            'form.quantity' => 'required|numeric|min:1',
        ]);
        DB::beginTransaction();
        $requestable_item = RequestableItem::find($this->form['requestable_item_id']);
        $total_amount = $requestable_item->price * $this->form['quantity'];
        GuestRequestItem::create([
            'guest_id' => $this->guest_id,
            'requestable_item_id' => $this->form['requestable_item_id'],
            'quantity' => $this->form['quantity'],
            'amount'=> $total_amount,
            'additional_amount'=> $requestable_item->additional_amount,
        ]);
        Transaction::create([
            'branch_id'=> auth()->user()->branch_id,
            'guest_id' => $this->guest_id,
            'payable_amount' => $total_amount + $requestable_item->additional_amount,
            'paid_at' => $this->form['paid'] ? now() : null,
            'transaction_type_id'=>8
        ]);
        DB::commit();
        $this->notification()->success(
            $title = 'Success',
            $message = 'Request has been added successfully'
        );
        $this->reset('form');
    }

    public function clearForm()
    {
        $this->reset('form');
    }
    public function render()
    {
        return view('livewire.front-desk.transactions.item-request',[
            'guest_request_items' => $this->guest_id ? 
                            GuestRequestItem::where('guest_id',$this->guest_id)
                            ->with('requestable_item')
                            ->orderBy('created_at',$this->requestOrder)
                            ->get() : []
        ]);
    }
}
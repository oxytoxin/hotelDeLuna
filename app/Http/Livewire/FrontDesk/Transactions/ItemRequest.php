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
        $ids = json_decode(auth()->user()->assigned_frontdesks);
        $frontdesks = Frontdesk::whereIn('id',$ids)->get();
        $requestable_item = RequestableItem::find($this->form['requestable_item_id']);
        $total_amount = $requestable_item->price * $this->form['quantity'];
        $check_in_detail = Transaction::where('guest_id', $this->guest_id)->where('transaction_type_id', 1)->first()->check_in_detail;
        $request_item_transaction = Transaction::create([
            'branch_id'=> auth()->user()->branch_id,
            'guest_id' => $this->guest_id,
            'payable_amount' => $total_amount + $requestable_item->additional_amount,
            'paid_at' => $this->form['paid'] ? now() : null,
            'transaction_type_id'=>8,
            'room_id' => $check_in_detail->room_id,
            'assigned_frontdesks'=>auth()->user()->assigned_frontdesks
        ]);
        GuestRequestItem::create([
            'transaction_id' => $request_item_transaction->id,
            'requestable_item_id' => $this->form['requestable_item_id'],
            'quantity' => $this->form['quantity'],
            'amount'=> $total_amount,
            'additional_amount'=> $requestable_item->additional_amount,
            'front_desk_names' => $frontdesks->pluck('name')->implode(' and '),
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
                            GuestRequestItem::whereHas('transaction',function($query){
                                $query->where('guest_id',$this->guest_id);
                            })
                            ->with('requestable_item')
                            ->orderBy('created_at',$this->requestOrder)
                            ->get() : []
        ]);
    }
}

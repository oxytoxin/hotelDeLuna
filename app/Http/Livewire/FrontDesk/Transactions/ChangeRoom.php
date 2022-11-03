<?php

namespace App\Http\Livewire\FrontDesk\Transactions;

use Carbon\Carbon;
use App\Models\Rate;
use App\Models\Room;
use App\Models\Type;
use App\Models\Floor;
use Livewire\Component;
use App\Models\RoomChange;
use App\Models\RoomStatus;
use WireUi\Traits\Actions;
use App\Models\Transaction;
use App\Models\CheckInDetail;
use App\Models\Deposit;
use Illuminate\Support\Facades\DB;

class ChangeRoom extends Component
{
    use Actions;

    public $check_in_detail;

    public $guest;

    public $historyOrder = 'DESC';

    public $available_types = [], $floors = [], $available_rooms = [];

    public $check_in_detail_id;

    public $room_statuses =[];

    public $new_room_rate = null;
    
    public $new_amount_to_pay;

    public $form = [
        'type_id' => null,
        'room_id' => null,
        'reason' => null,
        'paid' => false,
        'floor_id' => null,
        'room_status_id' => null,
    ];

    public $current_room = null;


    public $authorization_code;

    public $has_refundable_amount = false;

    protected $validationAttributes = [
        'form.type_id' => 'type',
        'form.room_id' => 'room',
        'form.reason' => 'reason',
        'form.paid' => 'paid',
        'form.floor_id' => 'floor',
        'form.room_status_id' => 'room status',
    ];

    public $selected_room = [
        'id' => null,
        'number' => null,
    ];

    public function historyOrderToggle()
    {
        $this->historyOrder = $this->historyOrder == 'DESC' ? 'ASC' : 'DESC';
    }

    public function select_room($room_id, $room_number)
    {
        if ($this->selected_room['id'] == null) {
            $this->selected_room = [
                'id' => $room_id,
                'number' => $room_number,
            ];
        }
    }

    public function remove()
    {
        $this->selected_room = [
            'id' => null,
            'number' => null,
        ];
    }

    protected function has_already_change_room_twice()
    {
        return  RoomChange::whereHas('transaction', function ($query) {
            $query->where('guest_id', $this->check_in_detail->transaction->guest_id);
        })->count() >= 2;
    }

    protected function three_hours_already_past_since_check_in()
    {
        return Carbon::parse($this->check_in_detail->check_in_at)->diffInHours(now()) >= 3;
    }

    public function saveChanges()
    {
        $this->validate([
            'form.type_id' => 'required',
            'form.room_id' => 'required',
            'form.reason' => 'required',
            'form.floor_id' => 'required',
            'form.room_status_id' => 'required',
            'authorization_code' => 'required|in:' . auth()->user()->branch->authorization_code,
        ]);
        if ($this->has_already_change_room_twice()) {
            $this->dialog()->error(
                $title = 'Error',
                $description = 'You can not change room more than 2 times'
            );
            return;
        }
        DB::beginTransaction();
        $transaction = $this->check_in_detail->transaction;
        $new_room = Room::find($this->form['room_id']);
        if ($this->three_hours_already_past_since_check_in()) {
            $this->dialog()->error(
                $title = 'Error',
                $description = 'You can not change room after 3 hours of check in'
            );
            return;
        }

        if ($this->current_room->id == $new_room->id) {
            $this->dialog()->error(
                $title = 'Error',
                $description = 'From and To Room cannot be same'
            );
            return;
        }
        $new_selected_room_amount = $this->new_room_rate->amount;
        $old_selected_room_amount_paid = $this->check_in_detail->transaction->payable_amount;
        $change_room_transaction = Transaction::create([
            'branch_id' => auth()->user()->branch_id,
            'guest_id' => $transaction->guest_id,
            'transaction_type_id' => 7,
            'payable_amount' => $old_selected_room_amount_paid > $new_selected_room_amount ? 0 : $new_selected_room_amount - $old_selected_room_amount_paid,
            'paid_at' => $this->form['paid'] ? now() : null,
            'room_id' => $new_room->id,
        ]);

        if ( $old_selected_room_amount_paid > $new_selected_room_amount) {
            $deposit_transaction = Transaction::create([
                'branch_id' => auth()->user()->branch_id,
                'guest_id' => $transaction->guest_id,
                'transaction_type_id' => 2,
                'payable_amount' =>  $old_selected_room_amount_paid - $new_selected_room_amount ,
                'paid_at' => now(),
                'room_id' => $new_room->id,
            ]);
            Deposit::create([
                'transaction_id' => $deposit_transaction->id,
                'amount' => $old_selected_room_amount_paid - $new_selected_room_amount,
                'remarks' => 'Deposit from transfer room transaction',
            ]);
        }

        $this->check_in_detail->update([
            'room_id' => $new_room->id,
            'rate_id' => $this->new_room_rate->id,
        ]);

        RoomChange::create([
            'transaction_id' => $change_room_transaction->id,
            'from_room_id' => $this->current_room->id,
            'to_room_id' => $this->form['room_id'],
            'reason' => $this->form['reason'],
            'amount' => $new_selected_room_amount,
        ]);
       
        $this->current_room->update([
            'room_status_id' => $this->form['room_status_id'],
        ]);
        $new_room->update([
            'room_status_id' => 2,
        ]);
        DB::commit();
        $message = 'Room changed successfully';
        if ($new_selected_room_amount < $old_selected_room_amount_paid) {
            $message = 'Room has been changed successfully. ₱ '.$old_selected_room_amount_paid - $new_selected_room_amount.' has been refunded and saved as deposits to the guest account';
        }
        $this->dialog()->info(
            $title = 'Success',
            $description = $message,
        );
        $this->reset('form');
        $this->authorization_code = null;
        $this->available_rooms = [];
        $this->reload();

        $this->emit('room_changed');
    }

    public function clear_form()
    {
        $this->reset('form');
    }
    public function updatedFormTypeId()
    {
        $this->new_room_rate = Rate::where('type_id', $this->form['type_id'])
            ->where('staying_hour_id', $this->check_in_detail->rate->staying_hour_id)
            ->where('branch_id', auth()->user()->branch_id)
            ->first();
        $this->new_amount_to_pay = $this->new_room_rate->amount;
        $this->authorization_code ='';
        $this->available_rooms = Room::where('floor_id', $this->form['floor_id'])
            ->where('type_id', $this->form['type_id'])
            ->whereIn('room_status_id', [1,9])
            ->get();
        if ($this->available_rooms->count() == 0) {
            if ($this->form['type_id'] != null && $this->form['floor_id'] != null) {
                $this->notification()->error(
                    $title = 'Error',
                    $description = 'No room available for this type and floor'
                );
            }
        } else {
            $this->dispatchBrowserEvent('room-is-available');
        }
    }

    public function updatedFormFloorId()
    {
        $this->new_room_rate = Rate::where('type_id', $this->form['type_id'])
            ->where('staying_hour_id', $this->check_in_detail->rate->staying_hour_id)
            ->where('branch_id', auth()->user()->branch_id)
            ->first();
        $this->new_amount_to_pay = $this->new_room_rate->amount;
        $this->authorization_code ='';
        $this->available_rooms = Room::where('floor_id', $this->form['floor_id'])
            ->where('type_id', $this->form['type_id'])
            ->where('room_status_id', 1)
            ->get();

        if ($this->available_rooms->count() == 0) {
            if ($this->form['type_id'] != null && $this->form['floor_id'] != null) {
                $this->dialog()->error(
                    $title = 'Error',
                    $description = 'No room available for this type and floor'
                );
            }
        } else {
            $this->dispatchBrowserEvent('room-is-available');
        }
    }

    public function reload()
    {
        $this->check_in_detail = CheckInDetail::find($this->check_in_detail_id);
        $this->current_room = $this->check_in_detail->room;
        $this->floors = Floor::where('branch_id', auth()->user()->branch_id)->get();
        $this->form['type_id'] = $this->current_room->type_id;
        $this->new_room_rate = Rate::where('type_id', $this->form['type_id'])
            ->where('staying_hour_id', $this->check_in_detail->rate->staying_hour_id)
            ->where('branch_id', auth()->user()->branch_id)
            ->first();
        $this->new_amount_to_pay = $this->new_room_rate->amount;
    }
    public function mount()
    {
        $this->check_in_detail = CheckInDetail::find($this->check_in_detail_id);
        $this->room_statuses = RoomStatus::whereIn('id', [ 7,9])->get();
        $this->authorization_code ='';
        $this->current_room = $this->check_in_detail->room;
        $this->available_types = Type::query()
            ->where('branch_id', auth()->user()->branch_id)
            ->get();
        $this->floors = Floor::where('branch_id', auth()->user()->branch_id)->get();
        $this->form['type_id'] = $this->current_room->type_id;
    }
    public function render()
    {
        return view('livewire.front-desk.transactions.change-room', [
            'changes_history' => RoomChange::whereHas('transaction', function ($query) {
                $query->where('guest_id', $this->check_in_detail->transaction->guest_id);
            })->with(['fromRoom', 'toRoom'])
                ->orderBy('created_at', $this->historyOrder)
                ->get(),
        ]);
    }
}

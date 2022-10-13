<?php

namespace App\Http\Livewire\FrontDesk\Transactions;

use Carbon\Carbon;
use App\Models\Rate;
use App\Models\Room;
use App\Models\Type;
use App\Models\Floor;
use Livewire\Component;
use App\Models\RoomChange;
use WireUi\Traits\Actions;
use App\Models\Transaction;
use App\Models\CheckInDetail;
use Illuminate\Support\Facades\DB;

class ChangeRoom extends Component
{
    use Actions;

    public $historyOrder = 'DESC';

    public $available_types = [], $floors = [], $available_rooms = [];

    public $check_in_detail_id;

    public $form = [
        'type_id' => null,
        'room_id' => null,
        'reason' => null,
        'paid' => false,
        'floor_id' => null,
    ];

    public $current_room = null;

    public $check_in_detail = null;

    public $authorization_code;

    protected $validationAttributes = [
        'form.type_id' => 'type',
        'form.room_id' => 'room',
        'form.reason' => 'reason',
        'form.paid' => 'paid',
        'floor_id' => 'floor'
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

        // identifying the amount applied in the old room and the new room to get the balance to be applied in the new transaction
        $new_room_rate = Rate::where('type_id', $this->form['type_id'])
            ->where('staying_hour_id', $this->check_in_detail->rate->staying_hour_id)
            ->where('branch_id', auth()->user()->branch_id)
            ->first();
        $new_selected_room_amount = $new_room_rate->amount;
        $old_selected_room_amount_paid = $this->check_in_detail->transaction->payable_amount;

        $change_room_transaction = Transaction::create([
            'branch_id' => auth()->user()->branch_id,
            'guest_id' => $transaction->guest_id,
            'transaction_type_id' => 7,
            'payable_amount' => $old_selected_room_amount_paid > $new_selected_room_amount ? $old_selected_room_amount_paid - $new_selected_room_amount : $new_selected_room_amount - $old_selected_room_amount_paid,
            'paid_at' => $this->form['paid'] ? now() : null,
        ]);

        $this->check_in_detail->update([
            'room_id' => $new_room->id,
            'rate_id' => $new_room_rate->id,
        ]);

        RoomChange::create([
            'transaction_id' => $change_room_transaction->id,
            'from_room_id' => $this->current_room->id,
            'to_room_id' => $this->form['room_id'],
            'reason' => $this->form['reason'],
            'amount' => $new_selected_room_amount,
        ]);
        $this->current_room->update([
            'room_status_id' => 5,
        ]);
        $new_room->update([
            'room_status_id' => 2,
        ]);
        DB::commit();
        $this->notification()->success(
            $title = 'Success',
            $description = 'Room has been changed successfully'
        );
        $this->reset('form');
        $this->authorization_code = null;
        $this->available_rooms = [];
    }

    public function clear_form()
    {
        $this->reset('form');
    }

    public function mount()
    {
        $this->authorization_code ='';
        $this->check_in_detail = CheckInDetail::find($this->check_in_detail_id);
        $this->current_room = $this->check_in_detail->room;
        $this->available_types = Type::query()
            ->where('branch_id', auth()->user()->branch_id)
            ->get();
        $this->floors = Floor::where('branch_id', auth()->user()->branch_id)->get();
        $this->form['type_id'] = $this->current_room->type_id;
    }

    public function updatedFormTypeId()
    {
        $this->authorization_code ='';
        $this->available_rooms = Room::where('floor_id', $this->form['floor_id'])
            ->where('type_id', $this->form['type_id'])
            ->where('room_status_id', 1)
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

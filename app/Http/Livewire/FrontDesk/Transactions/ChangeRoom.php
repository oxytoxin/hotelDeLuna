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

    public $types_within_this_branch = [], $floors_within_this_branch = [];

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
        return  RoomChange::where('check_in_detail_id', $this->check_in_detail_id)->count() >= 2;
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
        ]);
        if ($this->has_already_change_room_twice()) {
            $this->notification()->error(
                $title = 'Error',
                $description = 'You can not change room more than 2 times'
            );
            return;
        }
        DB::beginTransaction();
        $transaction = $this->check_in_detail->transaction;
        $new_room = Room::find($this->form['room_id']);
        if ($this->three_hours_already_past_since_check_in()) {
            $this->notification()->error(
                $title = 'Error',
                $description = 'You can not change room after 3 hours of check in'
            );
            return;
        }

        if ($this->current_room->id == $new_room->id) {
            $this->notification()->error(
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

        Transaction::create([
            'branch_id' => auth()->user()->branch_id,
            'guest_id' => $transaction->guest_id,
            'transaction_type_id' => 7,
            'payable_amount' => $new_selected_room_amount,
            'paid_at' => $this->form['paid'] ? now() : null,
        ]);

        $this->check_in_detail->update([
            'room_id' => $new_room->id,
            'rate_id' => $new_room_rate->id,
        ]);

        RoomChange::create([
            'check_in_detail_id' => $this->check_in_detail->id,
            'from_room_id' => $this->current_room->id,
            'to_room_id' => $this->form['room_id'],
            'reason' => $this->form['reason'],
            'amount'=> $new_selected_room_amount,
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
    }

    public function clear_form()
    {
        $this->reset('form');
    }

    public function mount()
    {
        $this->check_in_detail = CheckInDetail::find($this->check_in_detail_id);
        $this->current_room = $this->check_in_detail->room;
        $this->types_within_this_branch = Type::query()
            ->where('branch_id', auth()->user()->branch_id)
            ->get();
        $this->floors_within_this_branch = Floor::where('branch_id', auth()->user()->branch_id)->get();
    }

    public function render()
    {
        return view('livewire.front-desk.transactions.change-room', [
            'rooms_within_this_branch' => $this->form['floor_id'] && $this->form['type_id'] ? Room::where('floor_id', $this->form['floor_id'])
                ->where('type_id', $this->form['type_id'])
                ->where('room_status_id', 1)
                ->get() : [],
            'changes_history' => RoomChange::where('check_in_detail_id', $this->check_in_detail_id)
                                    ->with(['fromRoom', 'toRoom'])
                                    ->orderBy('created_at', $this->historyOrder)
                                    ->get(),
        ]);
    }
}

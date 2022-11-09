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
use App\Models\RoomTransactionLog;
use Illuminate\Support\Facades\DB;
use App\Traits\{WithCaching,PayTransaction};
class ChangeRoom extends Component
{
    use Actions, WithCaching, PayTransaction;

    public $tabIsVisible = false;

    public $check_in_detail;

    public $guest_id;

    public $historyOrder = 'DESC';

    public $available_types = [], $floors = [], $available_rooms = [];

    public $check_in_detail_id;

    public $guestCheckInDetail;

    public $room_statuses = [];

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

    function getPreviousRoomAmount()
    {
            if (RoomChange::where('guest_id', $this->guest_id)->exists()) {
               return Transaction::where('guest_id', $this->guest_id)
                                ->where('transaction_type_id', 7)
                                ->latest()
                                ->first()
                                 ->payable_amount;
            } else {
                return Transaction::where('guest_id', $this->guest_id)
                                ->where('transaction_type_id', 1)
                                ->latest()
                                ->first()
                                 ->payable_amount;
            }
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

        DB::beginTransaction();
        $old_room = $this->guestCheckInDetail->room;

        $new_room = Room::find($this->form['room_id']);

        if ($new_room->room_status_id != 1) {
            $this->dialog()->error(
                $title = 'Error',
                $description = 'Looks like the room you selected is not available'
            ); 
            return;
        }

        if (Carbon::parse($this->guestCheckInDetail->check_in_at)->diffInHours(now()) >= 3) {
            $this->dialog()->error(
                $title = 'Error',
                $description = 'You can not change room after 3 hours of check in'
            );
            return;
        }

        if ($this->guestCheckInDetail->room->id == $new_room->id) {
            $this->dialog()->error(
                $title = 'Error',
                $description = 'From and To Room cannot be same'
            );
            return;
        }

        $new_room_amount = $this->new_room_rate->amount;
        
        $old_room_amount  = $this->getPreviousRoomAmount();
       
        Transaction::create([
            'branch_id' => auth()->user()->branch_id,
            'guest_id' => $this->guestCheckInDetail->guest_id,
            'transaction_type_id' => 7,
            'payable_amount' => $old_room_amount > $new_room_amount ? 0 : $new_room_amount - $old_room_amount,
            'paid_at' => $this->form['paid'] ? now() : null,
            'room_id' => $new_room->id,
            'remarks' => 'Guest transfered from ROOM # ' . $this->guestCheckInDetail->room->number . ' ( ' . $this->guestCheckInDetail->room->type->name . ' ) to ROOM # ' . $new_room->number . ' ( ' . $new_room->type->name . ' )',
            'front_desk_name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
        ]);

        if ($old_room_amount > $new_room_amount) {
            $deposit_transaction = Transaction::create([
                'branch_id' => auth()->user()->branch_id,
                'guest_id' => $this->guestCheckInDetail->guest_id,
                'transaction_type_id' => 2,
                'payable_amount' =>  $old_room_amount - $new_room_amount,
                'paid_at' => now(),
                'room_id' => $new_room->id,
                'front_desk_name' => auth()->user()->name,
                'user_id' => auth()->user()->id,
                'remarks'=>'Extra amount paid from previous room',
            ]);
            Deposit::create([
                'guest_id' => $this->guestCheckInDetail->guest_id,
                'amount' => $old_room_amount - $new_room_amount,
                'remarks' => 'Deposit from transfer room transaction',
                'front_desk_name' => auth()->user()->name,
                'user_id' => auth()->user()->id,
            ]);
        }

        RoomChange::create([
            'guest_id' => $this->guestCheckInDetail->guest_id,
            'from_room_id' => $old_room->id,
            'to_room_id' => $this->form['room_id'],
            'reason' => $this->form['reason'],
            'amount' => $new_room_amount,
            'front_desk_name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
        ]);

        $this->guestCheckInDetail->update([
            'room_id' => $new_room->id,
            'rate_id' => $this->new_room_rate->id,
        ]);

        $old_room->update([
            'room_status_id' => $this->form['room_status_id'],
            'last_check_out_at'=> Carbon::now(),
        ]);

        $old_room->roomTransactionLogs()->latest()->first()->update([
            'check_out_at' => Carbon::now(),
            'guest_transfered'=>true,
        ]);

        $new_room->update([
            'room_status_id' => 2,
        ]);

        $new_room->roomTransactionLogs()->create([
            'branch_id' => auth()->user()->branch_id,
            'room_number'=> $new_room->number,
            'check_in_detail_id' => $this->guestCheckInDetail->id,
            'check_in_at' => Carbon::now(),
            'time_interval'=> $new_room->last_check_out_at ? Carbon::parse($new_room->last_check_out_at)->diffInMinutes(Carbon::now()) : 0,
        ]);


        DB::commit();
        $message = 'Room changed successfully';
        if ($new_room_amount < $old_room_amount) {
            $message = 'Room has been changed successfully. ₱ ' . $old_room_amount - $new_room_amount . ' has been refunded and saved as deposits to the guest account';
        }
        $this->dialog()->info(
            $title = 'Success',
            $description = $message,
        );
        $this->reset('form');
        $this->authorization_code = null;
        $this->available_rooms = [];
        $this->guestCheckInDetail->refresh();
        $this->form['type_id'] = $this->guestCheckInDetail->room->type_id;
        $this->emit('room_changed');
    }



    public function updatedFormFloorId()
    {
        $this->useCacheRows();
        $this->new_room_rate = Rate::where('type_id', $this->form['type_id'])
            ->where('staying_hour_id', $this->guestCheckInDetail->rate->staying_hour_id)
            ->where('branch_id', auth()->user()->branch_id)
            ->first();
        $this->new_amount_to_pay = $this->new_room_rate->amount;
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

    public function visible()  // load all neccessary data when the component is visible
    {
        $this->tabIsVisible = true;

        $this->room_statuses = RoomStatus::whereIn('id', [7, 9])->get();

        $this->available_types = Type::query()
            ->where('branch_id', auth()->user()->branch_id)
            ->get();

        $this->floors = Floor::where('branch_id', auth()->user()->branch_id)->get();

        $this->guestCheckInDetail = CheckInDetail::where('id', $this->check_in_detail_id)
            ->with(['room.type', 'rate.staying_hour', 'transaction'])
            ->first();

        $this->form['type_id'] = $this->guestCheckInDetail->room->type->id;
    }

    public function render()
    {
        return view('livewire.front-desk.transactions.change-room', [
            'changes_history' => $this->tabIsVisible ? $this->transferHistories : [],
        ]);
    }


    ////////////////////////////////////

    public function getTransferHistoriesQueryProperty()
    {
        return Transaction::where('guest_id', $this->guest_id)
            ->where('transaction_type_id', 7);
    }

    public function getTransferHistoriesProperty()
    {
        return $this->cache(function () {
            return $this->transferHistoriesQuery->latest()->get();
        }, 'change_room_transfer_histories');
    }
   
    public function clear_form()
    {
        $this->reset('form');
    }
    public function updatedFormTypeId()
    {
        $this->useCacheRows();
        $this->new_room_rate = Rate::where('type_id', $this->form['type_id'])
            ->where('staying_hour_id', $this->guestCheckInDetail->rate->staying_hour_id)
            ->where('branch_id', auth()->user()->branch_id)
            ->first();
        $this->new_amount_to_pay = $this->new_room_rate->amount;
        $this->available_rooms = Room::where('floor_id', $this->form['floor_id'])
            ->where('type_id', $this->form['type_id'])
            ->whereIn('room_status_id', [1, 9])
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

    // accessiblity
    public function historyOrderToggle()
    {
        $this->historyOrder = $this->historyOrder == 'DESC' ? 'ASC' : 'DESC';
    }
}

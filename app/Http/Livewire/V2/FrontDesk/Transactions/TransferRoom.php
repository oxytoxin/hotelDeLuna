<?php

namespace App\Http\Livewire\V2\FrontDesk\Transactions;

use Carbon\Carbon;
use App\Models\Rate;
use App\Models\Room;
use App\Models\Type;
use App\Models\Floor;
use App\Models\Deposit;
use Livewire\Component;
use App\Models\RoomChange;
use App\Models\Transaction;
use App\Traits\WithCaching;
use App\Models\CheckInDetail;
use Illuminate\Support\Facades\DB;

class TransferRoom extends Component
{
    use WithCaching;

    public $oldRoomId;
    public $oldRoomTypeId;
    public $oldRoomStatus;
    public $oldRoomAmount;
    public $oldRoomNumber;
    public $oldRoomTypeName;

    public $oldCheckInRateId;
    public $oldCheckInStayingHourId;


    public $roomTypes = [], $floors = [], $availableRooms = [], $roomStatuses = [];

    public $guestId;

    public $guestCheckInTime;
    public $guestCheckInDetailId;

    public $authorizationCode;

    public $newRoomTypeId, $newRoomFloorId, $newRoomId, $newRoomAmount, $reason, $saveAsDeposit = 0, $newRoomRate;

    public $hasAvailableRoom = false;

    protected $listeners = ['confirmSaveChanges', 'payTransaction', 'depositDeducted' => '$refresh'];

    public function payWithDeposit($transaction_id, $payable_amount)
    {
        $this->emit('payWithDeposit', [
            'guest_id' => $this->guestId,
            'transaction_id' => $transaction_id,
            'payable_amount' => $payable_amount
        ]);
    }
    public function payTransaction(Transaction $transaction)
    {
        $transaction->update([
            'paid_at' => Carbon::now(),
        ]);
        $this->emit('transactionUpdated');

        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Transaction Paid',
            'message' => 'Transaction has been paid'
        ]);
    }

    public function getTransactionsProperty()
    {
        return $this->cache(function () {
            return Transaction::where('transaction_type_id', 7)
                ->where('guest_id', $this->guestId)->get();
        }, 'transfer-room');
    }

    function getOldRoomAmount()
    {
        if (RoomChange::where('guest_id', $this->guestId)->exists()) {
            return RoomChange::where('guest_id', $this->guestId)->latest()->first()->amount;
        } else {
            return Transaction::where('guest_id', $this->guestId)
                ->where('transaction_type_id', 1)
                ->latest()
                ->first()
                ->payable_amount;
        }
    }

    function loadRoomStatuses()
    {
        $this->roomStatuses = [
            [
                'id' => 7,
                'name' => 'Uncleaned',
            ],
            [
                'id' => 9,
                'name' => 'Cleaned',
            ],
        ];
    }

    public function updatedNewRoomTypeId()
    {
        $this->availableRooms = Room::where('floor_id', $this->newRoomFloorId)
            ->where('type_id', $this->newRoomTypeId)
            ->where('room_status_id', 1)
            ->get();
        if (count($this->availableRooms) > 0) {
            $this->hasAvailableRoom = true;
        } else {
            $this->hasAvailableRoom = false;
        }

        $this->newRoomAmount = null;
    }

    public function updatedNewRoomFloorId()
    {
        $this->availableRooms = Room::where('floor_id', $this->newRoomFloorId)
            ->where('type_id', $this->newRoomTypeId)
            ->where('room_status_id', 1)
            ->get();
        if (count($this->availableRooms) > 0) {
            $this->hasAvailableRoom = true;
        } else {
            $this->hasAvailableRoom = false;
        }
    }

    public function mount()
    {
        $this->roomTypes = Type::where('branch_id', auth()->user()->branch_id)->get();
        $this->floors = Floor::where('branch_id', auth()->user()->branch_id)->get();
        $this->availableRooms = Room::where('floor_id', $this->newRoomFloorId)
            ->where('type_id', $this->newRoomTypeId)
            ->where('room_status_id', 1)
            ->get();
        if (count($this->availableRooms) > 0) {
            $this->hasAvailableRoom = true;
        } else {
            $this->hasAvailableRoom = false;
        }
        $this->oldRoomAmount = $this->getOldRoomAmount();
        $this->loadRoomStatuses();
    }

    public function updatedNewRoomId()
    {
        $this->newRoomRate = Rate::where('branch_id', auth()->user()->branch_id)
            ->where('type_id', $this->newRoomTypeId)
            ->where('staying_hour_id', $this->oldCheckInStayingHourId)
            ->first();
        $this->newRoomAmount = $this->newRoomRate->amount;
    }
    public function render()
    {
        return view('livewire.v2.front-desk.transactions.transfer-room', [
            'transactions' => $this->transactions,
        ]);
    }


    // saving changes

    public function confirmSaveChanges()
    {
        $authorizationCode = auth()->user()->branch->authorization_code;

        if (!$authorizationCode) {
            $this->dispatchBrowserEvent('notify-alert', [
                'type' => 'error',
                'title' => 'Authorization Code Not Set',
                'message' => 'Please set the authorization code in the settings'
            ]);
            return;
        }

        if ($this->authorizationCode != $authorizationCode) {
            $this->dispatchBrowserEvent('notify-alert', [
                'type' => 'error',
                'title' => 'Authorization Code',
                'message' => 'Authorization code is incorrect'
            ]);
            return;
        }


        $this->validate([
            'newRoomId' => 'required',
            'reason' => 'required',
            'oldRoomStatus' => 'required',
        ]);

        if ($this->hasAvailableRoom == false) {
            $this->dispatchBrowserEvent('notify-alert', [
                'type' => 'error',
                'title' => 'Failed to proceed',
                'text' => 'Please select a room',
                'buttonText' => 'Got it',
            ]);
            return;
        }

        DB::beginTransaction();

        $newRoom = Room::find($this->newRoomId);

        if ($newRoom->room_status_id != 1) {
            $this->dispatchBrowserEvent('notify-alert', [
                'type' => 'error',
                'title' => 'Failed to proceed',
                'text' => 'Room has been selected by another guest',
                'buttonText' => 'Got it',
            ]);
            return;
        }

        if (Carbon::parse($this->guestCheckInTime)->diffInHours(now()) >= 3) {
            $this->dispatchBrowserEvent('notify-alert', [
                'type' => 'error',
                'title' => 'Failed to proceed',
                'message' => 'Guest has been checked in for more than 3 hours',
                'buttonText' => 'Got it',
            ]);
            return;
        }

        if ($this->oldRoomId == $this->newRoomId) {
            $this->dispatchBrowserEvent('notify-alert', [
                'type' => 'error',
                'title' => 'Failed to proceed',
                'message' => 'Old room and new room cannot be the same',
                'buttonText' => 'Got it',
            ]);
            return;
        }

        $transactionPayableAmount = $this->oldRoomAmount >= $this->newRoomAmount ? 0 : $this->newRoomAmount - $this->oldRoomAmount;

        Transaction::create([
            'branch_id' => auth()->user()->branch_id,
            'guest_id' => $this->guestId,
            'transaction_type_id' => 7,
            'payable_amount' => $transactionPayableAmount,
            'paid_at' => $transactionPayableAmount == 0 ? Carbon::now() : null,
            'room_id' => $newRoom->id,
            'remarks' => 'Guest transferred from ROOM # ' . $this->oldRoomNumber . ' ( ' . $this->oldRoomTypeName . ' ) to ROOM # ' . $newRoom->number . ' ( ' . $newRoom->type->name . ' )',
            'front_desk_name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
        ]);

        if ($this->oldRoomAmount > $this->newRoomAmount && $this->saveAsDeposit == 1) {
            $deposit_transaction = Transaction::create([
                'branch_id' => auth()->user()->branch_id,
                'guest_id' => $this->guestId,
                'transaction_type_id' => 2,
                'payable_amount' =>  $this->oldRoomAmount - $this->newRoomAmount,
                'paid_at' => now(),
                'room_id' => $newRoom->id,
                'front_desk_name' => auth()->user()->name,
                'user_id' => auth()->user()->id,
                'remarks' => 'Extra amount paid from previous room',
            ]);
            Deposit::create([
                'guest_id' => $this->guestId,
                'amount' =>  $this->oldRoomAmount - $this->newRoomAmount,
                'remaining'=> $this->oldRoomAmount - $this->newRoomAmount,
                'remarks' => 'Deposit from transfer room transaction',
                'front_desk_name' => auth()->user()->name,
                'user_id' => auth()->user()->id,
            ]);
        }

        RoomChange::create([
            'guest_id' => $this->guestId,
            'from_room_id' => $this->oldRoomId,
            'to_room_id' => $newRoom->id,
            'reason' => $this->reason,
            'amount' => $this->newRoomAmount,
            'front_desk_name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
        ]);

        $checkInDetail = CheckInDetail::where('guest_id', $this->guestId)->first();
        $checkInDetail->update([
            'room_id' => $newRoom->id,
            'rate_id' => $this->newRoomRate->id,
        ]);


        $oldRoom = Room::find($this->oldRoomId);
        $query = Room::whereHas('floor', function ($q) {
            $q->where('branch_id', auth()->user()->branch_id);
        })
            ->where('room_status_id', 1)
            ->where('priority', 1)
            ->count();
        if ($this->oldRoomStatus == 9) {
                $oldRoom->update([
                    'room_status_id' => 1,
                    'time_to_clean' => null,
                    'priority' => 1,
                    'last_check_out_at' => Carbon::now(),
                ]);
        }else{
            $oldRoom->update([
                'room_status_id' => $this->oldRoomStatus,
                'time_to_clean' => null,
                'priority' => 0,
                'last_check_out_at' => Carbon::now(),
            ]);
        }
        
        $oldRoom->roomTransactionLogs()->latest()->first()->update([
            'check_out_at' => Carbon::now(),
            'guest_transferred' => true,
        ]);

        $newRoom->update([
            'room_status_id' => 2,
        ]);

        $newRoom->roomTransactionLogs()->create([
            'branch_id' => auth()->user()->branch_id,
            'room_number' => $newRoom->number,
            'check_in_detail_id' => $this->guestCheckInDetailId,
            'check_in_at' => Carbon::now(),
            'time_interval' => $newRoom->last_check_out_at ? Carbon::parse($newRoom->last_check_out_at)->diffInMinutes(Carbon::now()) : 0,
        ]);

        DB::commit();

        $this->dispatchBrowserEvent('notify-alert', [
            'type' => 'success',
            'title' => 'Success',
            'text' => 'Room has been transferred',
            'buttonText' => 'Ok',
        ]);

        $this->dispatchBrowserEvent('close-form');

        $this->emit('transactionUpdated');

        $this->newRoomId = null;
        $this->reason = null;
        $this->oldRoomStatus = null;
        $this->newRoomAmount = null;

        $this->authorizationCode = null;
    }
}

<?php

namespace App\Http\Livewire\FrontDesk;

use App\Models\CheckInDetail;
use App\Models\Extension;
use App\Models\Guest;
use App\Models\Room;
use App\Models\RoomChange;
use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Dd;

class GuestTransaction extends Component
{
    use  WithPagination, Actions;

    public $guest = null;

    public $loadTransactions = false;

    public $search = '';

    public $selected_guest = null;

    public $addDamageModal = false;

    public $extendModal = false;

    public $changeRoomModal = false;

    public $rooms = [];

    public $damages = [
        'Remote Control',
        'Door Lock',
        'Light',
        'TV',
        'Outlet',
        'Curtains',
        'Bed Sheets',
        'Pillow',
        'Blanket',
        'Towel',
        'Toilet Paper',
        'Toothbrush',
        'Toothpaste',
    ];

    public $damaged_item;

    public $amount;

    public $room_id;

    public $occured_at;

    public $paid = false;

    public $checked_in_room;

    public $extenstion_id;

    public $extension_amount;

    public $extension_paid = false;

    public $to_room;

    public $reason;

    protected $validationAttributes = [
        'damaged_item' => 'Damaged Item',
        'amount' => 'Amount',
        'room_id' => 'Room',
        'occured_at' => 'Occured At',
        'extenstion_id' => 'Extension',
    ];

    public $extensions = [];

    public function search()
    {
        $this->guest = Guest::where('qr_code', $this->search)
            ->where('is_checked_in', 1)
            ->where('totaly_checked_out', 0)
            ->with([
                'transactions' => [
                    'check_in_detail' => [
                        'room',
                    ],
                ],
                'damages.room',
            ])
            ->first();
        if ($this->guest) {
            $this->loadTransactions = true;
        } else {
            $this->notification()->error(
                $title = 'Guest Not Found',
                $description = 'Guest with this QR Code is not checked in or already checked out'
            );
        }
    }

    public function clear()
    {
        $this->search = '';
        $this->loadTransactions = false;
    }

    public function saveDamageRecord()
    {
        $this->validate([
            'damaged_item' => 'required',
            'amount' => 'required|numeric',
            'room_id' => 'required',
            'occured_at' => 'required',
        ]);
        $this->guest->damages()->create([
            'room_id' => $this->room_id,
            'item' => $this->damaged_item,
            'payable_amount' => $this->amount,
            'occured_at' => $this->occured_at,
            'paid_at' => $this->paid ? now() : null,
        ]);
        $this->addDamageModal = false;
        $this->reset('damaged_item', 'amount', 'room_id', 'occured_at');
        $this->notification()->success(
            $title = 'Success',
            $description = 'Record has been saved successfully'
        );
    }

    public function saveExtend()
    {
        $this->validate([
            'extenstion_id' => 'required',
        ]);
        DB::beginTransaction();
        $extension = Extension::find($this->extenstion_id);
        $this->guest->transactions()->create([
            'branch_id' => auth()->user()->branch_id,
            'transaction_type_id' => 6,
            'payable_amount' => $extension->amount,
            'paid_at' => $this->extension_paid ? now() : null,
        ]);
        $check_in_detail = $this->guest->transactions()->where('transaction_type_id', 1)->first()->check_in_detail;
        $check_in_detail->update([
            'expected_check_out_at' => Carbon::parse($check_in_detail->expected_check_out_at)->addHours($extension->hours),
        ]);
        $check_in_detail->extensions()->attach($extension->id);
        DB::commit();

        $this->extendModal = false;
        $this->notification()->success(
            $title = 'Success',
            $description = 'Room has been extended successfully'
        );
    }

    public function payTransaction($transaction_id)
    {
        $transaction = Transaction::where('id', $transaction_id)->first();
        $transaction->update([
            'paid_at' => now(),
        ]);
        $this->notification()->success(
            $title = 'Success',
            $description = 'Transaction has been paid successfully'
        );
    }

    public function payDamage($damage_id)
    {
        $damage = $this->guest->damages()->where('id', $damage_id)->first();
        $damage->update([
            'paid_at' => now(),
        ]);
        $this->notification()->success(
            $title = 'Success',
            $description = 'Damage has been paid successfully'
        );
    }

    public function showChangeRoomModal()
    {
        $changeRoomCount = RoomChange::where('check_in_detail_id', $this->guest->transactions()->where('transaction_type_id', 1)->first()->check_in_detail->id)->count();
        if ($changeRoomCount == 2) {
            $this->notification()->error(
                $title = 'Error',
                $description = 'You can not change room more than 2 times'
            );
            return;
        }
        $this->changeRoomModal = true;
    }

    public function saveChangeRoom()
    {
        $this->validate([
            'to_room' => 'required',
            'reason' => 'required',
        ]);
        $check_in_detail = $this->guest->transactions()->where('transaction_type_id', 1)->first()->check_in_detail;
        if (Carbon::parse($check_in_detail->check_in_at)->diffInHours(now()) >= 3) {
            $this->notification()->error(
                $title = 'Error',
                $description = 'You can not change room after 3 hours of check in'
            );
            return;
        }
        $fromRoom = $check_in_detail->room;
        $toRoom = Room::where('id', $this->to_room)->first();
        if ($fromRoom->id == $toRoom->id) {
            $this->notification()->error(
                $title = 'Error',
                $description = 'From and To Room cannot be same'
            );

            return;
        }
        $check_in_detail->update([
            'room_id' => $this->to_room,
        ]);
        RoomChange::create([
            'check_in_detail_id' => $check_in_detail->id,
            'from_room_id' => $fromRoom->id,
            'to_room_id' => $this->to_room,
            'reason' => $this->reason,
        ]);
        $fromRoom->update([
            'room_status_id' => 5,
        ]);
        $toRoom->update([
            'room_status_id' => 2,
        ]);
        $this->changeRoomModal = false;
        $this->reset('to_room', 'reason');
        $this->notification()->success(
            $title = 'Success',
            $description = 'Room has been changed successfully'
        );
    }

    public function mount()
    {
        $this->extensions = auth()->user()->branch->extensions;
    }
    public function render()
    {
        return view('livewire.front-desk.guest-transaction', [
            'transactions' => $this->loadTransactions ?
                $this->guest->transactions()
                ->get()
                : [],
            'guest_damages' => $this->loadTransactions ?
                $this->guest->damages()
                ->get()
                : [],
        ]);
    }
}

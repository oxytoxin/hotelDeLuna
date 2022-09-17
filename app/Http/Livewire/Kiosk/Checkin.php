<?php

namespace App\Http\Livewire\Kiosk;

use App\Models\CheckInDetail;
use App\Models\Guest;
use App\Models\Rate;
use App\Models\Room;
use App\Models\Transaction;
use App\Models\Type;
use Carbon\Carbon;
use Livewire\Component;

class Checkin extends Component
{
    public $step = 1;

    public $get_room = [
        'room_id' => '',
        'type_id' => '',
        'rate_id' => '',
    ];

    public $transaction = [];

    public $room_array = 0;

    public $manage_room;

    public $type_key;

    public $room_type;

    public $customer_name;

    public $customer_number;

    public $qr_code;

    public $manageRoomPanel = false;

    public function render()
    {
        return view('livewire.kiosk.checkin', [
            'rooms' => Room::where('room_status_id', 1)->where('type_id', $this->type_key)->whereHas('floor', function ($query) {
                $query->where('branch_id', auth()->user()->branch_id);
            })->with('floor')->get(),
            'roomtypes' => Type::get(),
            'rates' => Rate::where('type_id', 'like', '%'.$this->type_key.'%')->get(),
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'customer_name' => 'required',
            'customer_number' => 'required|numeric|digits:11',
        ]);
    }

    public function selectRoom($room_id)
    {
        $this->get_room['room_id'] = $room_id;
        // dd($this->get_room);
        $this->manageRoomPanel = true;
    }

        public function selectRoomType($type_id)
        {
            // array_push($this->transaction, $this->get_room);
            // $this->transaction[$this->room_array]['type_id'] = $type_id;
            $this->get_room['type_id'] = $type_id;
            $this->room_array++;
            $this->type_key = $type_id;
        }

    public function manageRoom($key)
    {
        $this->manage_room = $this->transaction[$key]['room_id'];
        $this->room_key = $key;
    }

    public function removeRoom($key)
    {
        unset($this->transaction[$key]);
        $this->room_array--;
    }

    public function selectType($type_id)
    {
        $rate = Rate::where('type_id', $type_id)->first();
        // $this->transaction[$this->room_key]['rate_id'] = $rate->id;
        $this->transaction[$this->room_key]['type_id'] = $type_id;
        $this->room_type = Rate::where('type_id', $type_id)->get();
    }

    public function selectRate($rate_id)
    {
        $this->get_room['rate_id'] = $rate_id;
    }

    public function confirmCheckin()
    {
        $this->validate([
            'customer_name' => 'required',
            'customer_number' => 'required|numeric|digits:11',
        ]);
        $transaction = Guest::whereDate('created_at', Carbon::today())->count();
        $transaction += 1;
        $transaction_code = Carbon::today()->format('Ymd').''.$transaction;
        $transaction_code *= 1000;
        $transaction_code += $transaction;

        $guest = Guest::create([
            'branch_id' => auth()->user()->branch_id,
            'qr_code' => $transaction_code,
            'name' => $this->customer_name,
            'contact_number' => $this->customer_number,
        ]);

        $room = Room::where('id', $this->get_room['room_id'])->first();
        $rate = Rate::where('id', $this->get_room['rate_id'])->first();

        $checkinroom = Transaction::create([
            'branch_id' => auth()->user()->branch_id,
            'guest_id' => $guest->id,
            'transaction_type_id' => 1,
            'payable_amount' => $rate->amount,
        ]);
        $checkindeposit = Transaction::create([
            'branch_id' => auth()->user()->branch_id,
            'guest_id' => $guest->id,
            'transaction_type_id' => 2,
            'payable_amount' => 200,
        ]);

        $details = CheckInDetail::create([
            'transaction_id' => $checkinroom->id,
            'room_id' => $this->get_room['room_id'],
            'rate_id' => $this->get_room['rate_id'],
            'static_amount' => $rate->amount,
            'static_hours_stayed' => $rate->staying_hour->number,
        ]);

        $room->update([
            'room_status_id' => 6,
            'time_to_terminate_in_queue' => Carbon::now()->addMinutes(10),
        ]);

        $this->qr_code = $transaction_code;
        $this->step = 4;
    }

    public function confirmRate()
    {
        $this->validate([
            'get_room.rate_id' => 'required',
        ]);
        $this->manageRoomPanel = false;
        $this->step = 3;
    }
}

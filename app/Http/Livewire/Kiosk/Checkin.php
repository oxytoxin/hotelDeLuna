<?php

namespace App\Http\Livewire\Kiosk;

use App\Jobs\TerminateRoomJob;
use App\Models\CheckInDetail;
use App\Models\Guest;
use App\Models\Rate;
use App\Models\Room;
use App\Models\TemporaryRoom;
use App\Models\Transaction;
use App\Models\Type;
use Carbon\Carbon;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Floor;

class Checkin extends Component
{
    use Actions;
    public $step = 1;
    public $increments = '';

    public $get_room = [
        'room_id' => '',
        'type_id' => '',
        'rate_id' => '',
    ];

    public $transaction = [];

    public $room_array = 0;

    public $manage_room;

    public $floor_id = 1;

    public $type_key;

    public $room_type;

    public $customer_name;

    public $customer_number;

    public $qr_code;

    public $manageRoomPanel = false;

    public $temporary = [];

    public function render()
    {

        return view('livewire.kiosk.checkin', [
            'rooms' => Room::where('room_status_id', 1)->where('floor_id', 'like', '%' . $this->floor_id . '%')->where('type_id', $this->type_key)->whereHas('floor', function ($query) {
                $query->where('branch_id', auth()->user()->branch_id);
            })->with('floor')->get(),

            'floors' => Floor::where('branch_id', auth()->user()->branch_id)->get(),
            'roomtypes' => Type::get(),
            'rates' => Rate::where('type_id', 'like', '%' . $this->type_key . '%')->get(),
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'customer_name' => 'required|min:3',
            'customer_number' => 'required|numeric|digits:9',
        ]);
    }

    public function closeManageRoomPanel()
    {
        $this->dialog()->confirm([

            'title'       => 'Room Selection Management',

            'description' => 'Are you sure you want to cancel this transaction?',

            'icon'        => 'question',

            'accept'      => [

                'label'  => 'Yes',

                'method' => 'cancelRoomSelection',

            ],

            'reject' => [

                'label'  => 'No, cancel',

            ],

        ]);
    }

    public function cancelRoomSelection()
    {
        $query =  Room::where('id', $this->get_room['room_id'])->first();
        $query->update([
            'room_status_id' => 1,
        ]);
        $this->manageRoomPanel = false; 
        $this->notification()->success(
            $title = 'Kiosk Check-In',
            $description = 'Cancel Room Successfully.',
        );
    }

    public function selectRoom($room_id)
    {

        // if (TemporaryRoom::where('room_id', $room_id)->where('branch_id', auth()->user()->branch_id)->exists()) {
        //     $this->notification()->error(
        //         $title = 'Kiosk Check-In',
        //         $description = 'The Room is already selected by other user',
        //     );
        // } else {
        //     TemporaryRoom::create([
        //         'room_id' => $room_id,
        //         'branch_id' => auth()->user()->branch_id,
        //         'time_to_terminate' => Carbon::now()->addMinutes(15),
        //     ]);

        //     $this->get_room['room_id'] = $room_id;
        //     $this->manageRoomPanel = true;
        // }

        $query = Room::where('id', $room_id)->first();
        if ($query->room_status_id != 1) {
            $this->notification()->error(
                $title = 'Kiosk Check-In',
                $description = 'The Room is already selected by other user',
            );
        } else {
            $query->update([
                'room_status_id' => 6,
            ]);
            $this->get_room['room_id'] = $room_id;
            $this->manageRoomPanel = true;
        }
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
        // dd('sdsdsdsdsd');   
        $this->validate([
            'customer_name' => 'required|min:3',
            'customer_number' => 'nullable|digits:9',
        ]);
        $transaction = \App\Models\Guest::whereYear('created_at', \Carbon\Carbon::today()->year)->count();
        $transaction += 1;
        $transaction_code = auth()->user()->branch_id . today()->format('y') . str_pad($transaction, 4, '0', STR_PAD_LEFT);



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
        
        $time_to_terminate = 1;
        TerminateRoomJob::dispatch($room->id,$guest->id)->delay(now()->addMinutes($time_to_terminate));
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

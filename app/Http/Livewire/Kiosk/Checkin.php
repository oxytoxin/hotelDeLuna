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
use Livewire\WithPagination;
use App\Models\Deposit;

class Checkin extends Component
{
    use Actions;
    use WithPagination;
    public $step = 1;
    public $increments = '';

    public $get_room = [
        'room_id' => '',
        'type_id' => '',
        'rate_id' => '',
    ];

    public $long_stay = false;
    public $days_stay;
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

    public $confirmModal = false;

    public function render()
    {
        return view('livewire.kiosk.checkin', [
            'rooms' => Room::where('room_status_id', 1)
                ->where('priority', 1)
                ->where('floor_id', 'like', '%' . $this->floor_id . '%')
                ->where('type_id', $this->type_key)
                ->whereHas('floor', function ($query) {
                    $query->where('branch_id', auth()->user()->branch_id);
                })
                ->orderByRaw('LENGTH(number) asc')
                ->with(['floor'])
                ->take(10)
                ->get(),

            'floors' => Floor::where(
                'branch_id',
                auth()->user()->branch_id
            )->get(),
            'roomtypes' => Type::get(),
            'rates' => Rate::where('branch_id', auth()->user()->branch_id)
                ->where('type_id', 'like', '%' . $this->type_key . '%')
                ->where('is_available', 1)
                ->with(['staying_hour', 'type'])
                ->get(),
        ]);
    }

    public function closeManageRoomPanel()
    {
        $this->dialog()->confirm([
            'title' => 'Room Selection Management',

            'description' =>
                'Are you sure you want to cancel this transaction?',

            'icon' => 'question',

            'accept' => [
                'label' => 'Yes',

                'method' => 'cancelRoomSelection',
            ],

            'reject' => [
                'label' => 'No, cancel',
            ],
        ]);
    }

    public function cancelRoomSelection()
    {
        $query = Room::where('id', $this->get_room['room_id'])->first();
        $query->update([
            'room_status_id' => 1,
        ]);
        $this->manageRoomPanel = false;
        $this->notification()->success(
            $title = 'Kiosk Check-In',
            $description = 'Cancel Room Successfully.'
        );
    }

    public function selectRoom($room_id)
    {
        $query = Room::where('id', $room_id)->first();
        if ($query->room_status_id != 1) {
            $this->notification()->error(
                $title = 'Kiosk Check-In',
                $description = 'The Room is already selected by other user'
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
        $query = Room::where('type_id', $type_id)
            ->where('room_status_id', 1)
            ->where('priority', 1)
            ->whereHas('floor', function ($query) {
                $query->where('branch_id', auth()->user()->branch_id);
            })
            ->with(['floor', 'type'])
            ->get();

        if ($query->count() > 0) {
            $this->get_room['type_id'] = $type_id;
            $this->room_array++;
            $this->type_key = $type_id;
            $this->floor_id = $query->first()->floor_id;
        } else {
            $this->dialog()->error(
                $title = 'Sorry',
                $description = 'There is no available room in this type.'
            );
        }
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
        $this->transaction[$this->room_key]['type_id'] = $type_id;
        $this->room_type = Rate::where('type_id', $type_id)->get();
    }

    public function selectRate($rate_id)
    {
        $this->get_room['rate_id'] = $rate_id;
    }

    public function confirmCheckin()
    {
        if ($this->customer_number != null) {
            $this->validate([
                'customer_name' => 'required|min:3',
                'customer_number' => 'required|numeric|digits:9',
            ]);
            $transaction = \App\Models\Guest::whereYear(
                'created_at',
                \Carbon\Carbon::today()->year
            )->count();
            $transaction += 1;
            $transaction_code =
                auth()->user()->branch_id .
                today()->format('y') .
                str_pad($transaction, 4, '0', STR_PAD_LEFT);

            $guest = Guest::create([
                'branch_id' => auth()->user()->branch_id,
                'qr_code' => $transaction_code,
                'name' => $this->customer_name,
                'contact_number' => '09' . $this->customer_number,
            ]);

            $room = Room::where('id', $this->get_room['room_id'])->first();
            $rate = Rate::where('id', $this->get_room['rate_id'])->first();
            $type = Type::where('id', $this->get_room['type_id'])->first();
            if ($this->long_stay == true) {
                $checkinroom = Transaction::create([
                    'branch_id' => auth()->user()->branch_id,
                    'room_id' => $this->get_room['room_id'],
                    'guest_id' => $guest->id,
                    'transaction_type_id' => 1,
                    'payable_amount' => $rate->amount * $this->days_stay,
                    'remarks' =>
                        'Guest checked in : ROOM #' .
                        $room->number .
                        ' (' .
                        $type->name .
                        ') for ' .
                        $rate->staying_hour->number .
                        ' hours',
                ]);
            } else {
                $checkinroom = Transaction::create([
                    'branch_id' => auth()->user()->branch_id,
                    'room_id' => $this->get_room['room_id'],
                    'guest_id' => $guest->id,
                    'transaction_type_id' => 1,
                    'payable_amount' => $rate->amount,
                    'remarks' =>
                        'Guest checked in : ROOM #' .
                        $room->number .
                        ' (' .
                        $type->name .
                        ') for ' .
                        $rate->staying_hour->number .
                        ' hours',
                ]);
            }

            $checkindeposit = Transaction::create([
                'branch_id' => auth()->user()->branch_id,
                'room_id' => $this->get_room['room_id'],
                'guest_id' => $guest->id,
                'transaction_type_id' => 2,
                'payable_amount' => 200,
                'remarks' => 'Guest deposit: Room Key & TV Remote',
            ]);
            Deposit::create([
                'guest_id' => $guest->id,
                'amount' => 200,
                'remaining' => 200,
                'remarks' => 'TV Remote and Room key',
            ]);

            if ($this->long_stay == true) {
                $details = CheckInDetail::create([
                    'guest_id' => $guest->id,
                    'room_id' => $this->get_room['room_id'],
                    'rate_id' => $this->get_room['rate_id'],
                    'static_amount' => $rate->amount,
                    'static_hours_stayed' =>
                        $rate->staying_hour->number * $this->days_stay,
                ]);
            } else {
                $details = CheckInDetail::create([
                    'guest_id' => $guest->id,
                    'room_id' => $this->get_room['room_id'],
                    'rate_id' => $this->get_room['rate_id'],
                    'static_amount' => $rate->amount,
                    'static_hours_stayed' => $rate->staying_hour->number,
                ]);
            }
            $room->update([
                'room_status_id' => 6,
                'time_to_terminate_in_queue' => Carbon::now()->addMinutes(10),
            ]);

            $this->qr_code = $transaction_code;
            $this->step = 4;

            $time_to_terminate = 2;
            TerminateRoomJob::dispatch($room->id, $guest->id)->delay(
                now()->addHours($time_to_terminate)
            );
        } else {
            $this->validate([
                'customer_name' => 'required|min:3',
            ]);
            $transaction = \App\Models\Guest::whereYear(
                'created_at',
                \Carbon\Carbon::today()->year
            )->count();
            $transaction += 1;
            $transaction_code =
                auth()->user()->branch_id .
                today()->format('y') .
                str_pad($transaction, 4, '0', STR_PAD_LEFT);

            $guest = Guest::create([
                'branch_id' => auth()->user()->branch_id,
                'qr_code' => $transaction_code,
                'name' => $this->customer_name,
            ]);

            $room = Room::where('id', $this->get_room['room_id'])->first();
            $rate = Rate::where('id', $this->get_room['rate_id'])->first();
            $type = Type::where('id', $this->get_room['type_id'])->first();

            if ($this->long_stay == true) {
                $checkinroom = Transaction::create([
                    'branch_id' => auth()->user()->branch_id,
                    'room_id' => $this->get_room['room_id'],
                    'guest_id' => $guest->id,
                    'transaction_type_id' => 1,
                    'payable_amount' => $rate->amount * $this->days_stay,
                    'remarks' =>
                        'Guest checked in : ROOM #' .
                        $room->number .
                        ' (' .
                        $type->name .
                        ') for ' .
                        $rate->staying_hour->number * $this->days_stay .
                        ' hours',
                ]);
            } else {
                $checkinroom = Transaction::create([
                    'branch_id' => auth()->user()->branch_id,
                    'room_id' => $this->get_room['room_id'],
                    'guest_id' => $guest->id,
                    'transaction_type_id' => 1,
                    'payable_amount' => $rate->amount,
                    'remarks' =>
                        'Guest checked in : ROOM #' .
                        $room->number .
                        ' (' .
                        $type->name .
                        ') for ' .
                       $rate->staying_hour->number.
                        ' hours',
                ]);
            }
            $checkindeposit = Transaction::create([
                'branch_id' => auth()->user()->branch_id,
                'room_id' => $this->get_room['room_id'],
                'guest_id' => $guest->id,
                'transaction_type_id' => 2,
                'payable_amount' => 200,
                'remarks' => 'Guest deposit: Room Key & TV Remote',
            ]);
            Deposit::create([
                'guest_id' => $guest->id,
                'amount' => 200,
                'remaining' => 200,
                'remarks' => 'TV Remote and Room key',
            ]);

            if ($this->long_stay == true) {
                $details = CheckInDetail::create([
                    'guest_id' => $guest->id,
                    'room_id' => $this->get_room['room_id'],
                    'rate_id' => $this->get_room['rate_id'],
                    'static_amount' => $rate->amount,
                    'static_hours_stayed' =>
                        $rate->staying_hour->number * $this->days_stay,
                ]);
            } else {
                $details = CheckInDetail::create([
                    'guest_id' => $guest->id,
                    'room_id' => $this->get_room['room_id'],
                    'rate_id' => $this->get_room['rate_id'],
                    'static_amount' => $rate->amount,
                    'static_hours_stayed' => $rate->staying_hour->number,
                ]);
            }

            $room->update([
                'room_status_id' => 6,
                'time_to_terminate_in_queue' => Carbon::now()->addMinutes(10),
            ]);

            $this->qr_code = $transaction_code;
            $this->step = 4;

            $time_to_terminate = 2;
            TerminateRoomJob::dispatch($room->id, $guest->id)->delay(
                now()->addHours($time_to_terminate)
            );
        }
    }

    public function confirmRate($id)
    {
        if ($this->long_stay == false) {
            $this->validate([
                'get_room.rate_id' => 'required',
            ]);
            $this->manageRoomPanel = false;
            $this->step = 3;
        } else {
            $this->validate([
                'days_stay' => 'required|numeric|min:1|max:31',
            ]);
            $this->get_room['rate_id'] = $id;
            $this->manageRoomPanel = false;
            $this->step = 3;
        }

        // dd($this->get_room);
    }

    public function cancelTransaction()
    {
        // dd($this->get_room);
        if ($this->get_room['room_id'] == null) {
            redirect()->route('kiosk.transaction');
        } else {
            // $query = Room::where('id', $this->get_room['room_id'])->first();
            $this->confirmModal = true;
        }
    }

    public function confirmCancelTransaction()
    {
        $query = Room::where('id', $this->get_room['room_id'])->first();
        $query->update([
            'room_status_id' => 1,
            'time_to_terminate_in_queue' => null,
        ]);
        $this->confirmModal = false;
        redirect()->route('kiosk.transaction');
    }

    public function previousTransaction()
    {
        if ($this->get_room['room_id'] == null) {
            $this->step = $this->step - 1;
        } else {
            $this->dialog()->confirm([
                'title' => 'Go to previous Transaction',
                'description' =>
                    'Are you sure you want to go to previous transaction?',
                'icon' => 'question',
                'accept' => [
                    'label' => 'Yes',
                    'method' => 'confirmPreviousTransaction',
                ],
                'reject' => [
                    'label' => 'No, cancel',
                ],
            ]);
        }
    }

    public function confirmPreviousTransaction()
    {
        $query = Room::where('id', $this->get_room['room_id'])->first();
        $query->update([
            'room_status_id' => 1,
            'time_to_terminate_in_queue' => null,
        ]);
        $this->get_room['rate_id'] = null;
        $this->step = $this->step - 1;
        $this->customer_name = '';
        $this->customer_number = '';
    }

    // public function doneSelectType()
    // {
    //     $query = Room::where('room_status_id', 1)->get();
    //     if (count($query) < 10) {
    //         $take = 10 - count($query);
    //         $rooms = Room::where('room_status_id', 9)
    //             ->take($take)
    //             ->get();
    //         foreach ($rooms as $room) {
    //             $room->update([
    //                 'room_status_id' => 1,
    //             ]);
    //         }
    //         $this->step = 2;
    //     } else {
    //         $this->step = 2;
    //     }
    // }
}

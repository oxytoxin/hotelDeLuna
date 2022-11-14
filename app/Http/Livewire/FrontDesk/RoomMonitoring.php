<?php

namespace App\Http\Livewire\FrontDesk;

use App\Models\Room;
use App\Models\RoomStatus;
use Livewire\Component;
use Livewire\WithPagination;

class RoomMonitoring extends Component
{
    use WithPagination;

    public $search = '';

    public $status_filter = '';

    public $statuses = [];


    public function mount()
    {
        $this->statuses = RoomStatus::get();
    }

    public function getHeadersProperty()
    {
        if ($this->status_filter == 2) {
           return  ['Room Number', 'Status', 'Alert For Checkout'];
        }elseif ($this->status_filter == 7) {
            return   ['Room Number', 'Status', 'Time To Clean'];
        }elseif($this->status_filter == ""){
           return ['Room Number', 'Status', 'Alert For Checkout', 'Time To Clean'];
        }else{
            return ['Room Number', 'Status'];
        }
    }

    public function render()
    {

        return view('livewire.front-desk.room-monitoring', [
            'rooms' => Room::query()
                ->when($this->status_filter != '', function ($query) {
                    $query->where('room_status_id', $this->status_filter);
                })
                ->when($this->search != '', function ($query) {
                    return $query->where('number', 'like', '%' . $this->search . '%');
                })
                ->whereHas('floor', function ($query) {
                    return $query->where('branch_id', auth()->user()->branch_id);
                })
                ->with([
                    'floor',
                    'room_status',
                    'check_in_details' => function ($query) {
                        return $query->where('check_out_at', null)->when($this->status_filter == 2, function ($query) {
                            return $query->orderBy('expected_check_out_at', 'asc');
                        });
                    },
                ])
                ->paginate(20),
            'headers' => $this->headers,
        ]);
    }
}

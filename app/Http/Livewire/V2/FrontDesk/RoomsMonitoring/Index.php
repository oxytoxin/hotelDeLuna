<?php

namespace App\Http\Livewire\V2\FrontDesk\RoomsMonitoring;

use App\Models\Room;
use Livewire\Component;
use App\Traits\WithCaching;

class Index extends Component
{
    use WithCaching;

    public function getRoomsToCheckOutProperty()
    {
        return $this->cache(function () {
            return Room::where('room_status_id',2)->whereHas('floor', function ($query) {
                $query->where('branch_id', auth()->user()->branch->id);
            })->with(['checkInDetails'=>function($query){
                    return $query->where('check_in_at','!=',null)
                        ->where('check_out_at', null)->first();
            },'floor'])->get();
        },'rooms');
    }

    public function getUncleanedAndCleaningRoomsProperty()
    {
        return $this->cache(function () {
            return Room::whereIn('room_status_id',[7,8])->whereHas('floor', function ($query) {
                $query->where('branch_id', auth()->user()->branch->id);
            })->with(['floor'])->get();
        },'uncleaned_and_cleaning_rooms');
    }

    public function render()
    {
        return view('livewire.v2.front-desk.rooms-monitoring.index',[
            'roomsToCheckOut' => $this->roomsToCheckOut,
            'uncleanedAndCleaningRooms' => $this->uncleanedAndCleaningRooms,
        ]);
    }
}

<?php

namespace App\Http\Livewire\BackOffice;

use Livewire\Component;
use App\Models\CheckInDetail;

class TimeInterval extends Component
{
    public function render()
    {
        return view('livewire.back-office.time-interval', [
            'checkInDetails' => CheckInDetail::get()->groupBy('room_id'),
        ]);
    }
}

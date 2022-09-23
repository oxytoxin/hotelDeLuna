<?php

namespace App\Jobs;

use App\Models\CheckInDetail;
use App\Models\Guest;
use App\Models\Room;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TerminateRoomJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $room_id;
    public $guest_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($room_id, $guest_id)
    {
        $this->room_id = $room_id;
        $this->guest_id = $guest_id;
    }
 
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $room = Room::where('id',$this->room_id)->first();
        if($room->room_status_id == 6){
            $room->update([
                'room_status_id' => 1,
            ]);
        }
        $transaction = Transaction::where('guest_id', $this->guest_id)
                                            ->where('transaction_type_id', 1)
                                            ->first();
        CheckInDetail::where('transaction_id', $transaction->id)->delete();
        Transaction::where('guest_id', $this->guest_id)->delete();
        Guest::where('id', $this->guest_id)->delete();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Guest;
use App\Models\Deposit;
use App\Models\Rate;
use Illuminate\Database\Seeder;

class DummyCheckInSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 20; $i++) {
            $guest = Guest::create([
                'branch_id' => 1,
                'qr_code' => 'qr_code_' . $i,
                'name' => fake()->name,
                'contact_number' => fake()->phoneNumber,
                'is_out_of_the_building' => false,
            ]);

            $rate = Rate::inRandomOrder()->first();


            // ------
           $checkInDetail = $guest->checkInDetail()->create([
                'room_id' => $i,
                'rate_id' => $rate->id,
                'static_amount' =>  $rate->amount,
                'static_hours_stayed' => '6',
            ]);
            
            $guest->transactions()->create([
                'branch_id' => 1,
                'transaction_type_id' => 1,
                'payable_amount' => $rate->amount,
                'room_id' => $i,
                'remarks' => 'Guest Checked In : ROOM #' . $i,
            ]);

            // --------

           $guest->transactions()->create([
                'branch_id' => 1,
                'transaction_type_id' => 2,
                'payable_amount' => '200',
                'room_id' => $i,
                'remarks' => 'Guest Deposited  for Room key and TV remote',
            ]);
            // select 1 random rates
            
            Deposit::create([
                'guest_id' => $guest->id,
                'amount' => 200,
                'remarks' => 'Deposit for remote and key',
            ]);
            $selected_room = Room::find($checkInDetail->room_id);
            $selected_room->update([
                'room_status_id' => 6,
                'priority' => false,
            ]);
        }
    }
}

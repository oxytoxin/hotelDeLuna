<?php

namespace Database\Seeders;

use App\Models\Floor;
use App\Models\Room;
use Illuminate\Database\Seeder;

class FloorAndRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $room_number = 1;
        for ($i = 1; $i <= 5; $i++) {
            $floor = Floor::create([
                'branch_id' => 1,
                'number' => $i,
            ]);
            for ($j = 1; $j <= 10; $j++) {
                $types = ['1', '2', '3'];
                $type = $types[array_rand($types)];
                $room = Room::create([
                    'number' => $room_number++,
                    'floor_id' => $floor->id,
                    'type_id' => $type,
                    'room_status_id' => 1,
                ]);
            }
        }
    }
}

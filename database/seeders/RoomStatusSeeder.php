<?php

namespace Database\Seeders;

use App\Models\RoomStatus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         RoomStatus::create([
            'name' => 'Available', //1
        ]);
        RoomStatus::create([
            'name' => 'Occupied',   //2
        ]);
        RoomStatus::create([
            'name' => 'Reserved',  //3
        ]);
        RoomStatus::create([
            'name' => 'Maintenance',    //4
        ]);
        RoomStatus::create([
            'name' => 'Unavailable',    //5
        ]);
        RoomStatus::create([
            'name' => 'Selected In Kiosk',  //6
        ]);
        RoomStatus::create([
            'name' => 'Uncleaned',  //7
        ]);
        RoomStatus::create([
            'name' => 'Cleaning',  //8
        ]);
    }
}

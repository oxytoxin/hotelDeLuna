<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cleaning;

class OverdueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cleaning::create([
            'room_id' => 1,
            'room_boy_id' => 1,
            'delayed' => 1,
        ]);
        Cleaning::create([
            'room_id' => 2,
            'room_boy_id' => 1,
            'delayed' => 1,
        ]);
    }
}

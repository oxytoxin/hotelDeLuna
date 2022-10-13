<?php

namespace Database\Seeders;

use App\Models\StayingHour;
use App\Models\Type;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'branch_id' => 1,
            'name' => 'Single Size Bed',
        ]);
        Type::create([
            'branch_id' => 1,
            'name' => 'Double Size Bed',
        ]);
        Type::create([
            'branch_id' => 1,
            'name' => 'Twin Single Size Bed',
        ]);
    }
}

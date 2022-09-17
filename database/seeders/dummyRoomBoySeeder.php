<?php

namespace Database\Seeders;

use App\Models\RoomBoy;
use App\Models\User;
use Illuminate\Database\Seeder;

class dummyRoomBoySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 99; $i++) {
            $user = User::create([
                'branch_id' => 1,
                'role_id' => 5,
                'name' => fake()->name,
                'email' => fake()->email,
                'password' => bcrypt('password'),
            ]);
            RoomBoy::create([
                'user_id' => $user->id,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BranchSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(AccountSeeder::class);
        $this->call(RoomStatusSeeder::class);
        $this->call(FloorAndRoomSeeder::class);
        $this->call(TransactionTypeSeeder::class);
        $this->call(RoomTypeSeeder::class);
        $this->call(RateSeeder::class);
        // $this->call(DummyCheckInSeeder::class);
    }
}

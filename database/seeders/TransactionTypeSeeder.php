<?php

namespace Database\Seeders;

use App\Models\TransactionType;
use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransactionType::create([
            'name' => 'Check In', //1
        ]);
        TransactionType::create([
            'name' => 'Deposit',   //2
        ]);
        TransactionType::create([
            'name' => 'Kitchen Order',  //3
        ]);
        TransactionType::create([
            'name' => 'Damage Charge', //4
        ]);
        TransactionType::create([
            'name' => 'Cashout', //5
        ]);
        TransactionType::create([
            'name' => 'Extend', //6
        ]);

        TransactionType::create([
            'name' => 'Transfer Room', //7
        ]);

        TransactionType::create([
            'name' => 'Amenities', //8
        ]);
        
    }
}

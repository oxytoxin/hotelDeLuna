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
            'name' => 'Check In',
        ]);
        TransactionType::create([
            'name' => 'Deposit',
        ]);
        TransactionType::create([
            'name' => 'Kitchen Order',
        ]);
        TransactionType::create([
            'name' => 'Hour Extension',
        ]);
        TransactionType::create([
            'name' => 'Cashout',
        ]);
        TransactionType::create([
            'name' => 'Extend',
        ]);
    }
}

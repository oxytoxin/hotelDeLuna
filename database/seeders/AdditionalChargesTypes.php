<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdditionalChargesTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Damage',
            'Request',
        ];

        foreach ($types as $type) {
            \App\Models\AdditionalChargeType::create([
                'name' => $type,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::create([
            'name' => 'ALMA RESIDENCES GENSAN',
            'address' => 'Brgy. 1, Gensan, South Cotabato',
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Admin', //1
        ]);
        Role::create([
            'name' => 'Front Desk', //2
        ]);
        Role::create([
            'name' => 'Kiosk', //3
        ]);
        Role::create([
            'name' => 'Kitchen', //4
        ]);
        Role::create([
            'name' => 'Bell Boy',  //5
        ]);
        Role::create([
            'name' => 'House Keeping', //6
        ]);
        Role::create([
            'name' => 'Super Admin', //7
        ]);
    }
}

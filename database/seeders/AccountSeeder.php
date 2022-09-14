<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'branch_id' => 1,
            'role_id'=>1,
            'name' => 'Admin',
            'email'=>'admin@gmail.com',
            'password'=>bcrypt('password'),
        ]);
        User::create([
            'branch_id' => 1,
            'role_id'=>2,
            'name' => 'Front Desk',
            'email'=>'frontdesk@gmail.com',
            'password'=>bcrypt('password'),
        ]);
        User::create([
            'branch_id' => 1,
            'role_id'=>3,
            'name' => 'Kiosk',
            'email'=>'kiosk@gmail.com',
            'password'=>bcrypt('password'),
        ]);
        User::create([
            'branch_id' => 1,
            'role_id'=>4,
            'name' => 'Kitchen',
            'email'=>'kitchen@gmail.com',
            'password'=>bcrypt('password'),
        ]);
        User::create([
            'branch_id' => 1,
            'role_id'=>6,
            'name'=>"House Keeping",
            'email'=>'housekeeping@gmail.com',
            'password'=>bcrypt('password'),
        ]);
        User::create([
            'role_id'=>7,
            'name' => 'Super - Admin',
            'email'=>'superadmin@gmail.com',
            'password'=>bcrypt('password'),
        ]);
    }
}

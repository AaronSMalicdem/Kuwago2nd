<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles = [
            [
                'name' => 'admin',
            ],
            [
                'name' => 'operation',
            ],
            [
                'name' => 'waiter',
            ],
        ];

        Role::insert($roles);

        // User::create([
        //     'employee_no' => '0000-0001',
        //     'first_name' => 'Aaron',
        //     'middle_name' => 'Suniga',
        //     'last_name' => 'Malicdem',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('admin'),
        //     'passcode' => mt_rand(100000, 999999),
        //     'role_id' => 1,
        // ]);
        User::create([
            'employee_no' => '0000-0002',
            'first_name' => 'Dennis',
            'middle_name' => 'Mimura',
            'last_name' => 'Rodriguez',
            'email' => 'operation@gmail.com',
            'password' => Hash::make('operation'),
            'passcode' => mt_rand(100000, 999999),
            'role_id' => 2,
        ]);
        User::create([
            'employee_no' => '0000-0003',
            'first_name' => 'Jen',
            'middle_name' => 'Panget',
            'last_name' => 'Gamboa',
            'email' => 'waiter@gmail.com',
            'password' => Hash::make('waiter'),
            'passcode' => mt_rand(100000, 999999),
            'role_id' => 3,
        ]);
    }
}

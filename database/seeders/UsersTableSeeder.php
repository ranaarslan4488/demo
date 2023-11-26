<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@google.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);


        // Example client user
        User::create([
            'name' => 'Client User',
            'email' => 'client@google.com',
            'password' => Hash::make('12345678'),
            'role' => 'client',
        ]);

        // Example doctor user
        User::create([
            'name' => 'Doctor User',
            'email' => 'doctor@google.com',
            'password' => Hash::make('12345678'),
            'role' => 'doctor',
        ]);
    }
}

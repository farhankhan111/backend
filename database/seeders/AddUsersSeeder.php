<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AddUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::create([
            'name' => 'user',
            'email' => 'user',
            'password' => \Hash::make(1234),
             'user_type' => 'user'
        ]);

        User::create([
            'name' => 'admin',
            'email' => 'admin',
            'password' => \Hash::make(1234),
            'user_type' => 'admin'
        ]);
    }
}

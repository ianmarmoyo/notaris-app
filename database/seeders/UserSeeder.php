<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Septian Aditama',
            'email' => 'ian@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Muh Suaris',
            'email' => 'aris@gmail.com',
            'password' => Hash::make('123456'),
        ]);
    }
}

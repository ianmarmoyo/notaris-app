<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $findWebMaster = Admin::where('email', 'development@anta.com')->first();
        if (!$findWebMaster) {
            $findWebMaster = Admin::create([
                'name' => 'Web Master',
                'email' => 'development@anta.com',
                'password' => Hash::make('123456'),
            ]);
        }
        $findWebMaster->assignRole('superadmin');

        $admin = Admin::create([
            'name' => 'Administator',
            'email' => 'administator@anta.com',
            'password' => Hash::make('123456'),
        ]);
        $admin->assignRole('admin');
    }
}

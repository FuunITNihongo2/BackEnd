<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        User::insert([
            'fullname' => 'Super Admin',
            'nickname' => 'Admin',
            'phone_number' => '0123456789',
            'email' => 'admin@itnihongo.com',
            'role_id' => User::ROLE_ADMIN,
            'password' => Hash::make(123456789),
            'email_verified_at' => now(),
            'remember_token' => '1234567890',
        ]);
        User::factory()
        ->count(50)
        ->create([
            'role_id' => User::ROLE_MANAGER,
        ]);
        }
}

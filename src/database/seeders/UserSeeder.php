<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

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
        $link = Storage::disk('s3')->put('images/avatars/1.png', file_get_contents(storage_path('app\public\image\default.png')));
        $link = Storage::disk('s3')->url($link);
        $admin = User::find(1);
        Image::insert([
            'name' => $admin->fullname.'_avatar',  
            'link' => 'https://itnihongo2.s3.ap-southeast-1.amazonaws.com/images/avatars/1.png',
            'imageable_id' => $admin->id,
            'imageable_type' => 'App\Models\User'
        ]);
        // User::factory()
        // ->count(50)
        // ->create([
        //     'role_id' => User::ROLE_MANAGER,
        // ])
        // ->each(function($user){
        //     $link = Storage::disk('s3')->put('images/avatars/'.$user->id.'.png', file_get_contents(storage_path('app\public\image\default.png')));
        //     $link = Storage::disk('s3')->url($link);
        //     Image::insert([
        //         'name' => $user->fullname.'_avatar',  
        //         'link' => 'https://itnihongo2.s3.ap-southeast-1.amazonaws.com/images/avatars/'.$user->id.'.png',
        //         'imageable_id' => $user->id,
        //         'imageable_type' => 'App\Models\User'
        //     ]);
        // });
        }
}

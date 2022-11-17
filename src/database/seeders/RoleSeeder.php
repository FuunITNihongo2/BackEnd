<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::insert([
            'name' => "Manager"
        ]);
        \App\Models\Role::insert([
            'name' => "Admin"
        ]);
    
        $admin = \App\Models\Role::find(2);
        $admin->permissions()->attach([
            //user
            1, 2, 4, 5,
            //booth
            6, 7, 8, 9, 10,
            //menu
            11, 12, 14,
            //item
            16, 17, 19,
            //image
            21, 22, 24,
        ]);

        $manager = \App\Models\Role::find(1);
        $manager->permissions()->attach([
            //booth
            6, 7, 
            //menu
            11, 12, 13, 14, 15,
            //item
            16, 17, 18, 19, 20,
            //image
            21, 22, 23, 24, 25,
        ]);
    }
}

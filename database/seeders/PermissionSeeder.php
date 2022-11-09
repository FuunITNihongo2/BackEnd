<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //user permission
        //1
        \App\Models\Permission::insert([
            'permission' => "view users"
        ]);
        //2
        \App\Models\Permission::insert([
            'permission' => "view user"
        ]);
        //3
        \App\Models\Permission::insert([
            'permission' => "update user"
        ]);
        //4
        \App\Models\Permission::insert([
            'permission' => "delete user"
        ]);
        //5
        \App\Models\Permission::insert([
            'permission' => "add user"
        ]);
        //booths permission
        //6
        \App\Models\Permission::insert([
            'permission' => "view booths"
        ]);
        //7
        \App\Models\Permission::insert([
            'permission' => "view booth"
        ]);
        //8
        \App\Models\Permission::insert([
            'permission' => "update booth"
        ]);
        //9
        \App\Models\Permission::insert([
            'permission' => "delete booth"
        ]);
        //10
        \App\Models\Permission::insert([
            'permission' => "add booth"
        ]);
        //menus permission
        //11
        \App\Models\Permission::insert([
            'permission' => "view menus"
        ]);
        //12
        \App\Models\Permission::insert([
            'permission' => "view menu"
        ]);
        //13
        \App\Models\Permission::insert([
            'permission' => "update menu"
        ]);
        //14
        \App\Models\Permission::insert([
            'permission' => "delete menu"
        ]);
        //15
        \App\Models\Permission::insert([
            'permission' => "add menu"
        ]);
        //items permission
        //16
        \App\Models\Permission::insert([
            'permission' => "view items"
        ]);
        //17
        \App\Models\Permission::insert([
            'permission' => "view item"
        ]);
        //18
        \App\Models\Permission::insert([
            'permission' => "update item"
        ]);
        //19
        \App\Models\Permission::insert([
            'permission' => "delete item"
        ]);
        //20
        \App\Models\Permission::insert([
            'permission' => "add item"
        ]);
        //images permission
        //21
        \App\Models\Permission::insert([
            'permission' => "view images"
        ]);
        //22
        \App\Models\Permission::insert([
            'permission' => "view image"
        ]);
        //23
        \App\Models\Permission::insert([
            'permission' => "update image"
        ]);
        //24
        \App\Models\Permission::insert([
            'permission' => "delete image"
        ]);
        //25
        \App\Models\Permission::insert([
            'permission' => "add image"
        ]);
    }
}

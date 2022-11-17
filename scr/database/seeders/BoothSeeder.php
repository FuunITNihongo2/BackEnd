<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Booth;
use App\Models\Image;
use App\Models\Item;
use App\Models\Menu;

class BoothSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $user)
        {
            Booth::factory(8)->create()->each(function($booth) use ($user)
            {
                Image::factory(1)->create([
                    'name' => $booth->name,
                    'imageable_id' => $booth->id,
                    'imageable_type' => 'App\Models\Booth'
                ]);
                $user->booth()->save($booth);
                $faker = \Faker\Factory::create();
                $menu = Menu::create([
                    'name' => $faker->name,
                    'booth_id' => $booth->id,
                ]);
                Image::factory(1)->create([
                    'name' => $menu->name,
                    'imageable_id' => $menu->id,
                    'imageable_type' => 'App\Models\Menu'
                ]);
    
                Item::factory(8)->create()->each(function($item) use ($menu)
                {
                    $item->update(['menu_id' => $menu->id]);
                    Image::factory(1)->create([
                        'name' => $item->name,
                        'imageable_id' => $item->id,
                        'imageable_type' => 'App\Models\Item'
                    ]);
                });
            });

        }
    }
}

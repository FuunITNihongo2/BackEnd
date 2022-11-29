<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Storage;
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
            Booth::factory(1)->create()->each(function($booth) use ($user)
            {
                $image = ['app\public\image\83930056_p0_master1200.jpg',
                          'app\public\image\86302720_p0_master1200.jpg',
                          'app\public\image\86302720_p1_master1200.jpg',
                          'app\public\image\86503663_p0_master1200.jpg',
                          'app\public\image\86629094_p0_master1200.jpg',
                          'app\public\image\86686458_p0_master1200.jpg',
                          'app\public\image\86820769_p0_master1200.jpg',
                          'app\public\image\86914140_p0_master1200.jpg',
                          'app\public\image\87089452_p0_master1200.jpg',
                          'app\public\image\88020080_p0_master1200.jpg',
                          'app\public\image\88028348_p0_master1200.jpg'];
                $link = Storage::disk('s3')->put('images/booths/'.$booth->id.'.jpg', file_get_contents(storage_path($image[rand(0,count($image)-1)])));
                $link = Storage::disk('s3')->url($link);
                Image::insert([
                    'name' => $booth->name,  
                    'link' => 'https://itnihongo2.s3.ap-southeast-1.amazonaws.com/images/booths/'.$booth->id.'.jpg',
                    'imageable_id' => $booth->id,
                    'imageable_type' => 'App\Models\Booth'
                ]);
                $user->booth()->save($booth);
                $faker = \Faker\Factory::create();
                $menu = Menu::create([
                    'name' => $faker->name,
                    'booth_id' => $booth->id,
                ]);
                $link = Storage::disk('s3')->put('images/menus/'.$menu->id.'.jpg', file_get_contents(storage_path($image[rand(0,count($image)-1)])));
                $link = Storage::disk('s3')->url($link);
                Image::insert([
                    'name' => $menu->name,  
                    'link' => 'https://itnihongo2.s3.ap-southeast-1.amazonaws.com/images/menus/'.$menu->id.'.jpg',
                    'imageable_id' => $booth->id,
                    'imageable_type' => 'App\Models\Menus'
                ]);
    
                Item::factory(10)->create()->each(function($item) use ($menu)
                {
                    $image = ['app\public\image\83930056_p0_master1200.jpg',
                              'app\public\image\86302720_p0_master1200.jpg',
                              'app\public\image\86302720_p1_master1200.jpg',
                              'app\public\image\86503663_p0_master1200.jpg',
                              'app\public\image\86629094_p0_master1200.jpg',
                              'app\public\image\86686458_p0_master1200.jpg',
                              'app\public\image\86820769_p0_master1200.jpg',
                              'app\public\image\86914140_p0_master1200.jpg',
                              'app\public\image\87089452_p0_master1200.jpg',
                              'app\public\image\88020080_p0_master1200.jpg',
                              'app\public\image\88028348_p0_master1200.jpg'];
                    $item->update(['menu_id' => $menu->id]);
                    $link = Storage::disk('s3')->put('images/items/'.$item->id.'.jpg', file_get_contents(storage_path($image[rand(0,count($image)-1)])));
                    $link = Storage::disk('s3')->url($link);
                    Image::insert([
                        'name' => $item->name,  
                        'link' => 'https://itnihongo2.s3.ap-southeast-1.amazonaws.com/images/items/'.$item->id.'.jpg',
                        'imageable_id' => $item->id,
                        'imageable_type' => 'App\Models\Item'
                    ]);
                });
            });

        }
    }
}

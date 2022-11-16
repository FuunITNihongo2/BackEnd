<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {        
        // $fakerFileName = $this->faker->image(
        //     storage_path("app/public/image"),
        //     800,
        //     600
        // );

        // return [
        //     'path' => "image/" . basename($fakerFileName),
        // ];
        return [
            'link' => fake()->imageUrl(),
        ];
    }
}

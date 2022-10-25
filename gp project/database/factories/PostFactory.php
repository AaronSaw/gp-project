<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\support\Str;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title=$this->faker->sentence;
        $description=$this->faker->realText(2000);
        return [

            "title"=>$title,
            "slug"=>Str::slug($title),
            "description"=>$description,
            "excerpt"=>Str::words($description,30, '...'),
            "user_id"=>User::inRandomOrder()->first()->id,
            "category_id"=>Category::inRandomOrder()->first()->id,
        ];
    }
}

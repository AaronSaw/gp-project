<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory(10)->create();
         \App\Models\User::factory()->create([
            "name"=>"saw kyaw myint",
            'email'=>"sawkyaw@gmail.com",
            "password"=>Hash::make("sawkyaw777236")
         ]);

        User::factory(10)->create();
        $categories=["IT News","Sport","Food & Drinks","Travel"];
        foreach($categories as $category){
            Category::create([
            "title"=>$category,
            "slug"=>Str::slug($category),
            "user_id"=>User::inRandomOrder()->first()->id
            ]);
        }

        //Post::factory(250)->create();
    }
}

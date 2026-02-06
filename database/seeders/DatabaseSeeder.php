<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
        MoodSeeder::class,
        TagSeeder::class,
        FoodSeeder::class,
        FoodTagSeeder::class,
        MoodTagMapSeeder::class, // remove this line if you didn't create mood_tag_map table
        RestaurantSeeder::class,
        RecipeSeeder::class,
        ]);
    }
}

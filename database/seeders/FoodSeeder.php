<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $foods = [
            [
                'name' => 'Nasi Lemak',
                'type' => 'meal',
                'description' => 'Classic Malaysian coconut rice with sambal and sides.',
                'image_url' => 'images/foods/nasi-lemak.jpg',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Chicken Soup',
                'type' => 'meal',
                'description' => 'Warm comfort soup that is easy to digest.',
                'image_url' => 'images/foods/chicken-soup.jpg',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Chocolate Cake',
                'type' => 'snack',
                'description' => 'Sweet treat for celebration or comfort.',
                'image_url' => 'images/foods/chocolate-cake.jpg',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Fruit Salad',
                'type' => 'snack',
                'description' => 'Light and refreshing mixed fruits.',
                'image_url' => 'images/foods/fruit-salad.jpg',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Iced Lemon Tea',
                'type' => 'drink',
                'description' => 'Refreshing drink for a light mood.',
                'image_url' => 'images/foods/iced-lemon-tea.jpg',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Fried Rice',
                'type' => 'meal',
                'description' => 'Quick meal option for low-energy moments.',
                'image_url' => 'images/foods/fried-rice.jpg',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Oatmeal',
                'type' => 'meal',
                'description' => 'Simple, warm, and calming breakfast.',
                'image_url' => 'images/foods/oatmeal.jpg',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Pasta Aglio Olio',
                'type' => 'meal',
                'description' => 'Simple and quick pasta option.',
                'image_url' => 'images/foods/pasta-aglio-olio.jpg',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('foods')->upsert(
            $foods,
            ['name'],
            ['type', 'description', 'image_url', 'is_active', 'updated_at']
        );
    }
}
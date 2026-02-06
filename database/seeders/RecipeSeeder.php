<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // name => id (if duplicate names exist, last one wins)
        $foods = DB::table('foods')->pluck('id', 'name');

        $recipes = [
            // Nasi Lemak
            [
                'food' => 'Nasi Lemak',
                'title' => 'Simple Nasi Lemak (Home Style)',
                'ingredients' => ['Rice', 'Coconut milk', 'Pandan leaf', 'Sambal', 'Egg', 'Anchovies'],
                'steps' => ['Cook rice with coconut milk', 'Prepare sambal', 'Fry anchovies', 'Assemble with sides'],
                'estimated_time' => '45 min',
                'difficulty' => 'Medium',
            ],

            // Chicken Soup
            [
                'food' => 'Chicken Soup',
                'title' => 'Simple Chicken Soup',
                'ingredients' => ['Chicken', 'Garlic', 'Ginger', 'Salt', 'Water'],
                'steps' => ['Boil water', 'Add chicken', 'Add seasoning', 'Simmer 20 minutes'],
                'estimated_time' => '30 min',
                'difficulty' => 'Easy',
            ],

            // Chocolate Cake
            [
                'food' => 'Chocolate Cake',
                'title' => 'Simple Chocolate Mug Cake',
                'ingredients' => ['Flour', 'Cocoa powder', 'Sugar', 'Milk', 'Oil', 'Baking powder'],
                'steps' => ['Mix dry ingredients', 'Add milk and oil', 'Microwave 1–2 minutes', 'Serve'],
                'estimated_time' => '5 min',
                'difficulty' => 'Easy',
            ],

            // Fruit Salad
            [
                'food' => 'Fruit Salad',
                'title' => 'Quick Fruit Salad',
                'ingredients' => ['Apple', 'Banana', 'Grapes', 'Orange', 'Yogurt (optional)'],
                'steps' => ['Cut fruits', 'Mix together', 'Serve chilled'],
                'estimated_time' => '10 min',
                'difficulty' => 'Easy',
            ],

            // Iced Lemon Tea
            [
                'food' => 'Iced Lemon Tea',
                'title' => 'Classic Iced Lemon Tea',
                'ingredients' => ['Black tea bag', 'Hot water', 'Lemon', 'Sugar/Honey', 'Ice'],
                'steps' => ['Brew tea', 'Add sweetener', 'Cool down', 'Add lemon and ice', 'Serve'],
                'estimated_time' => '8 min',
                'difficulty' => 'Easy',
            ],

            // Fried Rice
            [
                'food' => 'Fried Rice',
                'title' => 'Quick Fried Rice',
                'ingredients' => ['Cooked rice', 'Egg', 'Garlic', 'Soy sauce', 'Vegetables (optional)'],
                'steps' => ['Heat oil', 'Fry garlic', 'Add egg', 'Add rice and soy sauce', 'Stir-fry 5 minutes'],
                'estimated_time' => '12 min',
                'difficulty' => 'Easy',
            ],

            // Oatmeal
            [
                'food' => 'Oatmeal',
                'title' => 'Warm Oatmeal Bowl',
                'ingredients' => ['Oats', 'Milk/Water', 'Honey', 'Banana'],
                'steps' => ['Boil milk/water', 'Add oats', 'Stir until thick', 'Top with honey and banana'],
                'estimated_time' => '8 min',
                'difficulty' => 'Easy',
            ],

            // Pasta Aglio Olio
            [
                'food' => 'Pasta Aglio Olio',
                'title' => 'Pasta Aglio Olio (Simple)',
                'ingredients' => ['Spaghetti', 'Garlic', 'Olive oil', 'Chili flakes (optional)', 'Salt'],
                'steps' => ['Boil pasta', 'Sauté garlic in oil', 'Toss pasta', 'Season and serve'],
                'estimated_time' => '15 min',
                'difficulty' => 'Easy',
            ],
        ];

        foreach ($recipes as $r) {
            if (!isset($foods[$r['food']])) {
                continue;
            }

            DB::table('recipes')->updateOrInsert(
                ['title' => $r['title']],
                [
                    'food_id' => $foods[$r['food']],
                    'title' => $r['title'],
                    'ingredients' => json_encode($r['ingredients']),
                    'steps' => json_encode($r['steps']),
                    'estimated_time' => $r['estimated_time'],
                    'difficulty' => $r['difficulty'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
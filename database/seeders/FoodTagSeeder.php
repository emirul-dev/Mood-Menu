<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodTagSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch IDs
        $foods = DB::table('foods')->pluck('id', 'name'); // name => id
        $tags  = DB::table('tags')->pluck('id', 'name');  // name => id

        $pairs = [
            // Nasi Lemak
            ['food' => 'Nasi Lemak', 'tag' => 'familiar'],
            ['food' => 'Nasi Lemak', 'tag' => 'comfort'],

            // Chicken Soup
            ['food' => 'Chicken Soup', 'tag' => 'warm'],
            ['food' => 'Chicken Soup', 'tag' => 'comfort'],
            ['food' => 'Chicken Soup', 'tag' => 'calming'],

            // Chocolate Cake
            ['food' => 'Chocolate Cake', 'tag' => 'sweet'],
            ['food' => 'Chocolate Cake', 'tag' => 'celebration'],
            ['food' => 'Chocolate Cake', 'tag' => 'comfort'],

            // Fruit Salad
            ['food' => 'Fruit Salad', 'tag' => 'light'],
            ['food' => 'Fruit Salad', 'tag' => 'refreshing'],

            // Iced Lemon Tea
            ['food' => 'Iced Lemon Tea', 'tag' => 'refreshing'],
            ['food' => 'Iced Lemon Tea', 'tag' => 'light'],

            // Fried Rice (Quick)
            ['food' => 'Fried Rice (Quick)', 'tag' => 'quick'],
            ['food' => 'Fried Rice (Quick)', 'tag' => 'energising'],

            // Oatmeal
            ['food' => 'Oatmeal', 'tag' => 'warm'],
            ['food' => 'Oatmeal', 'tag' => 'calming'],
            ['food' => 'Oatmeal', 'tag' => 'quick'],

            // Pasta Aglio Olio
            ['food' => 'Pasta Aglio Olio', 'tag' => 'quick'],
            ['food' => 'Pasta Aglio Olio', 'tag' => 'light'],
        ];

        $rows = [];
        foreach ($pairs as $p) {
            if (!isset($foods[$p['food']]) || !isset($tags[$p['tag']])) {
                continue;
            }
            $rows[] = [
                'food_id' => $foods[$p['food']],
                'tag_id'  => $tags[$p['tag']],
            ];
        }

        // Avoid duplicates (composite PK exists)
        foreach ($rows as $r) {
            DB::table('food_tag')->updateOrInsert(
                ['food_id' => $r['food_id'], 'tag_id' => $r['tag_id']],
                []
            );
        }
    }
}
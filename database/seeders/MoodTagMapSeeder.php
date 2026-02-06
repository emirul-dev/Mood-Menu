<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoodTagMapSeeder extends Seeder
{
    public function run(): void
    {
        $moods = DB::table('moods')->pluck('id', 'name'); // name => id
        $tags  = DB::table('tags')->pluck('id', 'name');  // name => id

        $map = [
            'happy'   => ['refreshing', 'light', 'sweet', 'celebration'],
            'stressed'=> ['comfort', 'warm', 'calming'],
            'tired'   => ['quick', 'energising', 'warm'],
            'sad'     => ['comfort', 'warm', 'familiar'],
        ];

        foreach ($map as $moodName => $tagNames) {
            if (!isset($moods[$moodName])) continue;
            foreach ($tagNames as $tagName) {
                if (!isset($tags[$tagName])) continue;

                DB::table('mood_tag_map')->updateOrInsert([
                    'mood_id' => $moods[$moodName],
                    'tag_id'  => $tags[$tagName],
                ], []);
            }
        }
    }
}
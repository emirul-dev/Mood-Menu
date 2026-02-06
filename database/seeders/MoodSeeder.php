<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class MoodSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $moods = [
            ['name' => 'happy'],
            ['name' => 'stressed'],
            ['name' => 'tired'],
            ['name' => 'sad'],
        ];

        foreach ($moods as &$m) {
            $m['created_at'] = $now;
            $m['updated_at'] = $now;
        }

        DB::table('moods')->upsert($moods, ['name'], ['updated_at']);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $tags = [
            ['name' => 'comfort'],
            ['name' => 'warm'],
            ['name' => 'calming'],
            ['name' => 'light'],
            ['name' => 'refreshing'],
            ['name' => 'sweet'],
            ['name' => 'quick'],
            ['name' => 'energising'],
            ['name' => 'familiar'],
            ['name' => 'celebration'],
        ];

        foreach ($tags as &$t) {
            $t['created_at'] = $now;
            $t['updated_at'] = $now;
        }

        DB::table('tags')->upsert($tags, ['name'], ['updated_at']);
    }
}
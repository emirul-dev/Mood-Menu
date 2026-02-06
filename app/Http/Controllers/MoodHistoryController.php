<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoodHistoryController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        // Get mood entries (each click = one entry)
        $entries = DB::table('mood_entries')
            ->join('moods', 'moods.id', '=', 'mood_entries.mood_id')
            ->where('mood_entries.user_id', $userId)
            ->orderByDesc('mood_entries.created_at')
            ->select(
                'mood_entries.id as mood_entry_id',
                'moods.name as mood_name',
                'mood_entries.created_at'
            )
            ->limit(50)
            ->get();

        $entryIds = $entries->pluck('mood_entry_id')->values();

        // Pull all recommendation rows for those entries
        $recs = $entryIds->isEmpty()
            ? collect()
            : DB::table('recommendation_logs')
                ->join('foods', 'foods.id', '=', 'recommendation_logs.food_id')
                ->whereIn('recommendation_logs.mood_entry_id', $entryIds)
                ->select(
                    'recommendation_logs.mood_entry_id',
                    'recommendation_logs.food_id',
                    'recommendation_logs.score',
                    'foods.name',
                    'foods.image_url',
                    'foods.type'
                )
                ->orderByDesc('recommendation_logs.score')
                ->get()
                ->groupBy('mood_entry_id');

        return view('moodmenu.history', [
            'entries' => $entries,
            'recsByEntry' => $recs,
        ]);
    }
}
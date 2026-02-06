<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MoodMenuController;
use App\Http\Controllers\SavedItemController;
use App\Http\Controllers\MoodHistoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/moodmenu', [MoodMenuController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('moodmenu');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/moodmenu', [MoodMenuController::class, 'index'])->name('moodmenu');
    Route::get('/moodmenu/foods/{food}', [MoodMenuController::class, 'foodOptions'])->name('moodmenu.food.options');
    Route::get('/moodmenu/foods/{food}/recipes', [MoodMenuController::class, 'foodRecipes'])->name('moodmenu.food.recipes');
    Route::get('/moodmenu/foods/{food}/restaurants', [MoodMenuController::class, 'foodRestaurants'])->name('moodmenu.food.restaurants');
    Route::post('/moodmenu/log-recommendation', [MoodMenuController::class, 'logRecommendation'])->name('moodmenu.log.recommendation');
    Route::get('/moodmenu/saved', [SavedItemController::class, 'index'])->name('moodmenu.saved');

    Route::post('/moodmenu/save/recipe/{recipe}', [SavedItemController::class, 'saveRecipe'])->name('moodmenu.save.recipe');
    Route::delete('/moodmenu/save/recipe/{recipe}', [SavedItemController::class, 'unsaveRecipe'])->name('moodmenu.unsave.recipe');

    Route::post('/moodmenu/save/restaurant/{restaurant}', [SavedItemController::class, 'saveRestaurant'])->name('moodmenu.save.restaurant');
    Route::delete('/moodmenu/save/restaurant/{restaurant}', [SavedItemController::class, 'unsaveRestaurant'])->name('moodmenu.unsave.restaurant');

    Route::get('/moodmenu/history', [MoodHistoryController::class, 'index'])->name('moodmenu.history');
});


require __DIR__.'/auth.php';

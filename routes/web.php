<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function() {
    Route::resource('jobs', \App\Http\Controllers\JobVacancyController::class)
        ->only(['create', 'store']);
    Route::middleware(['owner.job'])->group(function() {
        Route::resource('jobs', \App\Http\Controllers\JobVacancyController::class)
            ->only(['edit', 'update', 'destroy']);
    });
});
Route::get('/', [\App\Http\Controllers\JobVacancyController::class, 'index'])
    ->name('jobs.index');
Route::get('/jobs/{job}', [\App\Http\Controllers\JobVacancyController::class, 'show'])
    ->name('jobs.show');

require __DIR__.'/auth.php';

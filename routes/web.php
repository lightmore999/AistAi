<?php

use App\Http\Controllers\AIController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/ai', [AIController::class, 'index'])->name('ai.index');
    Route::get('/ai/history', [AIController::class, 'history'])->name('ai.history');
    Route::post('/ai/process', [AIController::class, 'process'])->name('ai.process');
    Route::delete('/ai/{id}', [AIController::class, 'destroy'])->name('ai.destroy');
});

require __DIR__.'/auth.php';

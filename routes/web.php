<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Route::get('/task', function () {
//     Route::get('/task', [TasksController::class, 'index'])->name('Task.index');
// })->middleware(['auth', 'verified'])->name('Task.index');

Route::middleware('auth')->group(function () {
    // タスク一覧画面
    Route::get('/task', [TasksController::class, 'index'])->name('Task.index');
    // タスク新規登録画面
    Route::get('/task/create', [TasksController::class, 'create'])->name('Task.create');
    // タスク新規登録機能
    Route::post('/task/store', [TasksController::class, 'store'])->name('Task.store');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

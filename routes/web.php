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
    // タスク一覧画面表示
    Route::get('/task', [TasksController::class, 'index'])->name('Task.index');
    // タスク一覧検索機能
    Route::post('/task/search', [TasksController::class, 'search'])->name('Task.search');
    // タスク新規登録画面表示
    Route::get('/task/create', [TasksController::class, 'create'])->name('Task.create');
    // タスク新規登録機能
    Route::post('/task/store', [TasksController::class, 'store'])->name('Task.store');
    // タスク編集画面表示
    Route::get('/task/{id}/edit', [TasksController::class, 'edit'])->name('Task.edit');
    // タスク編集機能
    Route::post('/task/{id}/update', [TasksController::class, 'update'])->name('Task.update');
    // タスク削除機能
    Route::delete('/task/{id}/delete', [TasksController::class, 'delete'])->name('Task.delete');
    // カレンダー用のデータ取得(ajax)
    Route::get('/task/date_data', [TasksController::class, 'date'])->name('Task.date');
    // 期限が近いタスクデータの取得(fetch)
    Route::get('/task/notification', [TasksController::class, 'notification'])->name('Task.notification');
    // タスク削除機能
    Route::delete('/task/{id}/notification_delete', [TasksController::class, 'notificationDel'])->name('Task.notification_delete');



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

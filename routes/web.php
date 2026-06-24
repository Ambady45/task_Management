<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('tasks', TaskController::class);
   
    Route::delete('/tasks/{task}/remove-user/{user}',[TaskController::class, 'removeUser'])->name('tasks.remove-user');
    Route::patch('/tasks/{task}/due-date',[TaskController::class, 'updateDueDate'])->name('tasks.due-date');
    Route::get('/archived-tasks',[TaskController::class, 'archived'])->name('tasks.archived');
    Route::post('/restore-task/{id}',[TaskController::class, 'restore'])->name('tasks.restore');


    Route::get('/tasks/{task}/assign-users',[TaskController::class, 'assignUserForm'])->name('tasks.assign.form');
    Route::post('/tasks/{task}/assign-users',[TaskController::class, 'assignUsers'])->name('tasks.assign-users');
});

require __DIR__.'/auth.php';

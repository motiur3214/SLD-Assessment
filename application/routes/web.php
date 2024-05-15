<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
Route::middleware('auth')->group(function () {
    Route::resource('/users', UserController::class);
    Route::get('/trashed-users-list', [UserController::class, 'trashedUsers'])->name('users.trashed');
    Route::get('/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('/{id}/delete', [UserController::class, 'forceDelete'])->name('users.delete');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



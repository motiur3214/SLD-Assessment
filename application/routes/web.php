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

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware([\App\Http\Middleware\IsUserAdmin::class])->group(function () {
        Route::resource('/users', UserController::class);
        Route::softDeleteUser('/users/{id}/soft-delete', \App\Models\User::class, 'users.softDelete');
        Route::get('/trashed-users-list', [UserController::class, 'trashedUsers'])->name('users.trashed');
        Route::patch('/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::delete('/{id}/forceDelete', [UserController::class, 'forceDelete'])->name('users.delete');
    });

});

require __DIR__ . '/auth.php';

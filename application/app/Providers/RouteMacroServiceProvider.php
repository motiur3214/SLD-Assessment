<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteMacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::macro('softDeleteUser', function ($uri, $model = 'user', $name = null) {
            Route::delete($uri, function ($id) use ($model) {
                $user = $model::withTrashed()->findOrFail($id);
                $user->delete();
                Session::flash('success', 'User soft deleted successfully');
                return redirect()->route('users.index');
            })->name($name);
        });
        Route::macro('softDeleteUser', function ($uri, $model = User::class, $name = null) {
            Route::delete($uri, function ($id) use ($model) {
                $user = $model::withTrashed()->findOrFail($id);
                $user->delete();

                Session::flash('success', 'User soft deleted successfully');

                return redirect()->route($name ?? 'users.index');
            })->name($name);
        });
    }
}

<?php


namespace App\Providers;

use App\Services\UserServiceInterface;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);

    }

    public function boot()
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);

    }
}

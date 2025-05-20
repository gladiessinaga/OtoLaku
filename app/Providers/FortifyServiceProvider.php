<?php

namespace App\Providers;

use App\Http\Responses\LoginResponse;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class FortifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
    }

    public function boot()
    {
        //
    }
}

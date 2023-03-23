<?php

namespace App\Providers;

use App\Models\ValidEmail;
use Illuminate\Support\ServiceProvider;
use App\Observers\ValidEmailObserver;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ValidEmail::observe(ValidEmailObserver::class);
    }
}

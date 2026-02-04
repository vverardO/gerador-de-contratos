<?php

namespace App\Providers;

use App\Models\Driver;
use App\Observers\DriverObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Driver::observe(DriverObserver::class);
    }
}

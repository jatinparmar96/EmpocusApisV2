<?php

namespace App\Providers;

use App\Api\V1\Observer\CRM\EmployeeObserver;
use App\Models\Master\Employee;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Register Observers
        Employee::observe(EmployeeObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

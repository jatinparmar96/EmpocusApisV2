<?php

namespace App\Providers;

use App\Api\V1\Observer\CRM\EmployeeObserver;
use App\Api\V1\Observer\CRM\LeadObserver;
use App\Models\Crm\Lead;
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
        Lead::observe(LeadObserver::class);
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

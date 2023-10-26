<?php

namespace App\Providers;

use App\Enrollment;
use App\Observers\EnrollmentsObserver;
use App\Observers\StudentObserver;
use App\Observers\UserObserver;
use App\Student;
use App\User;
use App\View\Components\AccessModuleComponent;
use App\View\Components\StatsCurrentMonthComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Enrollment::observe(EnrollmentsObserver::class);
        User::observe(UserObserver::class);
        Student::observe(StudentObserver::class);
        Blade::component('stats-current-month', StatsCurrentMonthComponent::class);
        Blade::component('access-module', AccessModuleComponent::class);
    }
}

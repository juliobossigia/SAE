<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Livewire\Auth\RegisterForm;

class AppServiceProvider extends ServiceProvider
{ 
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */ 
    public function boot(): void
    {
        Livewire::component('auth.register-form', RegisterForm::class);
    }
}

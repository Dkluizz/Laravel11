<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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

    // Definindo o Gate 'is_admin'
    Gate::define('is_admin', function ($user) {
        return $user->is_admin; // Verifica se o usuário tem o campo is_admin como true
    });
    }
}

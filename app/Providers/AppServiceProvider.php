<?php
// app/Providers/AppServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registrar servicios de la aplicación
     *
     * @return void
     */
    public function register()
    {
        // Registrar helpers
        require_once app_path('Helpers/helpers.php');
    }
    
    /**
     * Inicializar servicios de la aplicación
     *
     * @return void
     */
    public function boot()
    {
        // Registrar middleware personalizado
        $this->app['router']->aliasMiddleware('theme', \App\Http\Middleware\ThemeMiddleware::class);
        $this->app['router']->aliasMiddleware('auth.custom', \App\Http\Middleware\AuthCustomMiddleware::class);
        $this->app['router']->aliasMiddleware('professor', \App\Http\Middleware\ProfessorMiddleware::class);
        $this->app['router']->aliasMiddleware('guest', \App\Http\Middleware\RedirectIfAuthenticated::class);
    }
}
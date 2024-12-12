<?php

namespace CedulaProfesional;

use Illuminate\Support\ServiceProvider;

class CedulaProfesionalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('cedula-profesional', function ($app) {
            return new DatosPersonales();
        });

        $this->app->alias('cedula-profesional', DatosPersonales::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // No necesitamos configuración por ahora
    }
} 
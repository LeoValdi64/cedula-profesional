<?php

namespace CedulaProfesional\Facades;

use Illuminate\Support\Facades\Facade;

class CedulaProfesional extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cedula-profesional';
    }
} 
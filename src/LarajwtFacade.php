<?php

namespace Andr3a\Larajwt;

use Illuminate\Support\Facades\Facade;

class LarajwtFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'larajwt';
    }
}

<?php

namespace Facades\XContains\XContains\Ars;

use Illuminate\Support\Facades\Facade;

/**
 * @see \XContains\XContains\Ars\Ai
 */
class Ai extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'XContains\XContains\Ars\Ai';
    }
}

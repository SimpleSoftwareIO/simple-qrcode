<?php

namespace SimpleSoftwareIO\QrCode;

use SimpleSoftwareIO\QrCode\Generator;
use Illuminate\Support\Facades\Facade;

class QrCode extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        self::clearResolvedInstance(Generator::class);

        return Generator::class;
    }
}

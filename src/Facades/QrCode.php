<?php

namespace BeaconsBay\QrCode\Facades;

use Illuminate\Support\Facades\Facade;
use BeaconsBay\QrCode\Generator;

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

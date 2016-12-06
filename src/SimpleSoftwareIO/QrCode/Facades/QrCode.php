<?php

namespace SimpleSoftwareIO\QrCode\Facades;

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
        self::clearResolvedInstance('qrcode');

        return 'qrcode';
    }
}

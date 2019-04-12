<?php

namespace SimpleSoftwareIO\QrCode\Facades;

use Illuminate\Support\Facades\Facade;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

/**
 * @method static string|void generate($text, $filename = null)
 * @method static BaconQrCodeGenerator merge($filepath, $percentage = .2, $absolute = false)
 * @method static BaconQrCodeGenerator mergeString($content, $percentage = .2)
 * @method static BaconQrCodeGenerator format($format)
 * @method static BaconQrCodeGenerator size($pixels)
 * @method static BaconQrCodeGenerator color($red, $green, $blue)
 * @method static BaconQrCodeGenerator backgroundColor($red, $green, $blue)
 * @method static BaconQrCodeGenerator errorCorrection($level)
 * @method static BaconQrCodeGenerator margin($margin)
 * @method static BaconQrCodeGenerator encoding($encoding)
 *
 * @see BaconQrCodeGenerator
 */
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

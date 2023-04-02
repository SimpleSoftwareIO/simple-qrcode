<?php

namespace SimpleSoftwareIO\QrCode;

use InvalidArgumentException;

class HexToRgb
{
    public int $red;
    public int $green;
    public int $blue;

    public function __construct(public string $hex, public mixed $alpha = false)
    {
        if ($this->validateHex($hex) === false) {
            throw new InvalidArgumentException('Invalid hex value, not a hex code');
        }

        $this->hexToRgb($hex, $alpha);
    }

    public function toRGBArray(): array
    {
        return [
            $this->red,
            $this->green,
            $this->blue,
        ];
    }

    /**
     * Validate a hex code. Returns true if valid, false if not.
     * Taken from Drupal.
     * @see https://api.drupal.org/api/drupal/core%21lib%21Drupal%21Component%21Utility%21Color.php/function/Color%3A%3AvalidateHex/8.2.x
     *
     * @param  string  $hex
     *
     * @return bool
     */
    private function validateHex(string $hex): bool
    {
        return preg_match('/^[#]?([0-9a-fA-F]{3}){1,2}$/', $hex) === 1;
    }

    /**
     * Convert a hex code to RGB.
     *
     * @see https://stackoverflow.com/questions/15202079/convert-hex-color-to-rgb-values-in-php
     *
     * @param  string  $hex
     * @param  mixed  $alpha
     *
     * @return void
     */
    private function hexToRgb(string $hex, mixed $alpha = false): void
    {
        $hex = str_replace('#', '', $hex);
        $length = strlen($hex);
        $this->red = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1),
            2) : 0));
        $this->green = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1),
            2) : 0));
        $this->blue = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1),
            2) : 0));
        if ($alpha) {
            $this->alpha = $alpha;
        }

    }
}

<?php

namespace SimpleSoftwareIO\QrCode;

interface Singleton
{
    /**
     * Returns the instance of the class.
     *
     * @return self
     */
    public static function instance();
}

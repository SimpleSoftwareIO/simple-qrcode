<?php

use SimpleSoftwareIO\QrCode\DataTypes\Geo;

class GeoTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_generates_the_proper_format_for_a_geo_coordinate()
    {
        $geo = new Geo();
        $geo->create([10.254, -30.254]);

        $properFormat = 'geo:10.254,-30.254';

        $this->assertEquals($properFormat, strval($geo));
    }
}

<?php

use SimpleSoftwareIO\QrCode\DataTypes\WiFi;

class WiFiTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->wifi = new Wifi();
    }

    public function test_it_generates_a_proper_format_with_just_the_ssid()
    {
        $this->wifi->create([
            0 => [
                'ssid' => 'foo',
            ],
        ]);

        $properFormat = 'WIFI:S:foo;';

        $this->assertEquals($properFormat, strval($this->wifi));
    }

    public function test_it_generates_a_proper_format_for_a_ssid_that_is_hidden()
    {
        $this->wifi->create([
            0 => [
                'ssid'   => 'foo',
                'hidden' => 'true',
            ],
        ]);

        $properFormat = 'WIFI:S:foo;H:true;';

        $this->assertEquals($properFormat, strval($this->wifi));
    }

    public function test_it_generates_a_proper_format_for_a_ssid_encryption_and_password()
    {
        $this->wifi->create([
            0 => [
                'ssid'       => 'foo',
                'encryption' => 'WPA',
                'password'   => 'bar',
            ],
        ]);

        $properFormat = 'WIFI:T:WPA;S:foo;P:bar;';

        $this->assertEquals($properFormat, strval($this->wifi));
    }

    public function test_it_generates_a_proper_format_for_a_ssid_encryption_password_and_is_hidden()
    {
        $this->wifi->create([
            0 => [
                'ssid'       => 'foo',
                'encryption' => 'WPA',
                'password'   => 'bar',
                'hidden'     => 'true',
            ],
        ]);

        $properFormat = 'WIFI:T:WPA;S:foo;P:bar;H:true;';

        $this->assertEquals($properFormat, strval($this->wifi));
    }
}

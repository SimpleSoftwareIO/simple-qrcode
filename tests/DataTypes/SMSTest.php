<?php

use SimpleSoftwareIO\QrCode\DataTypes\SMS;

/**
 * Simple Laravel QrCode Generator
 * A simple wrapper for the popular BaconQrCode made for Laravel.
 *
 * @link http://www.simplesoftware.io
 * @author SimpleSoftware support@simplesoftware.io
 *
 */

class SMSTest extends \PHPUnit_Framework_TestCase{

    public function setUp()
    {
        $this->sms = new SMS;
    }

    public function test_it_generates_a_proper_format_with_a_phone_number()
    {
        $this->sms->create(['555-555-5555']);

        $properFormat = 'sms:555-555-5555';

        $this->assertEquals($properFormat, strval($this->sms));
    }

    public function test_it_generate_a_proper_format_with_a_message()
    {
        $this->sms->create([null, 'foo']);

        $properFormat = 'sms::foo';

        $this->assertEquals($properFormat, strval($this->sms));
    }

    public function test_it_generates_a_proper_format_with_a_phone_number_and_message()
    {
        $this->sms->create(['555-555-5555', 'foo']);

        $properFormat = 'sms:555-555-5555:foo';

        $this->assertEquals($properFormat, strval($this->sms));
    }
}
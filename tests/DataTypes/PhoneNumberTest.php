<?php

use SimpleSoftwareIO\QrCode\DataTypes\PhoneNumber;

class PhoneNumberTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_generates_the_proper_format_for_calling_a_phone_number()
    {
        $phoneNumber = new PhoneNumber();
        $phoneNumber->create(['555-555-5555']);

        $properFormat = 'tel:555-555-5555';

        $this->assertEquals($properFormat, strval($phoneNumber));
    }
}

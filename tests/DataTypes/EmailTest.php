<?php

use PHPUnit\Framework\TestCase;
use SimpleSoftwareIO\QrCode\DataTypes\Email;

class EmailTest extends TestCase
{
    public function setUp(): void
    {
        $this->email = new Email();
    }

    public function test_it_generates_the_proper_format_when_only_an_email_address_is_supplied()
    {
        $this->email->create(['foo@bar.com']);

        $properFormat = 'mailto:foo@bar.com';

        $this->assertEquals($properFormat, strval($this->email));
    }

    public function test_it_generates_the_proper_format_when_an_email_subject_and_body_are_supplied()
    {
        $this->email->create(['foo@bar.com', 'foo', 'bar']);

        $properFormat = 'mailto:foo@bar.com?subject=foo&body=bar';

        $this->assertEquals($properFormat, strval($this->email));
    }

    public function test_it_generates_the_proper_format_when_an_email_and_subject_are_supplied()
    {
        $this->email->create(['foo@bar.com', 'foo']);

        $properFormat = 'mailto:foo@bar.com?subject=foo';

        $this->assertEquals($properFormat, strval($this->email));
    }

    public function test_it_generates_the_proper_format_when_only_a_subject_is_provided()
    {
        $this->email->create([null, 'foo']);

        $properFormat = 'mailto:?subject=foo';

        $this->assertEquals($properFormat, strval($this->email));
    }

    public function test_it_throws_an_exception_when_an_invalid_email_is_given()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->email->create(['foo']);
    }
}

<?php

namespace DataTypes;

use BaconQrCode\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use SimpleSoftwareIO\QrCode\DataTypes\Calendar;

class CalendarTest extends TestCase
{
    /**
     * The separator between the variables.
     *
     * @var string
     */
    private $separator;

    /**
     * The calendar variable.
     *
     * @var Calendar
     */
    private $calendar;

    public function setUp(): void
    {
        $this->separator = "\r\n";
        $this->calendar = new Calendar();
    }

    public function test_summary_is_mandatory()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calendar->create([
            0 => [
                'startDateTime' => '2020-04-15 14:00',
            ],
        ]);
    }

    public function test_start_date_time_is_mandatory()
    {
        $exceptionOccurred = false;
        try {
            $this->calendar->create([
                0 => [
                    'summary' => 'My FooBar Event',
                ],
            ]);
        } catch (InvalidArgumentException $e) {
            $exceptionOccurred = true;
            $this->assertEquals($e->getMessage(), 'Please provide a start date for the event.');
        }

        $this->assertTrue($exceptionOccurred);
    }

    public function test_it_generates_a_proper_format_with_just_the_summary_and_start_date_time()
    {
        $this->calendar->create([
            0 => [
                'summary' => 'My FooBar Event',
                'startDateTime' => '2020-10-08 16:00',
            ],
        ]);

        $properFormat = 'BEGIN:VEVENT'.$this->separator.
                        'SUMMARY:My FooBar Event'.$this->separator.
                        'DTSTART:20201008T161000'.$this->separator.
                        'END:VEVENT';

        $this->assertEquals($properFormat, strval($this->calendar));
    }

    public function test_it_generates_a_proper_format_with_summary_start_date_time_and_end_date_time()
    {
        $this->calendar->create([
            0 => [
                'summary' => 'My FooBar Event',
                'startDateTime' => '2020-10-08 16:00',
                'endDateTime' => '2020-10-08 18:00',
            ],
        ]);

        $properFormat = 'BEGIN:VEVENT'.$this->separator.
            'SUMMARY:My FooBar Event'.$this->separator.
            'DTSTART:20201008T161000'.$this->separator.
            'DTEND:20201008T181000'.$this->separator.
            'END:VEVENT';

        $this->assertEquals($properFormat, strval($this->calendar));
    }

    public function test_it_generates_a_proper_format_with_specified_date_time_format()
    {
        $this->calendar->create([
            0 => [
                'summary' => 'My FooBar Event',
                'startDateTime' => '2020-10-08 16:00',
                'endDateTime' => '2020-10-08 18:00',
                'dateTimeFormat' => 'Y-m-d H:i',
            ],
        ]);

        $properFormat = 'BEGIN:VEVENT'.$this->separator.
            'SUMMARY:My FooBar Event'.$this->separator.
            'DTSTART:20201008T161000'.$this->separator.
            'DTEND:20201008T181000'.$this->separator.
            'END:VEVENT';

        $this->assertEquals($properFormat, strval($this->calendar));
    }

    public function test_date_time_format_validation()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calendar->create([
            0 => [
                'summary' => 'My FooBar Event',
                'startDateTime' => '2020-10-08 16:00',
                'endDateTime' => '2020-10-08 18:00',
                'dateTimeFormat' => 'Y/m/d H:i',
            ],
        ]);
    }

    public function test_it_generates_a_proper_format_with_summary_start_date_time_and_just_location()
    {
        $this->calendar->create([
            0 => [
                'summary' => 'My FooBar Event',
                'startDateTime' => '2020-10-08 16:00',
                'location' => 'Fooon',
            ],
        ]);

        $properFormat = 'BEGIN:VEVENT'.$this->separator.
            'SUMMARY:My FooBar Event'.$this->separator.
            'DTSTART:20201008T161000'.$this->separator.
            'LOCATION:Fooon'.$this->separator.
            'END:VEVENT';

        $this->assertEquals($properFormat, strval($this->calendar));
    }

    public function test_it_generates_a_proper_format_with_summary_start_date_time_and_just_url()
    {
        $this->calendar->create([
            0 => [
                'summary' => 'My FooBar Event',
                'startDateTime' => '2020-10-08 16:00',
                'url' => 'https://www.google.com',
            ],
        ]);

        $properFormat = 'BEGIN:VEVENT'.$this->separator.
            'SUMMARY:My FooBar Event'.$this->separator.
            'DTSTART:20201008T161000'.$this->separator.
            'URL:https://www.google.com'.$this->separator.
            'END:VEVENT';

        $this->assertEquals($properFormat, strval($this->calendar));
    }

    public function test_it_generates_a_proper_format_with_calendar_parameters()
    {
        $this->calendar->create([
            0 => [
                'summary' => 'My FooBar Event',
                'startDateTime' => '2020-10-08 16:00',
                'endDateTime' => '2020-10-08 18:00',
                'location' => 'Foo Location',
                'timezone' => 'Africa/Douala',
                'url' => 'https://www.google.com',
                'categories' => ['Business', 'Anniversary', 'Special'],
                'dateTimeFormat' => 'Y-m-d H:i',
                'description' => 'FooBar\'s Event description can be longer than this',
                'alarm' => [
                    'trigger' => [
                        'weeks' => 1,
                        'days' => 2,
                        'hours' => 3,
                        'minutes' => 20,
                        'seconds' => 0,
                        'before' => true,
                    ],
                    'repeat' => 2,
                    'summary' => 'Alarm Summary',
                    'description' => 'Alarm Description can be longer',
                ],
            ],
        ]);

        $properFormat = 'BEGIN:VEVENT'.$this->separator.
            'SUMMARY:My FooBar Event'.$this->separator.
            'DTSTART;TZID=Africa/Douala:20201008T161000'.$this->separator.
            'DTEND;TZID=Africa/Douala:20201008T181000'.$this->separator.
            'LOCATION:Foo Location'.$this->separator.
            'URL:https://www.google.com'.$this->separator.
            'DESCRIPTION:FooBar\'s Event description can be longer than this'.$this->separator.
            'CATEGORIES:Business,Anniversary,Special'.$this->separator.
            'BEGIN:VALARM'.$this->separator.
            'ACTION:DISPLAY'.$this->separator.
            'REPEAT:2'.$this->separator.
            'SUMMARY:Alarm Summary'.$this->separator.
            'DESCRIPTION:Alarm Description can be longer'.$this->separator.
            'TRIGGER:-P1W2DT3H20M0S'.$this->separator.
            'END:VALARM'.$this->separator.
            'END:VEVENT';

        $this->assertEquals($properFormat, strval($this->calendar));
    }
}

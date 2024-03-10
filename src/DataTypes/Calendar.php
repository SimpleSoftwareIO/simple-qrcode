<?php

namespace SimpleSoftwareIO\QrCode\DataTypes;

use BaconQrCode\Exception\InvalidArgumentException;
use DateTime;
use DateTimeZone;
use Exception;

class Calendar implements DataTypeInterface
{
    /**
     * The prefix of the QrCode.
     *
     * @var string
     */
    protected $prefix = 'BEGIN:VEVENT';

    /**
     * The suffix of the QrCode.
     *
     * @var string
     */
    protected $suffix = 'END:VEVENT';

    /**
     * The separator between the variables.
     *
     * @var string
     */
    protected $separator = "\r\n";

    /**
     * The summary of the event.
     *
     * @var string
     */
    protected $summary;

    /**
     * The location of the event.
     *
     * @var string
     */
    protected $location;

    /**
     * The url of the event.
     *
     * @var string
     */
    protected $url;

    /**
     * The start time of the event.
     * e.g 2020-05-23 15:00.
     *
     * @var string
     */
    protected $startDateTime;

    /**
     * The end time of the event.
     * e.g 2020-05-24 15:00.
     *
     * @var string
     */
    protected $endDateTime;

    /**
     * Start/End date timezone.
     * e.g 'Africa/Douala'.
     *
     * @var string
     */
    protected $timezone;

    /**
     * The standard format for the [$statDateTime] and [$endDateTime].
     * Gets overridden if user specifies their own formats [$dateTimeFormat].
     *
     * @var string
     */
    protected $dateTimeFormat = 'Y-m-d H:i';

    /**
     * Event full descriptions/notes.
     *
     * @var string
     */
    protected $description;

    /**
     * Event categories.
     *
     * @var array
     */
    protected $categories;

    /**
     * Alarm/Reminder. Trigger's before/after event.
     *
     * @var array
     */
    protected $alarm;

    /**
     * Generates the DataType Object and sets all of its properties.
     *
     * @param $arguments
     */
    public function create(array $arguments)
    {
        $this->setProperties($arguments);
    }

    /**
     * Returns the correct QrCode format.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->buildCalendarString();
    }

    /**
     * Builds the WiFi string.
     *
     * @return string
     */
    protected function buildCalendarString()
    {
        $calendar = $this->prefix.$this->separator;

        if (isset($this->summary)) {
            $calendar .= 'SUMMARY:'.$this->summary.$this->separator;
        }
        if (isset($this->startDateTime)) {
            $calendar .= 'DTSTART';
            if (isset($this->timezone)) {
                $calendar .= $this->timezone;
            }
            $calendar .= ':'.$this->startDateTime.$this->separator;
        }
        if (isset($this->endDateTime)) {
            $calendar .= 'DTEND';
            if (isset($this->timezone)) {
                $calendar .= $this->timezone;
            }
            $calendar .= ':'.$this->endDateTime.$this->separator;
        }
        if (isset($this->location)) {
            $calendar .= 'LOCATION:'.$this->location.$this->separator;
        }
        if (isset($this->url)) {
            $calendar .= 'URL:'.$this->url.$this->separator;
        }
        if (isset($this->description)) {
            $calendar .= 'DESCRIPTION:'.$this->description.$this->separator;
        }
        if (isset($this->categories)) {
            $calendar .= 'CATEGORIES:'.$this->categories.$this->separator;
        }
        if (isset($this->alarm)) {
            $calendar .= $this->alarm;
        }

        $calendar .= $this->suffix;

        return $calendar;
    }

    /**
     * Sets the Calendar properties.
     *
     * @param $arguments
     */
    protected function setProperties(array $arguments)
    {
        $arguments = $arguments[0];
        if (! isset($arguments['summary'])) {
            throw new InvalidArgumentException('Please provide an event summary.');
        } elseif (! isset($arguments['startDateTime'])) {
            throw new InvalidArgumentException('Please provide a start date for the event.');
        } else {
            if (isset($arguments['dateTimeFormat'])) {
                $this->dateTimeFormat = $arguments['dateTimeFormat'];
            }
            if (isset($arguments['timezone'])) {
                $this->setEventTimeZone($arguments['timezone']);
            }

            $this->summary = $arguments['summary'];
            $this->setEventDateTime($arguments['startDateTime'], 'start');

            if (isset($arguments['endDateTime'])) {
                $this->setEventDateTime($arguments['endDateTime'], 'end');
            }
            if (isset($arguments['location'])) {
                $this->location = $arguments['location'];
            }
            if (isset($arguments['url'])) {
                $this->setUrl($arguments['url']);
            }
            if (isset($arguments['description'])) {
                $this->description = $arguments['description'];
            }
            if (isset($arguments['categories'])) {
                $this->setCategories($arguments['categories']);
            }
            if (isset($arguments['alarm'])) {
                $this->setAlarm($arguments['alarm']);
            }
        }
    }

    /**
     * Sets the url property.
     *
     * @param $url
     */
    protected function setUrl($url)
    {
        if ($this->isValidUrl($url)) {
            $this->url = $url;
        }
    }

    /**
     * Sets the datetime property.
     *
     * @param string $eventDateTime
     * @param string $type
     */
    protected function setEventDateTime($eventDateTime, $type = '')
    {
        if ($this->isValidDateTime($eventDateTime, $type)) {
            if ($type == 'start') {
                $this->startDateTime = $this->convertEventDateTimeToString($eventDateTime);
            }
            if ($type == 'end') {
                $this->endDateTime = $this->convertEventDateTimeToString($eventDateTime);
            }
        }
    }

    /**
     * Ensures url is valid.
     *
     * @param string $url
     *
     * @return bool
     */
    protected function isValidUrl($url)
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid url provided');
        }

        return true;
    }

    /**
     * Ensures datetime is valid.
     *
     * @param string $dateTime
     * @param string $type
     *
     * @return bool
     */
    protected function isValidDateTime($dateTime, $type = '')
    {
        $newDate = DateTime::createFromFormat($this->dateTimeFormat, $dateTime);
        if (! ($newDate && $newDate->format($this->dateTimeFormat) == $dateTime)) {
            if ($type == 'start') {
                throw new InvalidArgumentException('Invalid start date provided. Date must be of format '.
                    $this->dateTimeFormat);
            }
            if ($type == 'end') {
                throw new InvalidArgumentException('Invalid end date provided. Date must be of format '.
                    $this->dateTimeFormat);
            }
            throw new InvalidArgumentException('Invalid date provided. Date must be of format '.
                $this->dateTimeFormat);
        }

        return true;
    }

    /**
     * Returns correct date time to string.
     *
     * @param string $dateTime
     * @return string
     */
    protected function convertEventDateTimeToString($dateTime)
    {
        try {
            $date = new DateTime($dateTime);
        } catch (Exception $e) {
            throw new InvalidArgumentException('Invalid date provided');
        }

        return $date->format('yymd\THms');
    }

    /**
     * Ensures timezone string is valid. ('Africa/Douala').
     *
     * @param string $timezone
     *
     * @return bool
     */
    protected function isValidTimeZone($timezone)
    {
        if (! in_array($timezone, DateTimeZone::listIdentifiers())) {
            throw new InvalidArgumentException('Invalid timezone provided.');
        }

        return true;
    }

    /**
     * Sets the timezone property.
     *
     * @param $timezone
     */
    protected function setEventTimeZone($timezone)
    {
        if ($this->isValidTimeZone($timezone)) {
            $this->timezone = ';TZID='.$timezone;
        }
    }

    /**
     * Sets the alarm property.
     *
     * @param array $alarm
     */
    protected function setAlarm($alarm)
    {
        if (is_array($alarm)) {
            $alarmString = 'BEGIN:VALARM'.$this->separator;
            $alarmString .= 'ACTION:DISPLAY'.$this->separator;
            $alarmString .= $this->keyExists('repeat', $alarm) ?
                'REPEAT:'.$alarm['repeat'].$this->separator : '';
            $alarmString .= $this->keyExists('summary', $alarm) ?
                'SUMMARY:'.$alarm['summary'].$this->separator : '';
            $alarmString .= $this->keyExists('description', $alarm) ?
                'DESCRIPTION:'.$alarm['description'].$this->separator : '';
            if ($this->keyExists('trigger', $alarm) && is_array($alarm['trigger'])) {
                $alarmString .= $this->setAlarmTrigger($alarm['trigger']).$this->separator;
            }
            $alarmString .= 'END:VALARM'.$this->separator;
            $this->alarm = $alarmString;
        } else {
            throw new InvalidArgumentException('Invalid alarm provided.');
        }
    }

    /**
     * Sets the alarm trigger property.
     *
     * @param array $alarm
     * @return string
     */
    protected function setAlarmTrigger($alarm)
    {
        if (is_array($alarm)) {
            $alarmString = 'TRIGGER:';
            $alarmString .= $this->keyExists('before', $alarm) ? $alarm['before'] ? '-' : '' : '';
            $alarmString .= 'P';
            $alarmString .= $this->keyExists('weeks', $alarm) ? $alarm['weeks'].'W' : '';
            $alarmString .= $this->keyExists('days', $alarm) ? $alarm['days'].'D' : '';
            $alarmString .= 'T';
            $alarmString .= $this->keyExists('hours', $alarm) ? $alarm['hours'].'H' : '';
            $alarmString .= $this->keyExists('minutes', $alarm) ? $alarm['minutes'].'M' : '';
            $alarmString .= $this->keyExists('seconds', $alarm) ? $alarm['seconds'].'S' : '';

            return $alarmString;
        } else {
            throw new InvalidArgumentException('Invalid alarm duration provided.');
        }
    }

    /**
     * Sets the event categories property.
     *
     * @param array $categories
     */
    protected function setCategories($categories)
    {
        if (is_array($categories)) {
            $this->categories = implode(',', $categories);
        } else {
            throw new InvalidArgumentException('Invalid categories provided.');
        }
    }

    /**
     * Checks if key exists in array.
     *
     * @param string $key
     * @param array $array
     *
     * @return bool
     */
    protected function keyExists($key, $array)
    {
        return array_key_exists($key, $array);
    }
}

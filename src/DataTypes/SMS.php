<?php

namespace SimpleSoftwareIO\QrCode\DataTypes;

class SMS implements DataTypeInterface
{
    /**
     * The prefix of the QrCode.
     *
     * @var string
     */
    protected $prefix = 'sms:';

    /**
     * The separator between the variables.
     *
     * @var string
     */
    protected $separator = '&body=';

    /**
     * The phone number.
     *
     * @var string
     */
    protected $phoneNumber;

    /**
     * The SMS message.
     *
     * @var string
     */
    protected $message;

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
        return $this->buildSMSString();
    }

    /**
     * Sets the phone number and message for a sms message.
     *
     * @param array $arguments
     */
    protected function setProperties(array $arguments)
    {
        if (isset($arguments[0])) {
            $this->phoneNumber = $arguments[0];
        }
        if (isset($arguments[1])) {
            $this->message = $arguments[1];
        }
    }

    /**
     * Builds a SMS string.
     *
     * @return string
     */
    protected function buildSMSString()
    {
        $sms = $this->prefix.$this->phoneNumber;

        if (isset($this->message)) {
            $sms .= $this->separator.$this->message;
        }

        return $sms;
    }
}

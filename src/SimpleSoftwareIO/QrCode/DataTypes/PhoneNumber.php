<?php

namespace SimpleSoftwareIO\QrCode\DataTypes;

class PhoneNumber implements DataTypeInterface
{
    /**
     * The prefix of the QrCode.
     *
     * @var string
     */
    protected $prefix = 'tel:';

    /**
     * The phone number.
     *
     * @var
     */
    protected $phoneNumber;

    /**
     * Generates the DataType Object and sets all of its properties.
     *
     * @param $arguments
     */
    public function create(array $arguments)
    {
        $this->phoneNumber = $arguments[0];
    }

    /**
     * Returns the correct QrCode format.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->prefix.$this->phoneNumber;
    }
}

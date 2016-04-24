<?php

namespace SimpleSoftwareIO\QrCode\DataTypes;

class Geo implements DataTypeInterface
{
    /**
     * The prefix of the QrCode.
     *
     * @var string
     */
    private $prefix = 'geo:';

    /**
     * The separator between the variables.
     *
     * @var string
     */
    private $separator = ',';

    /**
     * The latitude.
     *
     * @var
     */
    protected $latitude;

    /**
     * The longitude.
     *
     * @var
     */
    private $longitude;

    /**
     * Generates the DataType Object and sets all of its properties.
     *
     * @param $arguments
     */
    public function create(array $arguments)
    {
        $this->latitude = $arguments[0];
        $this->longitude = $arguments[1];
    }

    /**
     * Returns the correct QrCode format.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->prefix.$this->latitude.$this->separator.$this->longitude;
    }
}

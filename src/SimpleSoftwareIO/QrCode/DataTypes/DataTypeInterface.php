<?php

namespace SimpleSoftwareIO\QrCode\DataTypes;

interface DataTypeInterface
{
    /**
     * Generates the DataType Object and sets all of its properties.
     */
    public function create(array $arguments);

    /**
     * Returns the correct QrCode format.
     *
     * @return string
     */
    public function __toString();
}

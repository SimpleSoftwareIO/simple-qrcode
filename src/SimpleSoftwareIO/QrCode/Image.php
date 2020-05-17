<?php

namespace SimpleSoftwareIO\QrCode;

class Image
{
    /**
     * Holds the image resource.
     *
     * @var resource
     */
    protected $image;

    /**
     * Creates a new Image object.
     *
     * @param $image string An image string
     */
    public function __construct($image)
    {
        $this->image = imagecreatefromstring($image);
    }

    /*
     * Returns the width of an image
     *
     * @return int
    */
    public function getWidth()
    {
        return imagesx($this->image);
    }

    /*
     * Returns the height of an image
     *
     * @return int
     */
    public function getHeight()
    {
        return imagesy($this->image);
    }

    /**
     * Returns the image string.
     *
     * @return string
     */
    public function getImageResource()
    {
        return $this->image;
    }
}

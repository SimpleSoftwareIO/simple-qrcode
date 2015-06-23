<?php namespace SimpleSoftwareIO\QrCode;
/**
 * Simple Laravel QrCode Generator
 * A simple wrapper for the popular BaconQrCode made for Laravel.
 *
 * @link http://www.simplesoftware.io
 * @author SimpleSoftware support@simplesoftware.io
 *
 */

class Image implements ImageInterface {

    /**
     * Holds the image resource.
     *
     * @var resource
     */
    protected $image;
    /**
     * Creates a new Image object
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
     * Returns the image string
     *
     * @return string
     */
    public function getImageResource()
    {
        return $this->image;
    }
}

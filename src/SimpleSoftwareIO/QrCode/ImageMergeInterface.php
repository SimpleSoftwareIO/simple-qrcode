<?php namespace SimpleSoftwareIO\QrCode;
/**
 * Simple Laravel QrCode Generator
 * A simple wrapper for the popular BaconQrCode made for Laravel.
 *
 * @link http://www.simplesoftware.io
 * @author SimpleSoftware support@simplesoftware.io
 *
 */

interface ImageMergeInterface {

    /**
     * Creates a new ImageMerge object.
     *
     * @param $sourceImage Image The image that will be merged over.
     * @param $mergeImage Image The image that will be used to merge with $sourceImage
     */
    public function __construct(Image $sourceImage, Image $mergeImage);

    /*
     * Returns an QrCode that has been merge with another image.  This is usually used with logos to imprint a logo into a QrCode.
     *
     * @return string
     */
    public function merge($percentage);
}
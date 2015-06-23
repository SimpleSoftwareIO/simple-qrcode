<?php namespace SimpleSoftwareIO\QrCode;
/**
 * Simple Laravel QrCode Generator
 * A simple wrapper for the popular BaconQrCode made for Laravel.
 *
 * @link http://www.simplesoftware.io
 * @author SimpleSoftware support@simplesoftware.io
 *
 */

class ImageMerge implements ImageMergeInterface {

    /**
     * Holds the QrCode Image
     *
     * @var Image $sourceImage
     */
    private $sourceImage;

    /**
     * Holds the Merging Image
     *
     * @var Image $mergeImage
     */
    private $mergeImage;

    /**
     * Creates a new ImageMerge object.
     *
     * @param $sourceImage Image The image that will be merged over.
     * @param $mergeImage Image The image that will be used to merge with $sourceImage
     */
    function __construct(Image $sourceImage, Image $mergeImage)
    {
        $this->sourceImage = $sourceImage;
        $this->mergeImage = $mergeImage;
    }

    /**
     * Returns an QrCode that has been merge with another image.  This is usually used with logos to imprint a logo into a QrCode
     *
     * @return resource
     */
    public function merge()
    {
        // TODO: Implement merge() method.
    }
}

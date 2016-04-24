<?php

namespace SimpleSoftwareIO\QrCode;

interface ImageMergeInterface
{
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

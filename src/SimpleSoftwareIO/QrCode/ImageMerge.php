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
     * Holds the QrCode image
     *
     * @var Image $sourceImage
     */
    protected $sourceImage;

    /**
     * Holds the merging image
     *
     * @var Image $mergeImage
     */
    protected $mergeImage;

    /**
     * The height of the source image
     *
     * @var int
     */
    protected $sourceImageHeight;

    /**
     * The width of the source image
     *
     * @var int
     */
    protected $sourceImageWidth;

    /**
     * The height of the merge image
     *
     * @var int
     */
    protected $mergeImageHeight;

    /**
     * The width of the merge image
     *
     * @var int
     */
    protected $mergeImageWidth;

    /**
     * The height of the merge image after it is merged
     *
     * @var int
     */
    protected $postMergeImageHeight;

    /**
     * The width of the merge image after it is merged
     *
     * @var int
     */
    protected $postMergeImageWidth;

    /**
     * The position that the merge image is placed on top of the source image
     *
     * @var int
     */
    protected $centerY;

    /**
     * The position that the merge image is placed on top of the source image
     *
     * @var int
     */
    protected $centerX;

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
     * Returns an QrCode that has been merge with another image.
     * This is usually used with logos to imprint a logo into a QrCode
     *
     * @return str
     */
    public function merge($percentage)
    {
        $this->setProperties($percentage);

        imagecopyresized(
            $this->sourceImage->getImageResource(),
            $this->mergeImage->getImageResource(),
            $this->centerX,
            $this->centerY,
            0,
            0,
            $this->postMergeImageWidth,
            $this->postMergeImageHeight,
            $this->mergeImageWidth,
            $this->mergeImageHeight
        );

        return $this->createImage();
    }

    /**
     * Creates a PNG Image
     *
     * @return string
     */
    protected function createImage()
    {
        ob_start();
        imagepng($this->sourceImage->getImageResource());
        return ob_get_clean();
    }

    /**
     * Sets the objects properties
     *
     * @param $percentage float The percentage that the merge image should take up.
     */
    protected function setProperties($percentage)
    {
        if ($percentage > 1)  throw new \InvalidArgumentException('$percentage must be less than 1');

        $this->sourceImageHeight = $this->sourceImage->getHeight();
        $this->sourceImageWidth = $this->sourceImage->getWidth();

        $this->mergeImageHeight = $this->mergeImage->getHeight();
        $this->mergeImageWidth = $this->mergeImage->getWidth();

        $this->calculateOverlap($percentage);
        $this->calculateCenter();
    }

    /**
     * Calculates the center of the source Image using the Merge image.
     *
     * @return void
     */
    private function calculateCenter()
    {
        $this->centerY = ($this->sourceImageHeight / 2) - ($this->postMergeImageHeight / 2);
        $this->centerX = ($this->sourceImageWidth / 2) - ($this->postMergeImageHeight / 2);
    }

    /**
     * Calculates the width of the merge image being placed on the source image.
     *
     * @param float $percentage
     * @return void
     */
    private function calculateOverlap($percentage)
    {
        $this->postMergeImageHeight = $this->sourceImageHeight * $percentage;
        $this->postMergeImageWidth = $this->sourceImageWidth * $percentage;
    }
}

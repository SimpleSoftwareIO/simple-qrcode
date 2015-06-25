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
    protected $sourceHeight;

    /**
     * The width of the source image
     *
     * @var int
     */
    protected $sourceWidth;

    /**
     * The height of the merge image
     *
     * @var int
     */
    protected $mergeHeight;

    /**
     * The width of the merge image
     *
     * @var int
     */
    protected $mergeWidth;

    /**
     * The height of the merge image after it is merged
     *
     * @var int
     */
    protected $postMergeHeight;

    /**
     * The width of the merge image after it is merged
     *
     * @var int
     */
    protected $postMergeWidth;

    /**
     * The position that the merge image is placed on top of the source image
     *
     * @var int
     */
    protected $mergePosHeight;

    /**
     * The position that the merge image is placed on top of the source image
     *
     * @var int
     */
    protected $mergePosWidth;

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

        imagecopyresized($this->sourceImage->getImageResource(),
            $this->mergeImage->getImageResource(),
            $this->mergePosWidth,
            $this->mergePosHeight,
            0,
            0,
            $this->postMergeHeight,
            $this->postMergeWidth,
            $this->sourceWidth,
            $this->sourceHeight
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

        $this->sourceHeight = $this->sourceImage->getHeight();
        $this->sourceWidth = $this->sourceImage->getWidth();

        $this->mergeHeight = $this->mergeImage->getHeight();
        $this->mergeWidth = $this->mergeImage->getWidth();

        $this->postMergeHeight = $this->mergeHeight * $percentage;
        $this->postMergeWidth = $this->mergeWidth * $percentage;

        $this->mergePosHeight = ($this->sourceHeight / 2) - ($this->postMergeHeight / 2);
        $this->mergePosWidth = ($this->sourceWidth / 2) - ($this->postMergeHeight / 2);
    }
}

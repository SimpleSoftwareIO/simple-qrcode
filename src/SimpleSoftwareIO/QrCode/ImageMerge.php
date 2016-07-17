<?php

namespace SimpleSoftwareIO\QrCode;

class ImageMerge implements ImageMergeInterface
{
    /**
     * Holds the QrCode image.
     *
     * @var Image
     */
    protected $sourceImage;

    /**
     * Holds the merging image.
     *
     * @var Image
     */
    protected $mergeImage;

    /**
     * The height of the source image.
     *
     * @var int
     */
    protected $sourceImageHeight;

    /**
     * The width of the source image.
     *
     * @var int
     */
    protected $sourceImageWidth;

    /**
     * The height of the merge image.
     *
     * @var int
     */
    protected $mergeImageHeight;

    /**
     * The width of the merge image.
     *
     * @var int
     */
    protected $mergeImageWidth;

    /**
     * The height of the merge image after it is merged.
     *
     * @var int
     */
    protected $postMergeImageHeight;

    /**
     * The width of the merge image after it is merged.
     *
     * @var int
     */
    protected $postMergeImageWidth;

    /**
     * The position that the merge image is placed on top of the source image.
     *
     * @var int
     */
    protected $centerY;

    /**
     * The position that the merge image is placed on top of the source image.
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
    public function __construct(Image $sourceImage, Image $mergeImage)
    {
        $this->sourceImage = $sourceImage;
        $this->mergeImage = $mergeImage;
    }

    /**
     * Returns an QrCode that has been merge with another image.
     * This is usually used with logos to imprint a logo into a QrCode.
     *
     * @param $percentage float The percentage of size relative to the entire QR of the merged image
     *
     * @return string
     */
    public function merge($percentage)
    {
        $this->setProperties($percentage);

        imagecopyresampled(
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
     * Creates a PNG Image.
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
     * Sets the objects properties.
     *
     * @param $percentage float The percentage that the merge image should take up.
     */
    protected function setProperties($percentage)
    {
        if ($percentage > 1) {
            throw new \InvalidArgumentException('$percentage must be less than 1');
        }

        $this->sourceImageHeight = $this->sourceImage->getHeight();
        $this->sourceImageWidth = $this->sourceImage->getWidth();

        $this->mergeImageHeight = $this->mergeImage->getHeight();
        $this->mergeImageWidth = $this->mergeImage->getWidth();

        $this->calculateOverlap($percentage);
        $this->calculateCenter();
    }

    /**
     * Calculates the center of the source Image using the Merge image.
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
     */
    private function calculateOverlap($percentage)
    {
        $this->postMergeImageHeight = $this->sourceImageHeight * $percentage;
        $this->postMergeImageWidth = $this->sourceImageWidth * $percentage;
    }
}

<?php

use SimpleSoftwareIO\QrCode\Image;
use SimpleSoftwareIO\QrCode\ImageMerge;

class ImageMergeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The location to save the testing image.
     *
     * @var string
     */
    protected $testImageSaveLocation;

    /**
     * The location to save the compare image.
     *
     * @var string
     */
    protected $compareTestSaveLocation;

    /**
     * The ImageMerge Object.
     *
     * @var ImageMerge
     */
    protected $testImage;

    /**
     * The location of the test image to use.
     *
     * @var string
     */
    protected $testImagePath;

    public function setUp()
    {
        $this->testImagePath = file_get_contents(dirname(__FILE__).'/Images/simplesoftware-icon-grey-blue.png');
        $this->testImage = new ImageMerge(
            new Image($this->testImagePath),
            new Image($this->testImagePath)
        );

        $this->testImageSaveLocation = dirname(__FILE__).'/testImage.png';
        $this->compareTestSaveLocation = dirname(__FILE__).'/compareImage.png';
    }

    public function tearDown()
    {
        @unlink($this->testImageSaveLocation);
        @unlink($this->compareTestSaveLocation);
    }

    public function test_it_merges_two_images_together_and_centers_it()
    {
        //We know the test image is 512x512
        $source = imagecreatefromstring($this->testImagePath);
        $merge = imagecreatefromstring($this->testImagePath);

        //Create a PNG and place the image in the middle using 20% of the area.
        imagecopyresampled(
            $source,
            $merge,
            204,
            204,
            0,
            0,
            102,
            102,
            512,
            512
        );
        imagepng($source, $this->compareTestSaveLocation);

        $testImage = $this->testImage->merge(.2);
        file_put_contents($this->testImageSaveLocation, $testImage);

        $this->assertEquals(file_get_contents($this->compareTestSaveLocation), file_get_contents($this->testImageSaveLocation));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_it_throws_an_exception_when_percentage_is_greater_than_1()
    {
        $this->testImage->merge(1.1);
    }
}

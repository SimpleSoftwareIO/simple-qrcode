<?php

use PHPUnit\Framework\TestCase;
use SimpleSoftwareIO\QrCode\Image;

class ImageTest extends TestCase
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
     * The path to the image used to test.
     *
     * @var string
     */
    protected $imagePath;

    /**
     * The Image object.
     *
     * @var Image
     */
    protected $image;

    public function setUp()
    {
        $this->imagePath = file_get_contents(dirname(__FILE__).'/Images/simplesoftware-icon-grey-blue.png');
        $this->image = new Image($this->imagePath);

        $this->testImageSaveLocation = dirname(__FILE__).'/testImage.png';
        $this->compareTestSaveLocation = dirname(__FILE__).'/compareImage.png';
    }

    public function tearDown()
    {
        @unlink($this->testImageSaveLocation);
        @unlink($this->compareTestSaveLocation);
    }

    /**
     * Must test that the outputted PNG is the same because you can not compare resources.
     */
    public function test_it_loads_an_image_string_into_a_resource()
    {
        imagepng(imagecreatefromstring($this->imagePath), $this->compareTestSaveLocation);
        imagepng($this->image->getImageResource(), $this->testImageSaveLocation);

        $correctImage = file_get_contents($this->compareTestSaveLocation);
        $testImage = file_get_contents($this->testImageSaveLocation);

        $this->assertEquals($correctImage, $testImage);
    }

    public function test_it_gets_the_correct_height()
    {
        $correctHeight = 512;

        $testHeight = $this->image->getHeight();

        $this->assertEquals($correctHeight, $testHeight);
    }

    public function test_it_gets_the_correct_width()
    {
        $correctWidth = 512;

        $testWidth = $this->image->getWidth();

        $this->assertEquals($correctWidth, $testWidth);
    }
}

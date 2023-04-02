<?php

use PHPUnit\Framework\TestCase;
use SimpleSoftwareIO\QrCode\Generator;

class HexToRgbTest extends TestCase
{
    public function text_hex_code_convert_to_rgb_possible()
    {
        $this->assertInstanceOf(Generator::class, (new Generator)->color('#ff0000'));
        $this->assertInstanceOf(Generator::class, (new Generator)->backgroundColor('#ffffff'));
        $this->assertInstanceOf(Generator::class, (new Generator)->eyeColorFromHex(0, '#ffff00', '#0000ff'));
    }

    public function test_color_is_set()
    {
        $generator = (new Generator)->color('#324B64');
        $this->assertEquals(50, $generator->getFill()->getForegroundColor()->toRgb()->getRed());
        $this->assertEquals(75, $generator->getFill()->getForegroundColor()->toRgb()->getGreen());
        $this->assertEquals(100, $generator->getFill()->getForegroundColor()->toRgb()->getBlue());

        $generator = (new Generator)->color('#324B64', alpha: 25);
//        $this->assertEquals(25, $generator->getFill()->getForegroundColor()->getAlpha());
        $this->assertEquals(50, $generator->getFill()->getForegroundColor()->toRgb()->getRed());
        $this->assertEquals(75, $generator->getFill()->getForegroundColor()->toRgb()->getGreen());
        $this->assertEquals(100, $generator->getFill()->getForegroundColor()->toRgb()->getBlue());

        $generator = (new Generator)->color('#324B64', alpha: 0);
        //$this->assertEquals(0, $generator->getFill()->getForegroundColor()->getAlpha());
        $this->assertEquals(50, $generator->getFill()->getForegroundColor()->toRgb()->getRed());
        $this->assertEquals(75, $generator->getFill()->getForegroundColor()->toRgb()->getGreen());
        $this->assertEquals(100, $generator->getFill()->getForegroundColor()->toRgb()->getBlue());
        $this->markTestIncomplete('This test has not been tested yet.');
    }

    public function test_background_color_is_set()
    {
        $generator = (new Generator)->backgroundColor('#324B64');
        $this->assertEquals(50, $generator->getFill()->getBackgroundColor()->toRgb()->getRed());
        $this->assertEquals(75, $generator->getFill()->getBackgroundColor()->toRgb()->getGreen());
        $this->assertEquals(100, $generator->getFill()->getBackgroundColor()->toRgb()->getBlue());

        $generator = (new Generator)->backgroundColor('#324B64', alpha: 25);
       // $this->assertEquals(25, $generator->getFill()->getBackgroundColor()->getAlpha());
        $this->assertEquals(50, $generator->getFill()->getBackgroundColor()->toRgb()->getRed());
        $this->assertEquals(75, $generator->getFill()->getBackgroundColor()->toRgb()->getGreen());
        $this->assertEquals(100, $generator->getFill()->getBackgroundColor()->toRgb()->getBlue());
        $this->markTestIncomplete('Alpha is not yet tested.');
    }

    public function test_eye_color_is_set()
    {
        $generator = (new Generator)->eyeColorFromHex(0, '#000000', '#fff');
        $generator = $generator->eyeColorFromHex(1, '#000', '#fff');
        $generator = $generator->eyeColorFromHex(2, '#000', '#fff');

        $this->assertEquals(0, $generator->getFill()->getTopLeftEyeFill()->getExternalColor()->getRed());
        $this->assertEquals(0, $generator->getFill()->getTopLeftEyeFill()->getExternalColor()->getGreen());
        $this->assertEquals(0, $generator->getFill()->getTopLeftEyeFill()->getExternalColor()->getBlue());
        $this->assertEquals(255, $generator->getFill()->getTopLeftEyeFill()->getInternalColor()->getRed());
        $this->assertEquals(255, $generator->getFill()->getTopLeftEyeFill()->getInternalColor()->getGreen());
        $this->assertEquals(255, $generator->getFill()->getTopLeftEyeFill()->getInternalColor()->getBlue());

        $this->assertEquals(0, $generator->getFill()->getTopRightEyeFill()->getExternalColor()->getRed());
        $this->assertEquals(0, $generator->getFill()->getTopRightEyeFill()->getExternalColor()->getGreen());
        $this->assertEquals(0, $generator->getFill()->getTopRightEyeFill()->getExternalColor()->getBlue());
        $this->assertEquals(255, $generator->getFill()->getTopRightEyeFill()->getInternalColor()->getRed());
        $this->assertEquals(255, $generator->getFill()->getTopRightEyeFill()->getInternalColor()->getGreen());
        $this->assertEquals(255, $generator->getFill()->getTopRightEyeFill()->getInternalColor()->getBlue());

        $generator = (new Generator)->eyeColor(2, 0, 0, 0, 255, 255, 255);
        $this->assertEquals(0, $generator->getFill()->getBottomLeftEyeFill()->getExternalColor()->getRed());
        $this->assertEquals(0, $generator->getFill()->getBottomLeftEyeFill()->getExternalColor()->getGreen());
        $this->assertEquals(0, $generator->getFill()->getBottomLeftEyeFill()->getExternalColor()->getBlue());
        $this->assertEquals(255, $generator->getFill()->getBottomLeftEyeFill()->getInternalColor()->getRed());
        $this->assertEquals(255, $generator->getFill()->getBottomLeftEyeFill()->getInternalColor()->getGreen());
        $this->assertEquals(255, $generator->getFill()->getBottomLeftEyeFill()->getInternalColor()->getBlue());
    }

    public function test_eye_color_throws_exception_with_number_greater_than_2()
    {
        $this->expectException(InvalidArgumentException::class);
        (new Generator)->eyeColorFromHex(3, '#fff', '#000');
    }

    public function test_eye_color_throws_exception_with_negative_number()
    {
        $this->expectException(InvalidArgumentException::class);
        (new Generator)->eyeColorFromHex(-1, '#fff', '#000');
    }

}

<?php

use BaconQrCode\Renderer\Eye\SimpleCircleEye;
use BaconQrCode\Renderer\Eye\SquareEye;
use BaconQrCode\Renderer\Image\EpsImageBackEnd;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\Module\DotsModule;
use BaconQrCode\Renderer\Module\RoundnessModule;
use BaconQrCode\Renderer\Module\SquareModule;
use BaconQrCode\Renderer\RendererStyle\Gradient;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use PHPUnit\Framework\TestCase;
use SimpleSoftwareIO\QrCode\Generator;

class GeneratorTest extends TestCase
{
    public function test_chaining_is_possible()
    {
        $this->assertInstanceOf(Generator::class, (new Generator)->size(100));
        $this->assertInstanceOf(Generator::class, (new Generator)->format('eps'));
        $this->assertInstanceOf(Generator::class, (new Generator)->color(255, 255, 255));
        $this->assertInstanceOf(Generator::class, (new Generator)->backgroundColor(255, 255, 255));
        $this->assertInstanceOf(Generator::class, (new Generator)->eyeColor(0, 255, 255, 255, 0, 0, 0));
        $this->assertInstanceOf(Generator::class, (new Generator)->gradient(255, 255, 255, 0, 0, 0, 'vertical'));
        $this->assertInstanceOf(Generator::class, (new Generator)->eye('circle'));
        $this->assertInstanceOf(Generator::class, (new Generator)->style('round'));
        $this->assertInstanceOf(Generator::class, (new Generator)->encoding('UTF-8'));
        $this->assertInstanceOf(Generator::class, (new Generator)->errorCorrection('H'));
        $this->assertInstanceOf(Generator::class, (new Generator)->margin(2));
    }

    public function test_size_is_passed_to_the_renderer()
    {
        $generator = (new Generator)->size(100);

        $this->assertEquals(100, $generator->getRendererStyle()->getSize());
    }

    public function test_format_sets_the_image_format()
    {
        // Disabled until GitHub actions config can be updated to pull in imagick
        // $generator = (new Generator)->format('png');
        // $this->assertInstanceOf(ImagickImageBackEnd::class, $generator->getFormatter());

        $generator = (new Generator)->format('svg');
        $this->assertInstanceOf(SvgImageBackEnd::class, $generator->getFormatter());

        $generator = (new Generator)->format('eps');
        $this->assertInstanceOf(EpsImageBackEnd::class, $generator->getFormatter());
    }

    public function test_an_exception_is_thrown_if_an_unsupported_format_is_used()
    {
        $this->expectException(InvalidArgumentException::class);

        (new Generator)->format('foo');
    }

    public function test_color_is_set()
    {
        $generator = (new Generator)->color(50, 75, 100);
        $this->assertEquals(50, $generator->getFill()->getForegroundColor()->toRgb()->getRed());
        $this->assertEquals(75, $generator->getFill()->getForegroundColor()->toRgb()->getGreen());
        $this->assertEquals(100, $generator->getFill()->getForegroundColor()->toRgb()->getBlue());

        $generator = (new Generator)->color(50, 75, 100, 25);
        $this->assertEquals(25, $generator->getFill()->getForegroundColor()->getAlpha());
        $this->assertEquals(50, $generator->getFill()->getForegroundColor()->toRgb()->getRed());
        $this->assertEquals(75, $generator->getFill()->getForegroundColor()->toRgb()->getGreen());
        $this->assertEquals(100, $generator->getFill()->getForegroundColor()->toRgb()->getBlue());

        $generator = (new Generator)->color(50, 75, 100, 0);
        $this->assertEquals(0, $generator->getFill()->getForegroundColor()->getAlpha());
        $this->assertEquals(50, $generator->getFill()->getForegroundColor()->toRgb()->getRed());
        $this->assertEquals(75, $generator->getFill()->getForegroundColor()->toRgb()->getGreen());
        $this->assertEquals(100, $generator->getFill()->getForegroundColor()->toRgb()->getBlue());
    }

    public function test_background_color_is_set()
    {
        $generator = (new Generator)->backgroundColor(50, 75, 100);
        $this->assertEquals(50, $generator->getFill()->getBackgroundColor()->toRgb()->getRed());
        $this->assertEquals(75, $generator->getFill()->getBackgroundColor()->toRgb()->getGreen());
        $this->assertEquals(100, $generator->getFill()->getBackgroundColor()->toRgb()->getBlue());

        $generator = (new Generator)->backgroundColor(50, 75, 100, 25);
        $this->assertEquals(25, $generator->getFill()->getBackgroundColor()->getAlpha());
        $this->assertEquals(50, $generator->getFill()->getBackgroundColor()->toRgb()->getRed());
        $this->assertEquals(75, $generator->getFill()->getBackgroundColor()->toRgb()->getGreen());
        $this->assertEquals(100, $generator->getFill()->getBackgroundColor()->toRgb()->getBlue());
    }

    public function test_eye_color_is_set()
    {
        $generator = (new Generator)->eyeColor(0, 0, 0, 0, 255, 255, 255);
        $generator = $generator->eyeColor(1, 0, 0, 0, 255, 255, 255);
        $generator = $generator->eyeColor(2, 0, 0, 0, 255, 255, 255);

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
        (new Generator)->eyeColor(3, 0, 0, 0, 255, 255, 255);
    }

    public function test_eye_color_throws_exception_with_negative_number()
    {
        $this->expectException(InvalidArgumentException::class);
        (new Generator)->eyeColor(-1, 0, 0, 0, 255, 255, 255);
    }

    public function test_grandient_is_set()
    {
        $generator = (new Generator)->gradient(0, 0, 0, 255, 255, 255, 'vertical');
        $this->assertInstanceOf(Gradient::class, $generator->getFill()->getForegroundGradient());
    }

    public function test_eye_style_is_set()
    {
        $generator = (new Generator)->eye('circle');
        $this->assertInstanceOf(SimpleCircleEye::class, $generator->getEye());

        $generator = (new Generator)->eye('square');
        $this->assertInstanceOf(SquareEye::class, $generator->getEye());
    }

    public function test_invalid_eye_throws_an_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        (new Generator)->eye('foo');
    }

    public function test_style_is_set()
    {
        $generator = (new Generator)->style('square');
        $this->assertInstanceOf(SquareModule::class, $generator->getModule());

        $generator = (new Generator)->style('dot', .1);
        $this->assertInstanceOf(DotsModule::class, $generator->getModule());

        $generator = (new Generator)->style('round', .3);
        $this->assertInstanceOf(RoundnessModule::class, $generator->getModule());
    }

    public function test_an_exception_is_thrown_for_an_invalid_style()
    {
        $this->expectException(InvalidArgumentException::class);
        (new Generator)->style('foo');
    }

    public function test_an_exception_is_thrown_for_a_number_over_1()
    {
        $this->expectException(InvalidArgumentException::class);
        (new Generator)->style('round', 1.1);
    }

    public function test_an_exception_is_thrown_for_a_number_under_0()
    {
        $this->expectException(InvalidArgumentException::class);
        (new Generator)->style('round', -.1);
    }

    public function test_an_exception_is_thrown_for_1()
    {
        $this->expectException(InvalidArgumentException::class);
        (new Generator)->style('round', 1);
    }

    public function test_get_renderer_returns_renderer()
    {
        $this->assertInstanceOf(RendererStyle::class, (new Generator)->getRendererStyle());
    }

    public function test_it_calls_a_valid_dynamic_method_and_generates_a_qrcode()
    {
        $result = (new Generator)->btc('1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa');
        $this->assertEquals("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"100\" height=\"100\" viewBox=\"0 0 100 100\"><rect x=\"0\" y=\"0\" width=\"100\" height=\"100\" fill=\"#ffffff\"/><g transform=\"scale(3.448)\"><g transform=\"translate(0,0)\"><path fill-rule=\"evenodd\" d=\"M8 0L8 1L10 1L10 0ZM15 0L15 1L16 1L16 2L15 2L15 3L14 3L14 2L11 2L11 4L10 4L10 3L9 3L9 2L8 2L8 5L9 5L9 6L8 6L8 7L9 7L9 8L8 8L8 10L6 10L6 9L7 9L7 8L6 8L6 9L5 9L5 10L6 10L6 11L7 11L7 12L6 12L6 13L7 13L7 14L6 14L6 15L5 15L5 14L4 14L4 13L5 13L5 12L4 12L4 13L3 13L3 11L4 11L4 10L3 10L3 9L4 9L4 8L0 8L0 11L1 11L1 12L0 12L0 14L2 14L2 15L1 15L1 16L2 16L2 17L1 17L1 18L0 18L0 19L1 19L1 18L2 18L2 19L3 19L3 20L5 20L5 16L6 16L6 17L7 17L7 18L6 18L6 19L7 19L7 20L6 20L6 21L8 21L8 22L9 22L9 21L10 21L10 23L13 23L13 24L12 24L12 25L11 25L11 24L10 24L10 27L9 27L9 25L8 25L8 29L9 29L9 28L10 28L10 29L11 29L11 28L12 28L12 26L14 26L14 29L16 29L16 28L17 28L17 29L19 29L19 28L20 28L20 29L21 29L21 28L22 28L22 27L23 27L23 29L24 29L24 28L25 28L25 29L26 29L26 28L25 28L25 27L27 27L27 29L28 29L28 27L29 27L29 24L28 24L28 22L29 22L29 19L28 19L28 21L27 21L27 19L26 19L26 18L27 18L27 17L25 17L25 16L26 16L26 15L29 15L29 13L27 13L27 12L26 12L26 13L25 13L25 14L26 14L26 15L24 15L24 14L23 14L23 13L24 13L24 12L25 12L25 11L26 11L26 10L25 10L25 9L27 9L27 11L28 11L28 12L29 12L29 11L28 11L28 10L29 10L29 8L28 8L28 9L27 9L27 8L24 8L24 9L23 9L23 11L22 11L22 12L21 12L21 11L19 11L19 10L21 10L21 9L22 9L22 8L21 8L21 9L20 9L20 7L21 7L21 6L20 6L20 2L19 2L19 5L18 5L18 4L17 4L17 3L16 3L16 2L17 2L17 0ZM19 0L19 1L20 1L20 0ZM12 3L12 5L10 5L10 6L9 6L9 7L10 7L10 8L9 8L9 9L10 9L10 10L8 10L8 12L7 12L7 13L9 13L9 12L10 12L10 13L11 13L11 11L13 11L13 10L14 10L14 12L15 12L15 13L20 13L20 14L21 14L21 16L22 16L22 17L21 17L21 19L22 19L22 20L23 20L23 18L25 18L25 17L24 17L24 15L22 15L22 14L21 14L21 12L18 12L18 11L16 11L16 9L18 9L18 8L19 8L19 7L20 7L20 6L19 6L19 7L18 7L18 5L17 5L17 4L16 4L16 5L14 5L14 6L13 6L13 7L12 7L12 5L13 5L13 3ZM16 5L16 7L15 7L15 6L14 6L14 7L15 7L15 8L14 8L14 10L15 10L15 8L18 8L18 7L17 7L17 5ZM10 6L10 7L11 7L11 8L12 8L12 7L11 7L11 6ZM23 11L23 12L22 12L22 13L23 13L23 12L24 12L24 11ZM1 12L1 13L2 13L2 14L3 14L3 13L2 13L2 12ZM12 12L12 14L8 14L8 15L6 15L6 16L8 16L8 18L7 18L7 19L8 19L8 21L9 21L9 20L10 20L10 21L11 21L11 22L12 22L12 21L11 21L11 20L12 20L12 19L11 19L11 18L12 18L12 17L13 17L13 18L17 18L17 19L16 19L16 20L15 20L15 21L14 21L14 19L13 19L13 23L14 23L14 22L15 22L15 24L14 24L14 26L15 26L15 27L16 27L16 26L17 26L17 28L18 28L18 26L17 26L17 25L20 25L20 22L19 22L19 23L18 23L18 21L17 21L17 19L18 19L18 20L20 20L20 18L18 18L18 17L17 17L17 16L18 16L18 15L19 15L19 14L17 14L17 16L16 16L16 17L15 17L15 15L16 15L16 14L15 14L15 15L14 15L14 13L13 13L13 12ZM26 13L26 14L27 14L27 13ZM12 14L12 16L11 16L11 15L9 15L9 18L8 18L8 19L9 19L9 18L10 18L10 17L12 17L12 16L13 16L13 14ZM3 15L3 17L2 17L2 18L3 18L3 17L4 17L4 15ZM19 16L19 17L20 17L20 16ZM28 16L28 17L29 17L29 16ZM24 19L24 20L25 20L25 19ZM1 20L1 21L2 21L2 20ZM15 21L15 22L16 22L16 23L17 23L17 21ZM21 21L21 24L24 24L24 21ZM22 22L22 23L23 23L23 22ZM25 22L25 23L26 23L26 24L27 24L27 22ZM15 24L15 26L16 26L16 25L17 25L17 24ZM22 25L22 26L23 26L23 25ZM24 25L24 27L25 27L25 26L27 26L27 27L28 27L28 25ZM19 26L19 27L21 27L21 26ZM0 0L0 7L7 7L7 0ZM1 1L1 6L6 6L6 1ZM2 2L2 5L5 5L5 2ZM22 0L22 7L29 7L29 0ZM23 1L23 6L28 6L28 1ZM24 2L24 5L27 5L27 2ZM0 22L0 29L7 29L7 22ZM1 23L1 28L6 28L6 23ZM2 24L2 27L5 27L5 24Z\" fill=\"#000000\"/></g></g></svg>\n", $result);
    }

    public function test_it_throws_an_exception_if_datatype_is_not_found()
    {
        $this->expectException(BadMethodCallException::class);
        (new Generator)->notReal('fooBar');
    }

    public function test_generator_can_return_illuminate_support_htmlstring()
    {
        $this->getMockBuilder(\Illuminate\Support\HtmlString::class)->getMock();
        $this->assertInstanceOf(\Illuminate\Support\HtmlString::class, (new Generator)->generate('fooBar'));
    }
}

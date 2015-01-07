<?php
use Mockery as m;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

/**
 * Simple Laravel QrCode Generator
 * A simple wrapper for the popular BaconQrCode made for Laravel.
 *
 * @link http://www.simplesoftware.io
 * @author SimpleSoftware support@simplesoftware.io
 *
 */

class BaconQrCodeGeneratorTest extends \PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        m::close();
    }

    public function setUp()
    {
        $this->writer = m::mock('\BaconQrCode\Writer');
        $this->format = m::mock('\BaconQrCode\Renderer\Image\RendererInterface');
        $this->qrCode = new BaconQrCodeGenerator($this->writer, $this->format);
    }

    public function testSetMargin()
    {
        $this->format->shouldReceive('setMargin')
            ->with('50')
            ->once();

        $this->writer->shouldReceive('getRenderer')
            ->once()
            ->andReturn($this->format);
        
        $this->qrCode->margin(50);
    }

    public function testSetBackgroundColor()
    {
        $this->format->shouldReceive('setBackgroundColor')
            ->once();

        $this->writer->shouldReceive('getRenderer')
            ->once()
            ->andReturn($this->format);

        $this->qrCode->backgroundColor(255,255,255);
    }

    public function testSetColor()
    {
        $this->format->shouldReceive('setForegroundColor')
            ->once();

        $this->writer->shouldReceive('getRenderer')
            ->once()
            ->andReturn($this->format);

        $this->qrCode->color(255,255,255);
    }

    public function testSetSize()
    {
        $this->format->shouldReceive('setHeight')
            ->with(50)
            ->once();
        $this->format->shouldReceive('setWidth')
            ->with(50)
            ->once();

        $this->writer->shouldReceive('getRenderer')
            ->twice()
            ->andReturn($this->format);

        $this->qrCode->size(50);
    }

    public function testSetFormatPng()
    {
        $this->writer->shouldReceive('setRenderer')
            ->with('BaconQrCode\Renderer\Image\Png')
            ->once();

        $this->qrCode->format('png');
    }

    public function testSetFormatEps()
    {
        $this->writer->shouldReceive('setRenderer')
            ->with('BaconQrCode\Renderer\Image\Eps')
            ->once();

        $this->qrCode->format('eps');
    }

    public function testSetFormatSvg()
    {
        $this->writer->shouldReceive('setRenderer')
            ->with('BaconQrCode\Renderer\Image\Svg')
            ->once();

        $this->qrCode->format('svg');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetFormatUnknown()
    {
        $this->qrCode->format('random');
    }

    public function testGenerate()
    {
        $this->writer->shouldReceive('writeString')
            ->with('qrCode', m::type('string'), m::type('int'))
            ->once();

        $this->qrCode->generate('qrCode');
    }

    public function testGenerateFile()
    {
        $this->writer->shouldReceive('writeFile')
            ->with('qrCode', 'foo.txt', m::type('string'), m::type('int'))
            ->once();

        $this->qrCode->generate('qrCode', 'foo.txt');
    }

    public function test_it_calls_a_valid_dynamic_method_and_generates_a_qrcode()
    {
        $this->writer->shouldReceive('writeString')
            ->once();

        $this->qrCode->phoneNumber('555-555-5555');
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function test_it_throws_an_exception_if_datatype_is_not_found()
    {
        $this->qrCode->notReal('foo');
    }
}
 
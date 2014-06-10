<?php
use Mockery as m;
use SimpleSoftwareIO\QrCode\QrCodeGenerator;

class QrCodeGeneratorTest extends \PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        m::close();
    }

    public function setUp()
    {
        $this->writer = m::mock('\BaconQrCode\Writer');
        $this->format = m::mock('\BaconQrCode\Renderer\Image\RendererInterface');
    }

    public function testSetMargin()
    {
        $this->format->shouldReceive('setMargin')
            ->with('50')
            ->once();

        $this->writer->shouldReceive('getRenderer')
            ->once()
            ->andReturn($this->format);

        $qrCode = new QrCodeGenerator($this->writer, $this->format);
        $qrCode->margin(50);
    }

    public function testSetBackgroundColor()
    {
        $this->format->shouldReceive('setBackgroundColor')
            ->once();

        $this->writer->shouldReceive('getRenderer')
            ->once()
            ->andReturn($this->format);

        $qrCode = new QrCodeGenerator($this->writer, $this->format);
        $qrCode->backgroundColor(255,255,255);
    }

    public function testSetColor()
    {
        $this->format->shouldReceive('setForegroundColor')
            ->once();

        $this->writer->shouldReceive('getRenderer')
            ->once()
            ->andReturn($this->format);

        $qrCode = new QrCodeGenerator($this->writer, $this->format);
        $qrCode->color(255,255,255);
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

        $qrCode = new QrCodeGenerator($this->writer, $this->format);
        $qrCode->size(50);
    }

    public function testSetFormatPng()
    {
        $this->writer->shouldReceive('setRenderer')
            ->with('BaconQrCode\Renderer\Image\Png')
            ->once();

        $qrCode = new QrCodeGenerator($this->writer, $this->format);
        $qrCode->format('png');
    }

    public function testSetFormatEps()
    {
        $this->writer->shouldReceive('setRenderer')
            ->with('BaconQrCode\Renderer\Image\Eps')
            ->once();

        $qrCode = new QrCodeGenerator($this->writer, $this->format);
        $qrCode->format('eps');
    }

    public function testSetFormatSvg()
    {
        $this->writer->shouldReceive('setRenderer')
            ->with('BaconQrCode\Renderer\Image\Svg')
            ->once();

        $qrCode = new QrCodeGenerator($this->writer, $this->format);
        $qrCode->format('svg');
    }

    public function testSetFormatUnknown()
    {
        $this->writer->shouldReceive('setRenderer')
            ->with('BaconQrCode\Renderer\Image\Svg')
            ->once();

        $qrCode = new QrCodeGenerator($this->writer, $this->format);
        $qrCode->format('random');
    }

    public function testGenerate()
    {
        $this->writer->shouldReceive('writeString')
            ->once();

        $qrCode = new QrCodeGenerator($this->writer, $this->format);
        $qrCode->generate('qrCode');
    }

    public function testGenerateFile()
    {
        $this->writer->shouldReceive('writeFile')
            ->once();

        $qrCode = new QrCodeGenerator($this->writer, $this->format);
        $qrCode->generate('qrCode', 'foo.txt');
    }
}
 
<?php

namespace SimpleSoftwareIO\QrCode;

use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Encoder\Encoder;
use BaconQrCode\Renderer\Eye\EyeInterface;
use BaconQrCode\Renderer\Eye\ModuleEye;
use BaconQrCode\Renderer\Eye\SimpleCircleEye;
use BaconQrCode\Renderer\Eye\SquareEye;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Module\DotsModule;
use BaconQrCode\Renderer\Module\ModuleInterface;
use BaconQrCode\Renderer\Module\RoundnessModule;
use BaconQrCode\Renderer\Module\SquareModule;
use BaconQrCode\Renderer\RendererInterface;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use InvalidArgumentException;

class Generator
{
    protected $pixels = 100;

    protected $margin = 0;

    protected $errorCorrection = null;

    protected $encoding = Encoder::DEFAULT_BYTE_MODE_ECODING;

    protected $style = 'square';

    protected $styleSize = null;

    protected $eyeStyle = null;

    public function generate(string $text, string $filename = null)
    {
        $render = $this->getRenderer();

        return $this->getWriter($render)->writeString($text, $this->encoding, $this->errorCorrection);
    }

    public function size(int $pixels): self
    {
        $this->pixels = $pixels;

        return $this;
    }

    public function format(): self
    {
        //png, eps, svg, jpg
        //
    }

    public function color($red, $green, $blue, $alpha): self
    {
    }

    public function backgroundColor($red, $green, $blue, $alpha): self
    {
    }

    public function eyeColor(array $eye1, array $eye2, array $eye3): self
    {
    }

    public function gradient(): self
    {
    }

    public function eye(string $style): self
    {
        if (! in_array($style, ['square', 'circle'])) {
            throw new InvalidArgumentException("\$style must be square or circle. {$style} is not a valid eye style.");
        }

        $this->eyeStyle = $style;

        return $this;
    }

    public function style(string $style, float $size = 0.5): self
    {
        if (! in_array($style, ['square', 'dot', 'round'])) {
            throw new InvalidArgumentException("\$style must be square, dot, or round. {$style} is not a valid  QrCode style.");
        }

        if ($size < 0 || $size >= 1) {
            throw new InvalidArgumentException("\$size must be between 0 and 1.  {$size} is not valid.");
        }

        $this->style = $style;
        $this->styleSize = $size;

        return $this;
    }

    public function encoding(string $encoding): self
    {
        $this->encoding = strtoupper($encoding);

        return $this;
    }

    public function errorCorrection(string $errorCorrection): self
    {
        $errorCorrection = strtoupper($errorCorrection);
        $this->errorCorrection = ErrorCorrectionLevel::$errorCorrection();

        return $this;
    }

    public function margin(int $margin): self
    {
        $this->margin = $margin;

        return $this;
    }

    protected function getWriter(ImageRenderer $renderer): Writer
    {
        return (new Writer($renderer));
    }

    protected function getRenderer(): ImageRenderer
    {
        $renderer = new ImageRenderer(
            new RendererStyle($this->pixels, $this->margin, $this->getModule(), $this->getEye()),
            new SvgImageBackEnd
        );

        return $renderer;
    }

    protected function getModule(): ModuleInterface
    {
        if ($this->style === 'dot') {
            return (new DotsModule($this->styleSize));
        }

        if ($this->style === 'round') {
            return (new RoundnessModule($this->styleSize));
        }

        return SquareModule::instance();
    }

    protected function getEye(): EyeInterface
    {
        if ($this->eyeStyle === 'square') {
            return SquareEye::instance();
        }

        if ($this->eyeStyle === 'circle') {
            return SimpleCircleEye::instance();
        }

        return (new ModuleEye($this->getModule()));
    }
}

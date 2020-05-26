<?php

namespace SimpleSoftwareIO\QrCode;

use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Encoder\Encoder;
use BaconQrCode\Renderer\Color\Alpha;
use BaconQrCode\Renderer\Color\ColorInterface;
use BaconQrCode\Renderer\Color\Rgb;
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
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use InvalidArgumentException;
use BaconQrCode\Renderer\Color\Gray;
use BaconQrCode\Renderer\Image\EpsImageBackEnd;
use BaconQrCode\Renderer\Image\ImageBackEndInterface;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\EyeFill;
use BaconQrCode\Renderer\RendererStyle\Gradient;
use BaconQrCode\Renderer\RendererStyle\GradientType;

class Generator
{
    protected $format = 'svg';

    protected $pixels = 100;

    protected $margin = 0;

    protected $errorCorrection = null;

    protected $encoding = Encoder::DEFAULT_BYTE_MODE_ECODING;

    protected $style = 'square';

    protected $styleSize = null;

    protected $eyeStyle = null;

    protected $color = null;

    protected $backgroundColor = null;

    protected $eyeColors = [];

    protected $gradient;

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

    public function format(string $format): self
    {
        if (! in_array($format, ['svg', 'eps', 'png'])) {
            throw new InvalidArgumentException("\$format must be svg, eps, or png. {$format} is not a valid.");
        }

        $this->format = $format;

        return $this;
    }

    public function color(int $red, int $green, int $blue, ?int $alpha = null): self
    {
        $this->color = $this->createColor($red, $green, $blue, $alpha);

        return $this;
    }

    public function backgroundColor($red, $green, $blue, ?int $alpha = null): self
    {
        $this->backgroundColor = $this->createColor($red, $green, $blue, $alpha);

        return $this;
    }

    public function eyeColor($eyeNumber, array $innerColor, array $outterColor = null): self
    {
        if ($eyeNumber < 0 || $eyeNumber > 2) {
            throw new InvalidArgumentException("\$eyeNumber must be 0, 1, or 2.  {$eyeNumber} is not valid.");
        }

        $this->eyeColors[$eyeNumber] = new EyeFill(new Rgb(...$innerColor), new Rgb(...$outterColor));

        return $this;
    }

    public function gradient(array $startColor, array $endColor, string $type): self
    {
        $type = strtoupper($type);
        $this->gradient = new Gradient($this->createColor(...$startColor), $this->createColor(...$endColor), GradientType::$type());

        return $this;
    }

    public function eye(string $style): self
    {
        if (! in_array($style, ['sqaure', 'circle'])) {
            throw new InvalidArgumentException("\$style must be square or circle. {$style} is not a valid eye style.");
        }

        $this->eyeStyle = $style;

        return $this;
    }

    public function style(string $style, float $size = 0.5): self
    {
        if (! in_array($style, ['square', 'dot', 'round'])) {
            throw new InvalidArgumentException("\$style must be square, dot, or round. {$style} is not a valid.");
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
            new RendererStyle($this->pixels, $this->margin, $this->getModule(), $this->getEye(), $this->getFill()),
            $this->getFormatter()
        );

        return $renderer;
    }

    protected function getFormatter(): ImageBackEndInterface
    {
        if ($this->format === 'png') {
            return new ImagickImageBackEnd('png');
        }

        if ($this->format === 'eps') {
            return new EpsImageBackEnd;
        }

        return new SvgImageBackEnd;
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

    protected function getFill(): Fill
    {
        $foregroundColor = $this->color ?? new Gray(100);
        $backgroundColor = $this->backgroundColor ?? new Gray(0);
        $eye1 = $this->eyeColors[0] ?? EyeFill::uniform(new Gray(0));
        $eye2 = $this->eyeColors[1] ?? EyeFill::uniform(new Gray(0));
        $eye3 = $this->eyeColors[2] ?? EyeFill::uniform(new Gray(0));

        if ($this->gradient) {
            return Fill::withForegroundGradient($foregroundColor, $this->gradient, $eye1, $eye2, $eye3);
        }
        
        return Fill::withForegroundColor($foregroundColor, $backgroundColor, $eye1, $eye2, $eye3);
    }

    protected function createColor(int $red, int $green, int $blue, ?int $alpha = null): ColorInterface
    {
        if (! $alpha) {
            return new Rgb($red, $green, $blue);
        }
        
        return new Alpha($alpha, new Rgb($red, $green, $blue));
    }
}

<?php

namespace SimpleSoftwareIO\QrCode;

use BaconQrCode;
use BaconQrCode\Renderer\Color\Gray;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererInterface;
use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Encoder\Encoder;
use BaconQrCode\Renderer\Color\Alpha;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\Image\EpsImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\EyeFill;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

class BaconQrCodeGenerator implements QrCodeInterface
{
    /**
     * Holds the format.
     *
     * @var SvgImageBackEnd
     */
    protected $format;

    /**
     * Holds the margin value.
     *
     * @var int
     */
    protected $margin = 4;

    /**
     * Holds the size value.
     *
     * @var int
     */
    protected $size = 400;

    /**
     * Holds the foreground color.
     *
     * @var Rgb
     */
    protected $color;

    /**
     * Holds the background color.
     *
     * @var Gray|Rgb|Alpha
     */
    protected $backgroundColor;

    /**
     * Holds the QrCode error correction levels.  This is stored by using the BaconQrCode ErrorCorrectionLevel class constants.
     *
     * @var \BaconQrCode\Common\ErrorCorrectionLevel
     */
    protected $errorCorrection;

    /**
     * Holds the Encoder mode to encode a QrCode.
     *
     * @var string
     */
    protected $encoding = Encoder::DEFAULT_BYTE_MODE_ECODING;

    /**
     * Holds an image string that will be merged with the QrCode.
     *
     * @var null|string
     */
    protected $imageMerge = null;

    /**
     * The percentage that a merged image should take over the source image.
     *
     * @var float
     */
    protected $imagePercentage = .2;

    /**
     * BaconQrCodeGenerator constructor.
     *
     * @param RendererInterface|null $format
     */
    public function __construct()
    {
        $this->format = new SvgImageBackEnd;
        $this->color = new Gray(0);
        $this->backgroundColor = new Gray(100);
        $this->errorCorrection = ErrorCorrectionLevel::L();
    }

    /**
     * Generates a QrCode.
     *
     * @param string $text The text to be converted into a QrCode
     * @param null|string $filename The filename and path to save the QrCode file
     *
     * @return string|void Returns a QrCode string depending on the format, or saves to a file.
     */
    public function generate($text, $filename = null)
    {
        $fill = Fill::withForegroundColor($this->backgroundColor, $this->color, EyeFill::inherit(), EyeFill::inherit(), EyeFill::inherit());
        $this->format->new($this->size, $this->backgroundColor);
        $rendererStyle = new RendererStyle($this->size, $this->margin, null, null, $fill);
        $renderer = new ImageRenderer($rendererStyle, $this->format);
        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($text, $this->encoding, $this->errorCorrection);

        if ($this->imageMerge !== null) {
            $merger = new ImageMerge(new Image($qrCode), new Image($this->imageMerge));
            $qrCode = $merger->merge($this->imagePercentage);
        }

        if ($filename === null) {
            return $qrCode;
        }

        return file_put_contents($filename, $qrCode);
    }

    /**
     * Merges an image with the center of the QrCode.
     *
     * @param $filepath string The filepath to an image
     * @param $percentage float The amount that the merged image should be placed over the qrcode.
     * @param $absolute boolean Whether to use an absolute filepath or not.
     *
     * @return $this
     */
    public function merge($filepath, $percentage = .2, $absolute = false)
    {
        if (function_exists('base_path') && !$absolute) {
            $filepath = base_path() . $filepath;
        }

        $this->imageMerge = file_get_contents($filepath);
        $this->imagePercentage = $percentage;

        return $this;
    }

    /**
     * Merges an image string with the center of the QrCode, does not check for correct format.
     *
     * @param $content string The string contents of an image.
     * @param $percentage float The amount that the merged image should be placed over the qrcode.
     *
     * @return $this
     */
    public function mergeString($content, $percentage = .2)
    {
        $this->imageMerge = $content;
        $this->imagePercentage = $percentage;

        return $this;
    }

    /**
     * Switches the format of the outputted QrCode or defaults to SVG.
     *
     * @param string $format The desired format.
     *
     * @return $this
     * @throws \InvalidArgumentException
     *
     */
    public function format($format)
    {
        switch ($format) {
            case 'png':
                $this->format = new ImagickImageBackEnd;
                break;
            case 'eps':
                $this->format = new EpsImageBackEnd;
                break;
            case 'svg':
                $this->format = new SvgImageBackEnd;
                break;
            default:
                throw new \InvalidArgumentException('Invalid format provided.');
        }

        return $this;
    }

    /**
     * Changes the size of the QrCode.
     *
     * @param int $pixels The size of the QrCode in pixels
     *
     * @return $this
     */
    public function size($pixels)
    {
        $this->size = $pixels;

        return $this;
    }

    /**
     * Changes the foreground color of a QrCode.
     *
     * @param int $red
     * @param int $green
     * @param int $blue
     *
     * @return $this
     */
    public function color($red, $green, $blue)
    {
        $this->color = new Rgb($red, $green, $blue);

        return $this;
    }

    /**
     * Changes the background color of a QrCode.
     *
     * @param int $red
     * @param int $green
     * @param int $blue
     *
     * @return $this
     */
    public function backgroundColor($red, $green, $blue)
    {
        $this->backgroundColor = new Rgb($red, $green, $blue);

        return $this;
    }

    /**
     * Changes the alpha of a QrCode.
     *
     * @param int $alpha
     *
     * @return $this
     */
    public function transparent()
    {
        $this->alpha(0);

        return $this;
    }

    /**
     * Changes the alpha of a QrCode.
     *
     * @param int $alpha
     *
     * @return $this
     */
    public function alpha($alpha)
    {
        $this->backgroundColor = new Alpha($alpha, $this->backgroundColor);

        return $this;
    }

    /**
     * Changes the error correction level of a QrCode.
     *
     * @param string $level Desired error correction level.  L = 7% M = 15% Q = 25% H = 30%
     *
     * @return $this
     */
    public function errorCorrection($level)
    {
        $this->errorCorrection = ErrorCorrectionLevel::$level();

        return $this;
    }

    /**
     * Creates a margin around the QrCode.
     *
     * @param int $margin The desired margin in pixels around the QrCode
     *
     * @return $this
     */
    public function margin($margin)
    {
        $this->margin = $margin;

        return $this;
    }

    /**
     * Sets the Encoding mode.
     *
     * @param string $encoding
     *
     * @return $this
     */
    public function encoding($encoding)
    {
        $this->encoding = $encoding;

        return $this;
    }

    /**
     * Creates a new datatype object and then generates a QrCode.
     *
     * @param $method
     * @param $arguments
     * @return string|void
     */
    public function __call($method, $arguments)
    {
        $dataType = $this->createClass($method);

        $dataType->create($arguments);

        return $this->generate(strval($dataType));
    }

    /**
     * Creates a new DataType class dynamically.
     *
     * @param string $method
     *
     * @return SimpleSoftwareIO\QrCode\DataTypes\DataTypeInterface
     */
    private function createClass($method)
    {
        $class = $this->formatClass($method);

        if (!class_exists($class)) {
            throw new \BadMethodCallException();
        }

        return new $class();
    }

    /**
     * Formats the method name correctly.
     *
     * @param $method
     *
     * @return string
     */
    private function formatClass($method)
    {
        $method = ucfirst($method);

        $class = "SimpleSoftwareIO\QrCode\DataTypes\\" . $method;

        return $class;
    }
}

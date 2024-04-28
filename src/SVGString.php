<?php

namespace BeaconsBay\QrCode;

use SVG\Nodes\Structures\SVGGroup;
use SVG\SVG;

class SVGString
{
    /**
     * Holds the image resource.
     *
     * @var resource
     */
    protected $image;

    /**
     * Creates a new Image object.
     *
     * @param $image string An image string
     */
    public function __construct($image)
    {
        $this->image = SVG::fromString($image);
    }

    private function getdocument()
    {
        return $this->image->getDocument();
    }

    /*
     * Returns the width of an image
     *
     * @return int
    */
    public function getWidth()
    {
        return (int) $this->image->getdocument()->getWidth();
    }

    /*
     * Returns the height of an image
     *
     * @return int
     */
    public function getHeight()
    {
        return (int) $this->image->getdocument()->getHeight();
    }

    /**
     * Returns the image string.
     *
     * @return string
     */
    public function getImageResource()
    {
        return $this->image;
    }


    public function setAttributeSvg(int $centerX, int $centerY, float $percentage)
    {
        return $this->image->getdocument()->getChild(0)->setAttribute('transform', 'translate(' . $centerX . ',' . $centerY . ') scale(' . $percentage . ')');
    }

    public function addChildren(SVGGroup $image)
    {
        $this->image->getdocument()->addChild($image);
        $image = $this->image->toXmlString();
        return $image;
    }
    /**
     * Sets the image string.
     *
     * @param resource $image
     */
    public function setImageResource($image)
    {
        $this->image = $image;
    }
}

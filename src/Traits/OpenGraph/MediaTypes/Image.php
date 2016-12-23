<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Traits\OpenGraph\MediaTypes;

/**
 * Class Image.
 *
 * @package Rugaard\MetaScraper\Traits\OpenGraph\Objects
 */
class Image extends AbstractMediaType
{
    /**
     * Width of image
     *
     * @var int
     */
    protected $width;

    /**
     * Height of image
     *
     * @var int
     */
    protected $height;

    /**
     * Set width of image
     *
     * @param  string $width
     * @return \Rugaard\MetaScraper\Traits\OpenGraph\MediaTypes\Image
     */
    public function setWidth(string $width) : Image
    {
        $this->width = (int) $width;
        return $this;
    }

    /**
     * Get width of image
     *
     * @return int
     */
    public function getWidth() : int
    {
        return (int) $this->width;
    }

    /**
     * Set height of image
     *
     * @param  string $height
     * @return \Rugaard\MetaScraper\Traits\OpenGraph\MediaTypes\Image
     */
    public function setHeight(string $height) : Image
    {
        $this->height = (int) $height;
        return $this;
    }

    /**
     * Get height of image
     *
     * @return int
     */
    public function getHeight() : int
    {
        return (int) $this->height;
    }
}
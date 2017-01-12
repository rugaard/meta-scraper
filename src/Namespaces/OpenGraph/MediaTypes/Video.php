<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Namespaces\OpenGraph\MediaTypes;

/**
 * Class Video.
 *
 * @package Rugaard\MetaScraper\Namespaces\OpenGraph\Objects
 */
class Video extends AbstractMediaType
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
     * @return \Rugaard\MetaScraper\Namespaces\OpenGraph\MediaTypes\Video
     */
    public function setWidth(string $width) : Video
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
     * @return \Rugaard\MetaScraper\Namespaces\OpenGraph\MediaTypes\Video
     */
    public function setHeight(string $height) : Video
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
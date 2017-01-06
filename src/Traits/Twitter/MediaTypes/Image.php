<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Traits\Twitter\MediaTypes;

/**
 * Class Book.
 *
 * @package Rugaard\MetaScraper\Traits\Twitter\MediaTypes
 */
class Image extends AbstractMediaType
{
    /**
     * Description of image (aka. "alt").
     *
     * @var int
     */
    protected $description;

    /**
     * Set description of image (aka. "alt").
     *
     * @param  string $description
     * @return \Rugaard\MetaScraper\Traits\Twitter\MediaTypes\AbstractMediaType
     */
    public function setDescription(string $description) : AbstractMediaType
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description of image (aka. "alt").
     *
     * @return string
     */
    public function getDescription() : string
    {
        return (string) $this->description;
    }
}
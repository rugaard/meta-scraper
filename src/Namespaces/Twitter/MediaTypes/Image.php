<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes;

/**
 * Class Image.
 *
 * @package Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes
 */
class Image extends AbstractMediaType
{
    /**
     * URL of image.
     *
     * @var string
     */
    protected $url;

    /**
     * Description of image (aka. "alt").
     *
     * @var int
     */
    protected $description;


    /**
     * Set URL of image.
     *
     * @param  string $url
     * @return \Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\AbstractMediaType
     */
    public function setUrl(string $url) : AbstractMediaType
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get URL of image.
     *
     * @return string
     */
    public function getUrl() : string
    {
        return (string) $this->url;
    }

    /**
     * Set description of image (aka. "alt").
     *
     * @param  string $description
     * @return \Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\AbstractMediaType
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
<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Traits\OpenGraph\MediaTypes;

use Illuminate\Support\Collection;

/**
 * Class AbstractMediaType.
 *
 * @package Rugaard\MetaScraper\Traits\OpenGraph\Objects
 */
abstract class AbstractMediaType
{
    /**
     * URL of media type
     *
     * @var string
     */
    protected $url;

    /**
     * Secure URL of media type
     *
     * @var string
     */
    protected $secureUrl;

    /**
     * Mime-type of media type
     *
     * @var string
     */
    protected $mimeType;

    /**
     * Set URL of media type
     *
     * @param  string $url
     * @return \Rugaard\MetaScraper\Traits\OpenGraph\MediaTypes\AbstractMediaType
     */
    public function setUrl(string $url) : AbstractMediaType
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get URL of media type
     *
     * @return string
     */
    public function getUrl() : string
    {
        return (string) $this->url;
    }

    /**
     * Set secure URL of media type
     *
     * @param  string $url
     * @return \Rugaard\MetaScraper\Traits\OpenGraph\MediaTypes\AbstractMediaType
     */
    public function setSecureUrl(string $url) : AbstractMediaType
    {
        $this->secureUrl = $url;
        return $this;
    }

    /**
     * Get secure URL of media type
     *
     * @return string
     */
    public function getSecureUrl() : string
    {
        return (string) $this->secureUrl;
    }

    /**
     * Set mime-type of media type
     *
     * @param  string $mimeType
     * @return \Rugaard\MetaScraper\Traits\OpenGraph\MediaTypes\AbstractMediaType
     */
    public function setMimeType(string $mimeType) : AbstractMediaType
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * Get mime-type of media type
     *
     * @return string
     */
    public function getMimeType() : string
    {
        return (string) $this->mimeType;
    }

    /**
     * __get.
     *
     * @param  string $name
     * @return \Rugaard\MetaScraper\Traits\OpenGraph\MediaTypes\AbstractMediaType
     */
    public function __get(string $name) : AbstractMediaType
    {
        if (!method_exists($this, 'get' . ucfirst($name))) {
            die(sprintf('Method [get%s] not found.', ucfirst($name)));
        }

        return call_user_func([$this, sprintf('get%s', ucfirst($name))]);
    }

    /**
     * __set.
     *
     * @param  string $name
     * @param  mixed $value
     * @return \Rugaard\MetaScraper\Traits\OpenGraph\MediaTypes\AbstractMediaType
     */
    public function __set(string $name, $value) : AbstractMediaType
    {
        if (!method_exists($this, 'set' . ucfirst($name))) {
            die(sprintf('Method [set%s] not found.', ucfirst($name)));
        }

        return call_user_func([$this, sprintf('set%s', ucfirst($name))], $value);
    }
}
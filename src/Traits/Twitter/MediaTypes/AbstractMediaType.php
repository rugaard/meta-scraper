<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Traits\Twitter\MediaTypes;

use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;

/**
 * Class AbstractMediaType.
 *
 * @package Rugaard\MetaScraper\Traits\Twitter\Objects
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
     * Set URL of media type
     *
     * @param  string $url
     * @return \Rugaard\MetaScraper\Traits\Twitter\MediaTypes\AbstractMediaType
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
     * __get.
     *
     * @param  string $name
     * @return \Rugaard\MetaScraper\Traits\Twitter\MediaTypes\AbstractMediaType
     * @throws \Rugaard\MetaScraper\Exceptions\MethodNotFoundException
     */
    public function __get(string $name) : AbstractMediaType
    {
        if (!method_exists($this, 'get' . ucfirst($name))) {
            throw new MethodNotFoundException(sprintf('Method [get%s] not found.', ucfirst($name)), 500);
        }

        return call_user_func([$this, sprintf('get%s', ucfirst($name))]);
    }

    /**
     * __set.
     *
     * @param  string $name
     * @param  mixed $value
     * @return \Rugaard\MetaScraper\Traits\Twitter\MediaTypes\AbstractMediaType
     * @throws \Rugaard\MetaScraper\Exceptions\MethodNotFoundException
     */
    public function __set(string $name, $value) : AbstractMediaType
    {
        if (!method_exists($this, 'set' . ucfirst($name))) {
            throw new MethodNotFoundException(sprintf('Method [set%s] not found.', ucfirst($name)), 500);
        }

        return call_user_func([$this, sprintf('set%s', ucfirst($name))], $value);
    }
}
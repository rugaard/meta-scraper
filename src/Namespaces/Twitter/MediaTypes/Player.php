<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes;

/**
 * Class Player.
 *
 * @package Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes
 */
class Player extends AbstractMediaType
{
    /**
     * URL of player.
     *
     * @var string
     */
    protected $url;

    /**
     * Width of player
     *
     * @var int
     */
    protected $width;

    /**
     * Height of player
     *
     * @var int
     */
    protected $height;

    /**
     * URL of video to stream
     *
     * @var string
     */
    protected $videoUrl;

    /**
     * Content-Type of video to stream
     *
     * @var string
     */
    protected $videoType;


    /**
     * Set URL of player.
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
     * Get URL of player.
     *
     * @return string
     */
    public function getUrl() : string
    {
        return (string) $this->url;
    }

    /**
     * Set width of player.
     *
     * @param  string $width
     * @return \Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\Player
     */
    public function setWidth(string $width) : Player
    {
        $this->width = (int) $width;
        return $this;
    }

    /**
     * Get width of player.
     *
     * @return int
     */
    public function getWidth() : int
    {
        return (int) $this->width;
    }

    /**
     * Set height of player.
     *
     * @param string $height
     * @return \Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\Player
     */
    public function setHeight(string $height) : Player
    {
        $this->height = (int) $height;
        return $this;
    }

    /**
     * Get height of player.
     *
     * @return int
     */
    public function getHeight() : int
    {
        return (int) $this->height;
    }

    /**
     * Set URL of video to stream.
     *
     * @param  string $videoUrl
     * @return \Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\Player
     */
    public function setVideoUrl(string $videoUrl) : Player
    {
        $this->videoUrl = $videoUrl;
        return $this;
    }

    /**
     * Get URL of video to stream.
     *
     * @return string
     */
    public function getVideoUrl() : string
    {
        return $this->videoUrl;
    }

    /**
     * Set Content-Type of video to stream.
     *
     * @param  string $videoType
     * @return \Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\Player
     */
    public function setVideoType(string $videoType) : Player
    {
        $this->videoType = $videoType;
        return $this;
    }

    /**
     * Get Content-Type of video to stream.
     *
     * @return string
     */
    public function getVideoType() : string
    {
        return $this->videoType;
    }
}
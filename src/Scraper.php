<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use Illuminate\Support\Collection;
use Rugaard\MetaScraper\Exceptions\NoItemsException;
use Rugaard\MetaScraper\Exceptions\InvalidUrlException;
use Rugaard\MetaScraper\Exceptions\RequestFailedException;
use Rugaard\MetaScraper\Namespaces\Facebook\Facebook;
use Rugaard\MetaScraper\Namespaces\OpenGraph\OpenGraph;
use Rugaard\MetaScraper\Namespaces\Twitter\Twitter;

/**
 * Class Scraper.
 *
 * @package Rugaard\MetaScraper
 */
class Scraper
{
    use Facebook, OpenGraph, Twitter;

    /**
     * Guzzle instance.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * Content received from Guzzle request.
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $content;

    /**
     * Collection of <meta> tags.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $metaTags;

    /**
     * MetaScraper constructor.
     */
    public function __construct()
    {
        // Instantiate a default Guzzle instance
        $this->client = new GuzzleClient;

        // Create an empty collection container
        // which will contain each extracted <meta> tag.
        $this->metaTags = collect();
    }

    /**
     * Request and parse URL.
     *
     * @param  string $url
     * @return \Rugaard\MetaScraper\Scraper
     * @throws \Rugaard\MetaScraper\Exceptions\InvalidUrlException
     * @throws \Rugaard\MetaScraper\Exceptions\RequestFailedException
     */
    public function load(string $url) : Scraper
    {
        // Validate received URL.
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidUrlException(sprintf('Invalid URL provided: %s', $url), 412);
        }

        try {
            // Request URL.
            $this->content = $this->client->get($url);
        } catch (GuzzleRequestException $e) {
            throw new RequestFailedException('Request failed', 400, $e);
        }

        // Extract all <meta> tags from content
        // and add each item to the our <meta> tags collection.
        foreach ($this->extractByTag('meta') as $tag) {
            $this->metaTags->push(new Meta($tag));
        }

        return $this;
    }

    /**
     * Get all parsed meta data.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all() : Collection
    {
        $data = new Collection;

        foreach (class_uses($this) as $trait) {
            $traitName = class_basename($trait);
            $data->put(strtolower($traitName), call_user_func([$this, camel_case($traitName)]));
        }

        return $data;
    }

    /**
     * Get all entries with a specific namespace.
     *
     * @param  string $namespace
     * @return \Illuminate\Support\Collection
     */
    protected function getAllByNamespace($namespace) : Collection
    {
        return $this->getMetaTags()->reject(function($item) use ($namespace) {
            /** @var \Rugaard\MetaScraper\Meta $item  **/
            return !$item->hasNamespace() || $item->getNamespace() != $namespace;
        });
    }

    /**
     * Extract all occurrences of tag from URL
     *
     * @param  string $tag
     * @return array
     * @throws \Rugaard\MetaScraper\Exceptions\NoItemsException
     */
    public function extractByTag(string $tag) : array
    {
        // Extract all tags by expression
        preg_match_all(sprintf('#<%s(.*?)\\/?>#i', $tag), $this->getContentBodyAsString(), $results);
        if (!$results || !count($results[0])) {
            throw new NoItemsException(sprintf('No elements found with tag [%s]', $tag), 204);
        }

        // Container
        $tags = [];

        // Loop through each found tag
        // and extract the attributes
        foreach ($results[1] as $item) {
            $tags[] = $this->extractAttributesFromTag($item);
        }

        return $tags;
    }

    /**
     * Extract attributes from tag.
     *
     * @param  string $string
     * @return array
     * @throws \Rugaard\MetaScraper\Exceptions\NoItemsException
     */
    protected function extractAttributesFromTag(string $string) : array
    {
        // Container.
        $attributes = [];

        // Get all attributes for tag.
        preg_match_all('#([a-zA-Z0-9-]+)=["]{1}([^"]*)#', $string, $results, PREG_SET_ORDER);
        if (!$results) {
            return $attributes;
        }

        // Loop through each found attribute
        // and extract it's value.
        foreach ($results as $attribute) {
            // We're going to group all "data-" attributes
            if (strstr($attribute[1], 'data-') !== false) {
                continue;
            }

            // Parse attribute
            $attributes[$attribute[1]] = $attribute[2];
        }

        return $attributes;
    }

    /**
     * Retrieve content as a string.
     *
     * @return string
     */
    public function getContentBodyAsString() : string
    {
        return (string) $this->content->getBody();
    }

    /**
     * Set Guzzle instance.
     *
     * @param  \GuzzleHttp\ClientInterface $client
     * @return \Rugaard\MetaScraper\Scraper
     */
    public function setClient(GuzzleClientInterface $client) : Scraper
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Get Guzzle instance.
     *
     * @return \GuzzleHttp\ClientInterface
     */
    public function getClient() : GuzzleClientInterface
    {
        return $this->client;
    }

    /**
     * Get collection of extracted <meta> tags.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getMetaTags() : Collection
    {
        return $this->metaTags;
    }
}
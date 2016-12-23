<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface as PsrMessageResponseInterface;
use Rugaard\MetaScraper\Exceptions\NoItemsException;
use Rugaard\MetaScraper\Exceptions\InvalidUrlException;
use Rugaard\MetaScraper\Exceptions\RequestFailedException;
use Rugaard\MetaScraper\Traits\OpenGraph\OpenGraph;

/**
 * Class Scraper.
 *
 * @package Rugaard\MetaScraper
 */
class Scraper
{
    use OpenGraph;

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
     * Get all entries with a specific namespace.
     *
     * @param  string $namespace
     * @return \Illuminate\Support\Collection
     */
    private function getAllByNamespace($namespace) : Collection
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
        // Get all attributes for tag.
        preg_match_all('#([a-zA-Z0-9-]+)=["]{1}([^"]*)#', $string, $results, PREG_SET_ORDER);
        if (!$results) {
            throw new NoItemsException('No attributes found', 204);
        }

        // Container.
        $attributes = [];

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

    /**
     * getDebugContentBody.
     *
     * @return string
     *
    public function getDebugContentBody() : string
    {
        return '
<html>
<head>
    <title>Open Graph testing</title>
    <meta property="og:type" content="article">
    <meta property="og:title" content="This is the Open Graph title">
    <meta property="og:description" content="What a beautiful Open Graph description">
    <meta property="og:url" content="http://shortlinks.dev/admin/links/scrape">
    <meta property="og:site_name" content="Shortlinks!">
    <meta property="og:ttl" content="345600">
    <meta property="og:rich_attachment" content="true">
    <meta property="og:see_also" content="http://shortlinks.dev/admin">
    <meta property="og:updated_time" content="2016-12-06">
    <meta property="og:determiner" content="auto">
    <!-- Locales -->
    <meta property="og:locale" content="da_DK">
    <meta property="og:locale:alternate" content="en_GB">
    <meta property="og:locale:alternate" content="en_US">
    <!-- Restrictions -->
    <meta property="og:restrictions:age" content="18+">
    <meta property="og:restrictions:country:allowed" content="dk">
    <meta property="og:restrictions:country:allowed" content="sv">
    <meta property="og:restrictions:country:allowed" content="no">
    <meta property="og:restrictions:country:disallowed" content="us">
    <meta property="og:restrictions:country:disallowed" content="gb">
    <meta property="og:restrictions:content" content="alcohol">
    <!-- Images -->
    <meta property="og:image" content="http://example.com/opengraph-image1.jpg">
    <meta property="og:image:secure_url" content="https://example.com/opengraph-image1.jpg">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="500">
    <meta property="og:image:height" content="225">
    <meta property="og:image" content="http://example.com/opengraph-image2.jpg">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:secure_url" content="https://example.com/opengraph-image2.jpg">
    <meta property="og:image:url" content="http://example.com/opengraph-image3.jpg">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="600">
    <meta property="og:image" content="http://example.com/opengraph-image4.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="800">
    <meta property="og:image:url" content="http://example.com/opengraph-image5.jpg">
    <meta property="og:image:secure_url" content="https://example.com/opengraph-image5.jpg">
    <meta property="og:image:height" content="600">
    <!-- Videos -->
    <meta property="og:video" content="http://example.com/movie.swf">
    <meta property="og:video:secure_url" content="https://secure.example.com/movie.swf">
    <meta property="og:video:type" content="application/x-shockwave-flash">
    <meta property="og:video:width" content="400">
    <meta property="og:video:height" content="300">
    <meta property="og:video" content="http://example.com/movie.swf">
    <meta property="og:video:secure_url" content="https://secure.example.com/movie.swf">
    <meta property="og:video:type" content="application/x-shockwave-flash">
    <meta property="og:video:url" content="http://example.com/movie.swf">
    <meta property="og:video:width" content="400">
    <meta property="og:video:height" content="300">
    <meta property="og:video" content="http://example.com/movie.swf">
    <meta property="og:video:type" content="application/x-shockwave-flash">
    <meta property="og:video:width" content="400">
    <meta property="og:video:url" content="http://example.com/movie.swf">
    <meta property="og:video:secure_url" content="https://secure.example.com/movie.swf">
    <meta property="og:video:height" content="300">
    <!-- Audio -->
    <meta property="og:audio" content="http://example.com/sound.mp3">
    <meta property="og:audio:secure_url" content="https://secure.example.com/sound.mp3">
    <meta property="og:audio:type" content="audio/mpeg">
    <meta property="og:audio" content="http://example.com/sound.mp3">
    <meta property="og:audio:url" content="http://example.com/sound.mp3">
    <meta property="og:audio:type" content="audio/mpeg">
    <meta property="og:audio" content="http://example.com/sound.mp3">
    <meta property="og:audio:secure_url" content="https://secure.example.com/sound.mp3">
    <!-- Objects -->
    <meta property="video:actor:id" content="http://example.com/actor/1">
    <meta property="video:actor:role" content="The Good Guy">
    <meta property="video:actor:id" content="http://example.com/actor/2">
    <meta property="video:actor:role" content="The Bad Guy">
    <meta property="video:director" content="http://example.com/director/1">
    <meta property="video:director" content="http://example.com/director/2">
    <meta property="video:director" content="http://example.com/director/3">
    <meta property="video:duration" content="123081">
    <meta property="video:release_date" content="2016-12-17T13:05:24">
    <meta property="video:series" content="http://example.com/series">
    <meta property="video:tag" content="funny">
    <meta property="video:tag" content="sports">
    <meta property="video:tag" content="blockbuster">
    <meta property="video:writer" content="http://example.com/writer/1">
    <meta property="video:writer" content="http://example.com/writer/2">
</head>
<body>
    <img src="http://example.com/image1.jpg" alt="Image 1">
    <img src="http://example.com/image2.jpg" alt="Image 2">
    <img src="http://example.com/image3.jpg" alt="Image 3">
</body>
</html>';
    }
    */
}
<?php
declare (strict_types = 1);

namespace Tests;

use ReflectionClass;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler as GuzzleMockHandler;
use GuzzleHttp\HandlerStack as GuzzleHandlerStack;
use PHPUnit\Framework\TestCase;
use Rugaard\MetaScraper\Scraper;

/**
 * Class AbstractTestCase.
 */
abstract class AbstractTestCase extends TestCase
{
    /**
     * Scraper instance
     *
     * @var \Rugaard\MetaScraper\Scraper
     */
    protected $scraper;

    /**
     * Mocked trait object.
     *
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $trait;

    /**
     * Prepare test case.
     *
     * @return void
     */
    public function setUp()
    {
        $this->scraper = new Scraper;
    }

    /**
     * Reset test case.
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->scraper);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param  object &$object
     * @param  string $methodName
     * @param  array  $parameters
     * @return mixed
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Create a Guzzle Client with mocked responses.
     *
     * @param  array $responses
     * @return \GuzzleHttp\Client
     */
    protected function createMockedGuzzleClient(array $responses) : GuzzleClient
    {
        return new GuzzleClient([
            'handler' => GuzzleHandlerStack::create(
                new GuzzleMockHandler($responses)
            )
        ]);
    }

    /**
     * Get a mocked response containing valid <meta> tags.
     *
     * @return string
     */
    protected function getMockedResponse() : string
    {
        return <<<HTML
<html><head>
    <title>Mocked response</title>
    <meta name="description" content="This is a mocked description">
    <meta property="og:title" content="This is an Open Graph title" data-test="true">
    <meta property="og:description" content="This is an Open Graph description">
    <meta property="og:locale" content="da_DK">
    <meta property="og:locale:alternate" content="en_GB">
    <meta property="og:rich_attachment" content="true">
    <meta property="og:updated_time" content="2017-01-01T00:00:00+0000">
    <meta property="og:restrictions:age" content="18+">
    <meta property="og:restrictions:country:allowed" content="dk">
    <meta property="og:restrictions:country:allowed" content="sv">
    <meta property="og:restrictions:country:allowed" content="no">
    <meta property="og:restrictions:country:disallowed" content="us">
    <meta property="og:restrictions:country:disallowed" content="gb">
    <meta property="og:restrictions:content" content="alcohol">
    <meta property="og:image" content="http://example.com/image.jpg">
    <meta property="og:image:secure_url" content="https://example.com/image.jpg">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="600">
    <meta property="og:image:height" content="315">
    <meta property="og:image" content="http://example.com/alternative.jpg">
    <meta property="og:video" content="http://example.com/video.mp4">
    <meta property="og:video:secure_url" content="https://example.com/video.mp4">
    <meta property="og:video:type" content="video/mp4">
    <meta property="og:video:width" content="600">
    <meta property="og:video:height" content="400">
    <meta property="og:video" content="http://example.com/alternative.mp4">
    <meta property="og:audio" content="http://example.com/audio.mp3">
    <meta property="og:audio:secure_url" content="https://example.com/audio.mp3">
    <meta property="og:audio:type" content="audio/mpeg">
    <meta property="og:audio" content="http://example.com/alternative.mp3">
    <meta property="place:location:latitude"  content="55.676098"> 
    <meta property="place:location:longitude" content="12.568337">
    <meta property="fb:app_id" content="1234567890">
    <meta property="fb:admins" content="12345678,87654321,13579,86420">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="This is a Twitter title">
    <meta name="twitter:description" content="This is a Twitter description">
    <meta name="twitter:site" content="@twitter">
    <meta name="twitter:creator" content="@DuGi">
    <meta name="twitter:image" content="https://yoursite.com/example.png">
    <meta name="twitter:image:alt" content="This is an image alt">
    <meta name="twitter:player" content="https://yoursite.com/container.html">
    <meta name="twitter:player:width" content="480">
    <meta name="twitter:player:height" content="480">
    <meta name="twitter:player:stream" content="https://yoursite.com/example.mp4">
    <meta name="twitter:player:stream:content_type" content="video/mp4">
    <meta name="twitter:app:country" content="US">
    <meta name="twitter:app:name:iphone" content="Cannonball">
    <meta name="twitter:app:id:iphone" content="929750075">
    <meta name="twitter:app:url:iphone" content="cannonball://poem/5149e249222f9e600a7540ef">
    <meta name="twitter:app:name:ipad" content="Cannonball">
    <meta name="twitter:app:id:ipad" content="929750075">
    <meta name="twitter:app:url:ipad" content="cannonball://poem/5149e249222f9e600a7540ef">
    <meta name="twitter:app:name:googleplay" content="Cannonball">
    <meta name="twitter:app:id:googleplay" content="io.fabric.samples.cannonball">
    <meta name="twitter:app:url:googleplay" content="http://cannonball.fabric.io/poem/5149e249222f9e600a7540ef">
</head><body></body></html>
HTML;
    }
}
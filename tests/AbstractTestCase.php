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
    <meta property="og:title" content="This is an Open Graph title" data-test="true">
</head><body></body></html>
HTML;
    }
}
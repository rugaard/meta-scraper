<?php
declare (strict_types = 1);

namespace Tests;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use GuzzleHttp\Handler\MockHandler as GuzzleMockHandler;
use GuzzleHttp\HandlerStack as GuzzleHandlerStack;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Support\Collection;
use Rugaard\MetaScraper\Exceptions\InvalidUrlException;
use Rugaard\MetaScraper\Exceptions\NoItemsException;
use Rugaard\MetaScraper\Exceptions\RequestFailedException;

/**
 * Class ScraperTest.
 */
class ScraperTest extends AbstractTestCase
{
    /**
     * Test that scraper's client is implementing Guzzle's ClientInterface.
     *
     * @return void
     */
    public function testClientIsImplementingClientInterface() : void
    {
        $this->assertInstanceOf(GuzzleClientInterface::class, $this->scraper->getClient());
    }

    /**
     * Test meta tags is an empty Collections.
     *
     * @return void
     */
    public function testMetaTagsIsAnEmptyCollection() : void
    {
        $this->assertInstanceOf(Collection::class, $this->scraper->getMetaTags());
        $this->assertTrue($this->scraper->getMetaTags()->isEmpty());
    }

    /**
     * Test that an exception is thrown when providing an invalid URL.
     *
     * @return void
     */
    public function testExceptionOnInvalidUrl() : void
    {
        $this->expectException(InvalidUrlException::class);
        $this->scraper->load('this-is-not-a-url');
    }

    /**
     * Test that an exception is thrown when the Guzzle request fails.
     *
     * @return void
     */
    public function testExceptionOnFailedRequest() : void
    {
        $this->scraper->setClient($this->createMockedGuzzleClient([
            new GuzzleRequestException('Error communicating with server', new GuzzleRequest('GET', '127.0.0.1'))
        ]));

        $this->expectException(RequestFailedException::class);
        $this->scraper->load('http://127.0.0.1');
    }

    /**
     * Test method [extractByTag].
     *
     * @return void
     */
    public function testMethodExtractByTag() : void
    {
        $mockedScraper = $this->createPartialMock(get_class($this->scraper), ['getContentBodyAsString']);
        $mockedScraper->method('getContentBodyAsString')->willReturn($this->getMockedResponse());

        $tags = $this->invokeMethod($mockedScraper, 'extractByTag', ['meta']);

        $this->assertNotEmpty($tags);
        $this->assertEquals([
            ['property' => 'og:title', 'content' => 'This is an Open Graph title']
        ], $tags);
    }

    /**
     * Test that an exception is thrown when method [extractByTag]
     * does not find any matching tags.
     *
     * @return void
     */
    public function testExceptionNoItemsFoundInExtractByTag() : void
    {
        $mockedScraper = $this->createPartialMock(get_class($this->scraper), ['getContentBodyAsString']);
        $mockedScraper->method('getContentBodyAsString')->willReturn($this->getMockedResponse());

        $this->expectException(NoItemsException::class);
        $this->invokeMethod($mockedScraper, 'extractByTag', ['this-is-not-a-valid-tag']);
    }

    /**
     * Test method [extractAttributesByFromTag].
     *
     * @return void
     */
    public function testMethodExtractAttributesFromTag() : void
    {
        $attributes = $this->invokeMethod($this->scraper, 'extractAttributesFromTag', [' property="og:title" content="This is an Open Graph title"']);

        $this->assertNotEmpty($attributes);
        $this->assertEquals([
            'property' => 'og:title',
            'content' => 'This is an Open Graph title'
        ], $attributes);
    }

    /**
     * Test that an exception is thrown when method [extractAttributesFromTag]
     * does not find any attributes from tag.
     *
     * @return void
     */
    public function testExceptionNoItemsFoundInExtractAttributesFromTag() : void
    {
        $this->expectException(NoItemsException::class);
        $this->invokeMethod($this->scraper, 'extractAttributesFromTag', ['']);
    }

    /**
     * Create a Guzzle Client with mocked responses.
     *
     * @param  array $responses
     * @return \GuzzleHttp\Client
     */
    protected function createMockedGuzzleClient(array $responses)
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
    private function getMockedResponse() : string
    {
        return <<<HTML
<html><head>
    <title>Mocked response</title>
    <meta property="og:title" content="This is an Open Graph title">
</head><body></body></html>
HTML;
    }
}
<?php
declare (strict_types = 1);

namespace Tests;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Illuminate\Support\Collection;
use Rugaard\MetaScraper\Exceptions\InvalidUrlException;
use Rugaard\MetaScraper\Exceptions\NoItemsException;
use Rugaard\MetaScraper\Exceptions\RequestFailedException;
use Rugaard\MetaScraper\Meta;

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
    public function testClientIsImplementingClientInterface()
    {
        $this->assertInstanceOf(GuzzleClientInterface::class, $this->scraper->getClient());
    }

    /**
     * Test meta tags is an empty Collections.
     *
     * @return void
     */
    public function testMetaTagsIsAnEmptyCollection()
    {
        $this->assertInstanceOf(Collection::class, $this->scraper->getMetaTags());
        $this->assertTrue($this->scraper->getMetaTags()->isEmpty());
    }

    /**
     * Test that an exception is thrown when providing an invalid URL.
     *
     * @return void
     */
    public function testExceptionOnInvalidUrl()
    {
        $this->expectException(InvalidUrlException::class);
        $this->scraper->load('this-is-not-a-url');
    }

    /**
     * Test that an exception is thrown when the Guzzle request fails.
     *
     * @return void
     */
    public function testExceptionOnFailedRequest()
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
    public function testMethodExtractByTag()
    {
        $mockedScraper = $this->createPartialMock(get_class($this->scraper), ['getContentBodyAsString']);
        $mockedScraper->method('getContentBodyAsString')->willReturn($this->getMockedResponse());

        $tags = $this->invokeMethod($mockedScraper, 'extractByTag', ['meta']);

        $this->assertNotEmpty($tags);
    }

    /**
     * Test that an exception is thrown when method [extractByTag]
     * does not find any matching tags.
     *
     * @return void
     */
    public function testExceptionNoItemsFoundInExtractByTag()
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
    public function testMethodExtractAttributesFromTag()
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
    public function testExceptionNoItemsFoundInExtractAttributesFromTag()
    {
        $this->expectException(NoItemsException::class);
        $this->invokeMethod($this->scraper, 'extractAttributesFromTag', ['']);
    }

    /**
     * Test method [load].
     *
     * @return void
     */
    public function testMethodLoad()
    {
        $this->scraper->setClient($this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], $this->getMockedResponse())
        ]))->load('http://127.0.0.1');

        $this->assertInstanceOf(Collection::class, $this->scraper->getMetaTags());
        $this->assertFalse($this->scraper->getMetaTags()->isEmpty());
        $this->assertInstanceOf(Meta::class, $this->scraper->getMetaTags()->first());
    }

    /**
     * Test method [getAllByNamespace].
     *
     * @return void
     */
    public function testMethodGetAllByNamespace()
    {
        $this->scraper->setClient($this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], $this->getMockedResponse())
        ]))->load('http://127.0.0.1');

        $tags = $attributes = $this->invokeMethod($this->scraper, 'getAllByNamespace', ['og']);

        $this->assertInstanceOf(Collection::class, $tags);
        $this->assertFalse($tags->isEmpty());
        $this->assertInstanceOf(Meta::class, $tags->first());
    }
}
<?php
declare(strict_types=1);

namespace Tests\Namespaces\Twitter\MediaTypes;

use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;
use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;
use Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\Player;
use Tests\Namespaces\Twitter\AbstractTwitterTestCase;

/**
 * Class PlayerTest.
 */
class PlayerTest extends AbstractTwitterTestCase
{
    /**
     * Player instance
     *
     * @var \Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\Player|null
     */
    protected $player;

    /**
     * Test that object is a Player instance.
     *
     * @return void
     */
    public function testIsPlayerInstance()
    {
        $this->assertNotEmpty($this->player);
        $this->assertInstanceOf(Player::class, $this->player);
    }

    /**
     * Test method [getUrl].
     *
     * @return void
     */
    public function testUrl()
    {
        $url = $this->player->getUrl();

        $this->assertNotEmpty($url);
        $this->assertNotFalse(filter_var($url, FILTER_VALIDATE_URL));
        $this->assertEquals('https://example.com/container.html', $url);
    }

    /**
     * Test method [getWidth].
     *
     * @return void
     */
    public function testWidth()
    {
        $width = $this->player->getWidth();

        $this->assertNotEmpty($width);
        $this->assertInternalType('int', $width);
        $this->assertEquals(800, $width);
    }

    /**
     * Test method [getHeight].
     *
     * @return void
     */
    public function testHeight()
    {
        $height = $this->player->getHeight();

        $this->assertNotEmpty($height);
        $this->assertInternalType('int', $height);
        $this->assertEquals(600, $height);
    }

    /**
     * Test method [getStream].
     *
     * @return void
     */
    public function testStream()
    {
        $stream = $this->player->getStream();

        $this->assertNotEmpty($stream);
        $this->assertInternalType('array', $stream);
        $this->assertCount(2, $stream);

        $this->assertArrayHasKey('url', $stream);
        $this->assertNotFalse(filter_var($stream['url'], FILTER_VALIDATE_URL));
        $this->assertEquals('https://example.com/stream.mp4', $stream['url']);

        $this->assertArrayHasKey('type', $stream);
        $this->assertEquals('video/mp4', $stream['type']);
    }

    /**
     * Test magic [__call] method.
     *
     * @return void
     */
    public function testMagicInvalidGetMethod()
    {
        $this->expectException(MethodNotFoundException::class);
        $this->player->callNoneExistingGetMethod();
    }

    /**
     * Test exception is thrown when trying to retrieve
     * a non-existing attribute.
     *
     * @return void
     */
    public function testMagicInvalidAttribute()
    {
        $this->expectException(AttributeNotFoundException::class);
        $this->player->getNonExistingAttribute();
    }

    /**
     * Prepare test case.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $twitterData = $this->invokeMethod($this->scraper, 'getAllByNamespace', ['twitter']);
        $this->invokeMethod($this->trait, 'parseTwitterMedia', [$twitterData]);

        $data = $this->trait->getTwitter();

        $this->player = array_key_exists('player', $data) ? $data['player'] : null;
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
    <meta name="twitter:player" content="https://example.com/container.html">
    <meta name="twitter:player:width" content="800">
    <meta name="twitter:player:height" content="600">
    <meta name="twitter:player:stream" content="https://example.com/stream.mp4">
    <meta name="twitter:player:stream:content_type" content="video/mp4">
</head><body></body></html>
HTML;
    }
}

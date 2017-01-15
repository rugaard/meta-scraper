<?php
declare (strict_types = 1);

namespace Tests\Namespaces\OpenGraph\MediaTypes;

use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;
use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;
use Rugaard\MetaScraper\Namespaces\OpenGraph\MediaTypes\Video;
use Tests\Namespaces\OpenGraph\AbstractOpenGraphTestCase;

/**
 * Class VideoTest.
 */
class VideoTest extends AbstractOpenGraphTestCase
{
    /**
     * Array of videos
     *
     * @var array|null
     */
    protected $videos;

    /**
     * Test that videos is returned as an array.
     *
     * @return void
     */
    public function testIsArrayVideos()
    {
        $this->assertInternalType('array', $this->videos);
        $this->assertCount(2, $this->videos);
    }

    /**
     * Test that object is a Video instance.
     *
     * @return void
     */
    public function testIsVideoInstances()
    {
        foreach ($this->videos as $video) {
            $this->assertNotEmpty($video);
            $this->assertInstanceOf(Video::class, $video);
        }
    }

    /**
     * Test method [getUrl].
     *
     * @return void
     */
    public function testUrl()
    {
        $videoOneUrl = $this->videos[0]->getUrl();
        $this->assertNotFalse(filter_var($videoOneUrl, FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/video.mp4', $videoOneUrl);

        $videoTwoUrl = $this->videos[1]->getUrl();
        $this->assertNotFalse(filter_var($videoTwoUrl, FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/alternative.mp4', $videoTwoUrl);
    }

    /**
     * Test method [getSecureUrl].
     *
     * @return void
     */
    public function testSecureUrl()
    {
        $videoOneSecureUrl = $this->videos[0]->getSecureUrl();
        $this->assertNotFalse(filter_var($videoOneSecureUrl, FILTER_VALIDATE_URL));
        $this->assertEquals('https://example.com/video.mp4', $videoOneSecureUrl);

        $this->expectException(AttributeNotFoundException::class);
        $this->videos[1]->getSecureUrl();
    }

    /**
     * Test method [getMimeType].
     *
     * @return void
     */
    public function testMimeType()
    {
        $videoOneMimeType = $this->videos[0]->getMimeType();
        $this->assertEquals('video/mp4', $videoOneMimeType);

        $this->expectException(AttributeNotFoundException::class);
        $this->videos[1]->getMimeType();
    }

    /**
     * Test method [getWidth].
     *
     * @return void
     */
    public function testWidth()
    {
        $videoOneWidth = $this->videos[0]->getWidth();
        $this->assertInternalType('int', $videoOneWidth);
        $this->assertEquals(600, $videoOneWidth);

        $this->expectException(AttributeNotFoundException::class);
        $this->videos[1]->getWidth();
    }

    /**
     * Test method [getHeight].
     *
     * @return void
     */
    public function testHeight()
    {
        $videoOneHeight = $this->videos[0]->getHeight();
        $this->assertInternalType('int', $videoOneHeight);
        $this->assertEquals(400, $videoOneHeight);

        $this->expectException(AttributeNotFoundException::class);
        $this->videos[1]->getHeight();
    }

    /**
     * Test magic [__call] method.
     *
     * @return void
     */
    public function testMagicInvalidGetMethod()
    {
        $this->expectException(MethodNotFoundException::class);

        foreach ($this->videos as $video) {
            $video->callNoneExistingGetMethod();
        }
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

        foreach ($this->videos as $video) {
            $video->getNonExistingAttribute();
        }
    }

    /**
     * Prepare test case.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $openGraphData = $this->invokeMethod($this->scraper, 'getAllByNamespace', ['og']);
        $this->invokeMethod($this->trait, 'parseOpenGraphMedia', [$openGraphData]);

        $data = $this->trait->getOpenGraph();

        $this->videos = array_key_exists('video', $data) ? $data['video'] : null;
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
    <meta property="og:video" content="http://example.com/video.mp4">
    <meta property="og:video:secure_url" content="https://example.com/video.mp4">
    <meta property="og:video:type" content="video/mp4">
    <meta property="og:video:width" content="600">
    <meta property="og:video:height" content="400">
    <meta property="og:video" content="http://example.com/alternative.mp4">
</head><body></body></html>
HTML;
    }
}
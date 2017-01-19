<?php
declare(strict_types=1);

namespace Tests\Namespaces\OpenGraph\Objects;

use DateTime;
use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;
use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;
use Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Music;
use Tests\Namespaces\OpenGraph\AbstractOpenGraphTestCase;

/**
 * Class MusicTest.
 */
class MusicTest extends AbstractOpenGraphTestCase
{
    /**
     * Music instance
     *
     * @var \Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Music|null
     */
    protected $music;

    /**
     * Test that object is a Music instance.
     *
     * @return void
     */
    public function testIsMusicInstance()
    {
        $this->assertNotEmpty($this->music);
        $this->assertInstanceOf(Music::class, $this->music);
    }

    /**
     * Test method [getAlbum].
     *
     * @return void
     */
    public function testAlbum()
    {
        $album = $this->music->getAlbum();

        $this->assertNotEmpty($album);
        $this->assertInternalType('array', $album);
        $this->assertCount(2, $album);

        $this->assertNotFalse(filter_var($album[0]['url'], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/album-1', $album[0]['url']);
        $this->assertInternalType('int', $album[0]['disc']);
        $this->assertEquals(1, $album[0]['disc']);
        $this->assertInternalType('int', $album[0]['track']);
        $this->assertEquals(7, $album[0]['track']);

        $this->assertNotFalse(filter_var($album[1]['url'], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/album-2', $album[1]['url']);
        $this->assertInternalType('int', $album[1]['disc']);
        $this->assertEquals(1, $album[1]['disc']);
        $this->assertInternalType('int', $album[1]['track']);
        $this->assertEquals(28, $album[1]['track']);
    }

    /**
     * Test method [getCreator].
     *
     * @return void
     */
    public function testCreator()
    {
        $creator = $this->music->getCreator();

        $this->assertNotEmpty($creator);
        $this->assertNotFalse(filter_var($creator, FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/creator', $creator);
    }

    /**
     * Test method [getDuration].
     *
     * @return void
     */
    public function testDuration()
    {
        $duration = $this->music->getDuration();

        $this->assertNotEmpty($duration);
        $this->assertInternalType('int', $duration);
        $this->assertEquals(208, $duration);
    }

    /**
     * Test method [getIsrc].
     *
     * @return void
     */
    public function testIsrc()
    {
        $isrc = $this->music->getIsrc();

        $this->assertNotEmpty($isrc);
        $this->assertNotFalse(filter_var($isrc, FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/isrc', $isrc);
    }

    /**
     * Test method [getMusician].
     *
     * @return void
     */
    public function testMusicians()
    {
        $musician = $this->music->getMusician();

        $this->assertNotEmpty($musician);
        $this->assertInternalType('array', $musician);
        $this->assertCount(2, $musician);

        $this->assertNotFalse(filter_var($musician[0], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/musician-1', $musician[0]);

        $this->assertNotFalse(filter_var($musician[1], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/musician-2', $musician[1]);
    }

    /**
     * Test method [getPreviewUrl].
     *
     * @return void
     */
    public function testPreviewUrls()
    {
        $previewUrl = $this->music->getPreviewUrl();

        $this->assertNotEmpty($previewUrl);
        $this->assertInternalType('array', $previewUrl);
        $this->assertCount(2, $previewUrl);

        $this->assertNotFalse(filter_var($previewUrl[0]['url'], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/preview-url-1', $previewUrl[0]['url']);
        $this->assertNotFalse(filter_var($previewUrl[0]['secure_url'], FILTER_VALIDATE_URL));
        $this->assertEquals('https://example.com/preview-url-1', $previewUrl[0]['secure_url']);
        $this->assertEquals('audio/mpeg', $previewUrl[0]['type']);

        $this->assertNotFalse(filter_var($previewUrl[1]['url'], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/preview-url-2', $previewUrl[1]['url']);
        $this->assertNotFalse(filter_var($previewUrl[1]['secure_url'], FILTER_VALIDATE_URL));
        $this->assertEquals('https://example.com/preview-url-2', $previewUrl[1]['secure_url']);
        $this->assertEquals('audio/mpeg', $previewUrl[1]['type']);
    }

    /**
     * Test method [getReleaseDate].
     *
     * @return void
     */
    public function testReleaseDate()
    {
        $releaseDate = $this->music->getReleaseDate();

        $this->assertNotEmpty($releaseDate);
        $this->assertInstanceOf(DateTime::class, $releaseDate);
        $this->assertEquals('2017-01-01T00:00:00+00:00', $releaseDate->format(DATE_W3C));
    }

    /**
     * Test method [getReleaseType].
     *
     * @return void
     */
    public function testReleaseType()
    {
        $releaseType = $this->music->getReleaseType();

        $this->assertNotEmpty($releaseType);
        $this->assertEquals('original_release', $releaseType);
    }

    /**
     * Test method [getSong].
     *
     * @return void
     */
    public function testSongs()
    {
        $song = $this->music->getSong();

        $this->assertNotEmpty($song);
        $this->assertInternalType('array', $song);
        $this->assertCount(2, $song);

        $this->assertNotFalse(filter_var($song[0]['url'], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/song-1', $song[0]['url']);
        $this->assertInternalType('int', $song[0]['disc']);
        $this->assertEquals(1, $song[0]['disc']);
        $this->assertInternalType('int', $song[0]['track']);
        $this->assertEquals(1, $song[0]['track']);

        $this->assertNotFalse(filter_var($song[1]['url'], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/song-2', $song[1]['url']);
        $this->assertInternalType('int', $song[1]['disc']);
        $this->assertEquals(1, $song[1]['disc']);
        $this->assertInternalType('int', $song[1]['track']);
        $this->assertEquals(2, $song[1]['track']);
    }

    /**
     * Test method [getSongCount].
     *
     * @return void
     */
    public function testSongCount()
    {
        $songCount = $this->music->getSongCount();

        $this->assertNotEmpty($songCount);
        $this->assertInternalType('int', $songCount);
        $this->assertEquals(7, $songCount);
    }

    /**
     * Test magic [__call] method.
     *
     * @return void
     */
    public function testMagicInvalidGetMethod()
    {
        $this->expectException(MethodNotFoundException::class);
        $this->music->callNoneExistingGetMethod();
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
        $this->music->getNonExistingAttribute();
    }

    /**
     * Prepare test case.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->invokeMethod($this->trait, 'parseOpenGraphObjects', []);

        $data = $this->trait->getOpenGraph();

        $this->music = array_key_exists('music', $data['objects']) ? $data['objects']['music'] : null;
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
    <meta property="music:album:url" content="http://example.com/album-1">
    <meta property="music:album:disc" content="1">
    <meta property="music:album:track" content="7">
    <meta property="music:album:url" content="http://example.com/album-2">
    <meta property="music:album:disc" content="1">
    <meta property="music:album:track" content="28">
    <meta property="music:creator" content="http://example.com/creator">
    <meta property="music:duration" content="208">
    <meta property="music:isrc" content="http://example.com/isrc">
    <meta property="music:musician" content="http://example.com/musician-1">
    <meta property="music:musician" content="http://example.com/musician-2">
    <meta property="music:preview_url:url" content="http://example.com/preview-url-1">
    <meta property="music:preview_url:secure_url" content="https://example.com/preview-url-1">
    <meta property="music:preview_url:type" content="audio/mpeg">
    <meta property="music:preview_url:url" content="http://example.com/preview-url-2">
    <meta property="music:preview_url:secure_url" content="https://example.com/preview-url-2">
    <meta property="music:preview_url:type" content="audio/mpeg">
    <meta property="music:release_date" content="2017-01-01T00:00:00+00:00">
    <meta property="music:release_type" content="original_release">
    <meta property="music:song:url" content="http://example.com/song-1">
    <meta property="music:song:disc" content="1">
    <meta property="music:song:track" content="1">
    <meta property="music:song:url" content="http://example.com/song-2">
    <meta property="music:song:disc" content="1">
    <meta property="music:song:track" content="2">
    <meta property="music:song_count" content="7">
</head><body></body></html>
HTML;
    }
}

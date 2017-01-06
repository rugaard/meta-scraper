<?php
declare (strict_types = 1);

namespace Tests\Traits\OpenGraph\Objects;

use DateTime;
use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;
use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;
use Rugaard\MetaScraper\Traits\OpenGraph\Objects\Video;

/**
 * Class VideoTest.
 */
class VideoTest extends AbstractObjectTestCase
{
    /**
     * Video instance
     *
     * @var \Rugaard\MetaScraper\Traits\OpenGraph\Objects\Video|null
     */
    protected $video;

    /**
     * Test that object is a Video instance.
     *
     * @return void
     */
    public function testIsVideoInstance()
    {
        $this->assertNotEmpty($this->video);
        $this->assertInstanceOf(Video::class, $this->video);
    }

    /**
     * Test method [getActor].
     *
     * @return void
     */
    public function testActors()
    {
        $actor = $this->video->getActor();

        $this->assertNotEmpty($actor);
        $this->assertInternalType('array', $actor);
        $this->assertCount(2, $actor);

        $this->assertArrayHasKey('id', $actor[0]);
        $this->assertNotFalse(filter_var($actor[0]['id'], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/actor-1', $actor[0]['id']);
        $this->assertArrayHasKey('role', $actor[0]);
        $this->assertEquals('John Doe', $actor[0]['role']);

        $this->assertArrayHasKey('id', $actor[1]);
        $this->assertNotFalse(filter_var($actor[1]['id'], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/actor-2', $actor[1]['id']);
        $this->assertArrayHasKey('role', $actor[1]);
        $this->assertEquals('Jane Doe', $actor[1]['role']);
    }

    /**
     * Test method [getDirector].
     *
     * @return void
     */
    public function testDirectors()
    {
        $director = $this->video->getDirector();

        $this->assertNotEmpty($director);
        $this->assertInternalType('array', $director);
        $this->assertCount(2, $director);

        $this->assertNotFalse(filter_var($director[0], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/director-1', $director[0]);

        $this->assertNotFalse(filter_var($director[1], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/director-2', $director[1]);
    }

    /**
     * Test method [getDuration].
     *
     * @return void
     */
    public function testDuration()
    {
        $duration = $this->video->getDuration();

        $this->assertNotEmpty($duration);
        $this->assertInternalType('int', $duration);
        $this->assertEquals(2640, $duration);
    }

    /**
     * Test method [getReleaseDate].
     *
     * @return void
     */
    public function testReleaseDate()
    {
        $releaseDate = $this->video->getReleaseDate();

        $this->assertNotEmpty($releaseDate);
        $this->assertInstanceOf(DateTime::class, $releaseDate);
        $this->assertEquals('2017-01-01T00:00:00+00:00', $releaseDate->format(DATE_W3C));
    }

    /**
     * Test method [getSeries].
     *
     * @return void
     */
    public function testSeries()
    {
        $series = $this->video->getSeries();

        $this->assertNotEmpty($series);
        $this->assertNotFalse(filter_var($series, FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/series', $series);
    }

    /**
     * Test method [getTag].
     *
     * @return void
     */
    public function testTags()
    {
        $tag = $this->video->getTag();

        $this->assertNotEmpty($tag);
        $this->assertInternalType('array', $tag);
        $this->assertCount(2, $tag);

        $this->assertEquals('programming', $tag[0]);
        $this->assertEquals('unit-testing', $tag[1]);
    }

    /**
     * Test method [getWriter].
     *
     * @return void
     */
    public function testWriters()
    {
        $writer = $this->video->getWriter();

        $this->assertNotEmpty($writer);
        $this->assertInternalType('array', $writer);
        $this->assertCount(2, $writer);

        $this->assertNotFalse(filter_var($writer[0], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/writer-1', $writer[0]);

        $this->assertNotFalse(filter_var($writer[1], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/writer-2', $writer[1]);
    }

    /**
     * Test magic [__call] method.
     *
     * @return void
     */
    public function testMagicInvalidGetMethod()
    {
        $this->expectException(MethodNotFoundException::class);
        $this->video->callNoneExistingGetMethod();
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
        $this->video->getNonExistingAttribute();
    }

    /**
     * Prepare test case.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $data = $this->trait->getOpenGraph();

        $this->video = array_key_exists('video', $data['objects']) ? $data['objects']['video'] : null;
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
    <meta property="video:actor:id" content="http://example.com/actor-1">
    <meta property="video:actor:role" content="John Doe">
    <meta property="video:actor:id" content="http://example.com/actor-2">
    <meta property="video:actor:role" content="Jane Doe">
    <meta property="video:director" content="http://example.com/director-1">
    <meta property="video:director" content="http://example.com/director-2">
    <meta property="video:duration" content="2640">
    <meta property="video:release_date" content="2017-01-01T00:00:00+00:00">
    <meta property="video:series" content="http://example.com/series">
    <meta property="video:tag" content="programming">
    <meta property="video:tag" content="unit-testing">
    <meta property="video:writer" content="http://example.com/writer-1">
    <meta property="video:writer" content="http://example.com/writer-2">
</head><body></body></html>
HTML;
    }
}
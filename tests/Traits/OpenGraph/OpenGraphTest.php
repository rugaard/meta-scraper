<?php
declare (strict_types = 1);

namespace Tests\Traits\OpenGraph;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Illuminate\Support\Collection;
use Rugaard\MetaScraper\Traits\OpenGraph\OpenGraph;
use Tests\AbstractTestCase;

/**
 * Class OpenGraphTest.
 */
class OpenGraphTest extends AbstractTestCase
{
    /**
     * Mocked trait object.
     *
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $trait;

    /**
     * Test method [openGraph].
     *
     * @return void
     */
    public function testOpenGraph()
    {
        $mockedTrait = $this->createPartialMock(get_class($this->trait), ['getAllByNamespace']);
        $mockedTrait->method('getAllByNamespace')->will($this->returnCallback(function ($namespace) {
            return $this->invokeMethod($this->scraper, 'getAllByNamespace', [$namespace]);
        }));

        $data = $mockedTrait->openGraph();

        $this->assertNotEmpty($data);
        $this->assertArrayHasKey('title', $data);
        $this->assertArrayHasKey('description', $data);
        $this->assertArrayHasKey('locale', $data);
        $this->assertArrayHasKey('restrictions', $data);
        $this->assertArrayHasKey('image', $data);
        $this->assertArrayHasKey('video', $data);
        $this->assertArrayHasKey('audio', $data);
        $this->assertArrayHasKey('objects', $data);
    }

    /**
     * Test method [parseOpenGraphStandard].
     *
     * @return void
     */
    public function testParseOpenGraphStandard()
    {
        $openGraphData = $this->invokeMethod($this->scraper, 'getAllByNamespace', ['og']);
        $this->invokeMethod($this->trait, 'parseOpenGraphStandard', [$openGraphData]);

        $data = $this->trait->getOpenGraph();

        $this->assertNotEmpty($data);
        $this->assertArrayHasKey('title', $data);
        $this->assertArrayHasKey('description', $data);
        $this->assertArraySubset(['locale' => ['da_DK', 'en_GB']], $data);
        $this->assertArraySubset(['restrictions' => [
            'age' => '18+',
            'country_allowed' => ['dk', 'sv', 'no'],
            'country_disallowed' => ['us', 'gb'],
            'content' => 'alcohol',
        ]], $data);
    }

    /**
     * Test method [parseOpenGraphMedia].
     *
     * @return void
     */
    public function testParseOpenGraphMedia()
    {
        $openGraphData = $this->invokeMethod($this->scraper, 'getAllByNamespace', ['og']);
        $this->invokeMethod($this->trait, 'parseOpenGraphMedia', [$openGraphData]);

        $data = $this->trait->getOpenGraph();

        $this->assertNotEmpty($data);

        $this->assertArrayHasKey('image', $data);
        $this->assertEquals('http://example.com/image.jpg', $data['image'][0]->getUrl());
        $this->assertEquals('https://example.com/image.jpg', $data['image'][0]->getSecureUrl());
        $this->assertEquals('image/jpeg', $data['image'][0]->getMimeType());
        $this->assertEquals(600, $data['image'][0]->getWidth());
        $this->assertEquals(315, $data['image'][0]->getHeight());
        $this->assertEquals('http://example.com/alternative.jpg', $data['image'][1]->getUrl());

        $this->assertArrayHasKey('video', $data);
        $this->assertEquals('http://example.com/video.mp4', $data['video'][0]->getUrl());
        $this->assertEquals('https://example.com/video.mp4', $data['video'][0]->getSecureUrl());
        $this->assertEquals('video/mpeg', $data['video'][0]->getMimeType());
        $this->assertEquals(600, $data['video'][0]->getWidth());
        $this->assertEquals(400, $data['video'][0]->getHeight());
        $this->assertEquals('http://example.com/alternative.mp4', $data['video'][1]->getUrl());

        $this->assertArrayHasKey('audio', $data);
        $this->assertEquals('http://example.com/audio.mp3', $data['audio'][0]->getUrl());
        $this->assertEquals('https://example.com/audio.mp3', $data['audio'][0]->getSecureUrl());
        $this->assertEquals('audio/mpeg', $data['audio'][0]->getMimeType());
        $this->assertEquals('http://example.com/alternative.mp3', $data['audio'][1]->getUrl());
    }

    /**
     * Test method [parseOpenGraphMedia] can handle an empty Collection.
     *
     * @return void
     */
    public function testParseOpenGraphMediaIsEmpty()
    {
        $this->invokeMethod($this->trait, 'parseOpenGraphMedia', [new Collection]);

        $data = $this->trait->getOpenGraph();

        $this->assertEmpty($data);
    }

    /**
     * Prepare test case.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->trait = $this->getMockForTrait(OpenGraph::class);

        $this->scraper->setClient($this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], $this->getMockedResponse())
        ]))->load('http://127.0.0.1');
    }

    /**
     * Reset test case.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        unset($this->trait);
    }
}
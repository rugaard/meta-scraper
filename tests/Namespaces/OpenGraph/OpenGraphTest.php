<?php
declare (strict_types = 1);

namespace Tests\Namespaces\OpenGraph;

use Illuminate\Support\Collection;

/**
 * Class OpenGraphTest.
 */
class OpenGraphTest extends AbstractOpenGraphTestCase
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
        $data = $this->trait->openGraph();

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
     *
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
        $this->assertEquals('video/mp4', $data['video'][0]->getMimeType());
        $this->assertEquals(600, $data['video'][0]->getWidth());
        $this->assertEquals(400, $data['video'][0]->getHeight());
        $this->assertEquals('http://example.com/alternative.mp4', $data['video'][1]->getUrl());

        $this->assertArrayHasKey('audio', $data);
        $this->assertEquals('http://example.com/audio.mp3', $data['audio'][0]->getUrl());
        $this->assertEquals('https://example.com/audio.mp3', $data['audio'][0]->getSecureUrl());
        $this->assertEquals('audio/mpeg', $data['audio'][0]->getMimeType());
        $this->assertEquals('http://example.com/alternative.mp3', $data['audio'][1]->getUrl());
    }
     */

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
}
<?php
declare (strict_types = 1);

namespace Tests\Traits\Twitter;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Illuminate\Support\Collection;
use Rugaard\MetaScraper\Traits\Twitter\Twitter;
use Tests\AbstractTestCase;

/**
 * Class TwitterTest.
 */
class TwitterTest extends AbstractTestCase
{
    /**
     * Mocked trait object.
     *
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $trait;

    /**
     * Test method [twitter].
     *
     * @return void
     */
    public function testTwitter()
    {
        $data = $this->trait->twitter();

        $this->assertNotEmpty($data);
        $this->assertArrayHasKey('title', $data);
        $this->assertArrayHasKey('description', $data);
        $this->assertArrayHasKey('card', $data);
        $this->assertArrayHasKey('site', $data);
        $this->assertArrayHasKey('creator', $data);
    }

    /**
     * Test method [parseTwitterStandard].
     *
     * @return void
     */
    public function testParseTwitterStandard()
    {
        $openGraphData = $this->invokeMethod($this->scraper, 'getAllByNamespace', ['twitter']);
        $this->invokeMethod($this->trait, 'parseTwitterStandard', [$openGraphData]);

        $data = $this->trait->getTwitter();

        $this->assertNotEmpty($data);
        $this->assertInternalType('array', $data);
        $this->assertCount(5, $data);

        $this->assertArrayHasKey('title', $data);
        $this->assertEquals('This is a Twitter title', $data['title']);

        $this->assertArrayHasKey('description', $data);
        $this->assertEquals('This is a Twitter description', $data['description']);

        $this->assertArrayHasKey('card', $data);
        $this->assertEquals('summary', $data['card']);

        $this->assertArrayHasKey('site', $data);
        $this->assertEquals('@twitter', $data['site']);

        $this->assertArrayHasKey('creator', $data);
        $this->assertEquals('@DuGi', $data['creator']);
    }

    /**
     * Test method [parseTwitterStandard] can handle an empty Collection.
     *
     * @return void
     */
    public function testParseTwitterStandardIsEmpty()
    {
        $this->invokeMethod($this->trait, 'parseTwitterStandard', [new Collection]);

        $data = $this->trait->getTwitter();

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

        $this->trait = $this->createPartialMock(get_class($this->getMockForTrait(Twitter::class)), ['getAllByNamespace']);
        $this->trait->method('getAllByNamespace')->will($this->returnCallback(function ($namespace) {
            return $this->invokeMethod($this->scraper, 'getAllByNamespace', [$namespace]);
        }));

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
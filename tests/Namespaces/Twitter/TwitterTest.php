<?php
declare(strict_types=1);

namespace Tests\Namespaces\Twitter;

use Illuminate\Support\Collection;

/**
 * Class TwitterTest.
 */
class TwitterTest extends AbstractTwitterTestCase
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
     * Test method [parseTwitterMediaTypes] can handle an empty Collection.
     *
     * @return void
     */
    public function testParseTwitterMediaTypesIsEmpty()
    {
        $this->invokeMethod($this->trait, 'parseTwitterMedia', [new Collection]);

        $data = $this->trait->getTwitter();

        $this->assertEmpty($data);
    }
}

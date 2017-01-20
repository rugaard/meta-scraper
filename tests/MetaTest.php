<?php
declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;

/**
 * Class MetaTest.
 */
class MetaTest extends AbstractTestCase
{
    /**
     * Meta instance.
     *
     * @var \Rugaard\MetaScraper\Meta
     */
    protected $meta;

    /**
     * Test method [hasAttribute].
     *
     * @return void
     */
    public function testMethodHasAttribute()
    {
        $this->assertTrue($this->meta->hasAttribute('name'));
    }

    /**
     * Test method [getAttribute].
     *
     * @return void
     */
    public function testMethodGetAttribute()
    {
        $attribute = $this->meta->getAttribute('name');

        $this->assertNotEmpty($attribute);
        $this->assertEquals('title', $attribute);
    }

    /**
     * Test that an exception is thrown when method [getAttribute]
     * does not find the expected attribute.
     *
     * @return void
     */
    public function testExceptionAttributeNotFoundExceptionInGetAttribute()
    {
        $this->expectException(AttributeNotFoundException::class);
        $this->meta->getAttribute('non-existing-attribute');
    }

    /**
     * Test method [hasNamespace].
     *
     * @return void
     */
    public function testMethodHasNamespace()
    {
        $this->assertTrue($this->meta->hasNamespace());
    }

    /**
     * Test method [getNamespace].
     *
     * @return void
     */
    public function testMethodGetNamespace()
    {
        $namespace = $this->meta->getNamespace();

        $this->assertNotEmpty($namespace);
        $this->assertEquals('og', $namespace);
    }

    /**
     * Test that an exception is thrown when method [getNamespace]
     * does not find the expected attribute.
     *
     * @return void
     */
    public function testExceptionAttributeNotFoundExceptionInGetNamespace()
    {
        $mockedMeta = $this->createPartialMock(get_class($this->meta), ['hasNamespace']);
        $mockedMeta->method('hasNamespace')->willReturn(false);

        $this->expectException(AttributeNotFoundException::class);
        $mockedMeta->getNamespace();
    }

    /**
     * Test method [getName].
     *
     * @return void
     */
    public function testMethodGetName()
    {
        $name = $this->meta->getName();

        $this->assertNotEmpty($name);
        $this->assertEquals('title', $name);
    }

    /**
     * Test method [getNameWithNamespace].
     *
     * @return void
     */
    public function testMethodGetNameWithNamespace()
    {
        $nameWithNamespace = $this->meta->getNameWithNamespace();

        $this->assertNotEmpty($nameWithNamespace);
        $this->assertEquals('og:title', $nameWithNamespace);
    }

    /**
     * Test method [getValue].
     *
     * @return void
     */
    public function testMethodGetValue()
    {
        $value = $this->meta->getValue();

        $this->assertNotEmpty($value);
        $this->assertEquals('This is an Open Graph title', $value);
    }

    /**
     * Prepare test case.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->scraper->setClient($this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], $this->getMockedResponse()),
        ]))->load('http://127.0.0.1');

        $this->meta = $this->scraper->getMetaTags()->slice(1, 1)->first();
    }

    /**
     * Reset test case.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        unset($this->meta);
    }
}

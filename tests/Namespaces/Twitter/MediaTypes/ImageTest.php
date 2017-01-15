<?php
declare (strict_types = 1);

namespace Tests\Namespaces\Twitter\MediaTypes;

use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;
use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;
use Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\Image;
use Tests\Namespaces\Twitter\AbstractTwitterTestCase;

/**
 * Class ImageTest.
 */
class ImageTest extends AbstractTwitterTestCase
{
    /**
     * Image instance
     *
     * @var \Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\Image|null
     */
    protected $image;

    /**
     * Test that object is a Image instance.
     *
     * @return void
     */
    public function testIsImageInstance()
    {
        $this->assertNotEmpty($this->image);
        $this->assertInstanceOf(Image::class, $this->image);
    }

    /**
     * Test method [getUrl].
     *
     * @return void
     */
    public function testUrl()
    {
        $url = $this->image->getUrl();

        $this->assertNotEmpty($url);
        $this->assertNotFalse(filter_var($url, FILTER_VALIDATE_URL));
        $this->assertEquals('https://example.com/image.png', $url);
    }

    /**
     * Test method [getDescription].
     *
     * @return void
     */
    public function testDescription()
    {
        $description = $this->image->getDescription();

        $this->assertNotEmpty($description);
        $this->assertEquals('This is an image alt', $description);
    }

    /**
     * Test magic [__call] method.
     *
     * @return void
     */
    public function testMagicInvalidGetMethod()
    {
        $this->expectException(MethodNotFoundException::class);
        $this->image->callNoneExistingGetMethod();
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
        $this->image->getNonExistingAttribute();
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
        $this->invokeMethod($this->trait, 'parseTwitterMediaTypes', [$twitterData]);

        $data = $this->trait->getTwitter();

        $this->image = array_key_exists('image', $data) ? $data['image'] : null;
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
    <meta name="twitter:image" content="https://example.com/image.png">
    <meta name="twitter:image:alt" content="This is an image alt">
</head><body></body></html>
HTML;
    }
}
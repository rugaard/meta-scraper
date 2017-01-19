<?php
declare(strict_types=1);

namespace Tests\Namespaces\OpenGraph\MediaTypes;

use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;
use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;
use Rugaard\MetaScraper\Namespaces\OpenGraph\MediaTypes\Image;
use Tests\Namespaces\OpenGraph\AbstractOpenGraphTestCase;

/**
 * Class ImageTest.
 */
class ImageTest extends AbstractOpenGraphTestCase
{
    /**
     * Array of images
     *
     * @var array|null
     */
    protected $images;

    /**
     * Test that images is returned as an array.
     *
     * @return void
     */
    public function testIsArrayImages()
    {
        $this->assertInternalType('array', $this->images);
        $this->assertCount(2, $this->images);
    }

    /**
     * Test that object is a Image instance.
     *
     * @return void
     */
    public function testIsImageInstances()
    {
        foreach ($this->images as $image) {
            $this->assertNotEmpty($image);
            $this->assertInstanceOf(Image::class, $image);
        }
    }

    /**
     * Test method [getUrl].
     *
     * @return void
     */
    public function testUrl()
    {
        $imageOneUrl = $this->images[0]->getUrl();
        $this->assertNotFalse(filter_var($imageOneUrl, FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/image.jpg', $imageOneUrl);

        $imageTwoUrl = $this->images[1]->getUrl();
        $this->assertNotFalse(filter_var($imageTwoUrl, FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/alternative.jpg', $imageTwoUrl);
    }

    /**
     * Test method [getSecureUrl].
     *
     * @return void
     */
    public function testSecureUrl()
    {
        $imageOneSecureUrl = $this->images[0]->getSecureUrl();
        $this->assertNotFalse(filter_var($imageOneSecureUrl, FILTER_VALIDATE_URL));
        $this->assertEquals('https://example.com/image.jpg', $imageOneSecureUrl);

        $this->expectException(AttributeNotFoundException::class);
        $this->images[1]->getSecureUrl();
    }

    /**
     * Test method [getMimeType].
     *
     * @return void
     */
    public function testMimeType()
    {
        $imageOneMimeType = $this->images[0]->getMimeType();
        $this->assertEquals('image/jpeg', $imageOneMimeType);

        $this->expectException(AttributeNotFoundException::class);
        $this->images[1]->getMimeType();
    }

    /**
     * Test method [getWidth].
     *
     * @return void
     */
    public function testWidth()
    {
        $imageOneWidth = $this->images[0]->getWidth();
        $this->assertInternalType('int', $imageOneWidth);
        $this->assertEquals(600, $imageOneWidth);

        $this->expectException(AttributeNotFoundException::class);
        $this->images[1]->getWidth();
    }

    /**
     * Test method [getHeight].
     *
     * @return void
     */
    public function testHeight()
    {
        $imageOneHeight = $this->images[0]->getHeight();
        $this->assertInternalType('int', $imageOneHeight);
        $this->assertEquals(315, $imageOneHeight);

        $this->expectException(AttributeNotFoundException::class);
        $this->images[1]->getHeight();
    }

    /**
     * Test magic [__call] method.
     *
     * @return void
     */
    public function testMagicInvalidGetMethod()
    {
        $this->expectException(MethodNotFoundException::class);

        foreach ($this->images as $image) {
            $image->callNoneExistingGetMethod();
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

        foreach ($this->images as $image) {
            $image->getNonExistingAttribute();
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

        $this->images = array_key_exists('image', $data) ? $data['image'] : null;
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
    <meta property="og:image" content="http://example.com/image.jpg">
    <meta property="og:image:secure_url" content="https://example.com/image.jpg">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="600">
    <meta property="og:image:height" content="315">
    <meta property="og:image" content="http://example.com/alternative.jpg">
</head><body></body></html>
HTML;
    }
}

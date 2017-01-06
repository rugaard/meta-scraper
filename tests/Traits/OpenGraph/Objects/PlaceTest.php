<?php
declare (strict_types = 1);

namespace Tests\Traits\OpenGraph\Objects;

use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;
use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;
use Rugaard\MetaScraper\Traits\OpenGraph\Objects\Place;

/**
 * Class PlaceTest.
 */
class PlaceTest extends AbstractObjectTestCase
{
    /**
     * Place instance
     *
     * @var \Rugaard\MetaScraper\Traits\OpenGraph\Objects\Place|null
     */
    protected $place;

    /**
     * Test that object is a Place instance.
     *
     * @return void
     */
    public function testIsPlaceInstance()
    {
        $this->assertNotEmpty($this->place);
        $this->assertInstanceOf(Place::class, $this->place);
    }

    /**
     * Test method [getLatitude].
     *
     * @return void
     */
    public function getLatitude()
    {
        $latitude = $this->place->getLatitude();

        $this->assertNotEmpty($latitude);
        $this->assertEquals('55.676097', $latitude);
    }

    /**
     * Test method [getLongitude].
     *
     * @return void
     */
    public function testLongitude()
    {
        $longitude = $this->place->getLongitude();

        $this->assertNotEmpty($longitude);
        $this->assertEquals('12.568337', $longitude);
    }

    /**
     * Test method [getAltitude].
     *
     * @return void
     */
    public function testAltitude()
    {
        $altitude = $this->place->getAltitude();

        $this->assertNotEmpty($altitude);
        $this->assertEquals('6.0', $altitude);
    }

    /**
     * Test magic [__call] method.
     *
     * @return void
     */
    public function testMagicInvalidGetMethod()
    {
        $this->expectException(MethodNotFoundException::class);
        $this->place->callNoneExistingGetMethod();
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
        $this->place->getNonExistingAttribute();
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

        $this->place = array_key_exists('place', $data['objects']) ? $data['objects']['place'] : null;
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
    <meta property="place:location:latitude" content="55.676097">
    <meta property="place:location:longitude" content="12.568337">
    <meta property="place:location:altitude" content="6.0">
</head><body></body></html>
HTML;
    }
}
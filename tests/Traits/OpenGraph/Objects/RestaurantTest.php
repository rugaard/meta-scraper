<?php
declare (strict_types = 1);

namespace Tests\Traits\OpenGraph\Objects;

use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;
use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;
use Rugaard\MetaScraper\Traits\OpenGraph\Objects\Restaurant;

/**
 * Class RestaurantTest.
 */
class RestaurantTest extends AbstractOpenGraphObjectTestCase
{
    /**
     * Restaurant instance
     *
     * @var \Rugaard\MetaScraper\Traits\OpenGraph\Objects\Restaurant|null
     */
    protected $restaurant;

    /**
     * Test that object is a Restaurant instance.
     *
     * @return void
     */
    public function testIsRestaurantInstance()
    {
        $this->assertNotEmpty($this->restaurant);
        $this->assertInstanceOf(Restaurant::class, $this->restaurant);
    }

    /**
     * Test magic [__call] method.
     *
     * @return void
     */
    public function testMagicInvalidGetMethod()
    {
        $this->expectException(MethodNotFoundException::class);
        $this->restaurant->callNoneExistingGetMethod();
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
        $this->restaurant->getNonExistingAttribute();
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

        $this->restaurant = array_key_exists('restaurant', $data['objects']) ? $data['objects']['restaurant'] : null;
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
    <meta property="restaurant:attribute" content="N/A">
</head><body></body></html>
HTML;
    }
}
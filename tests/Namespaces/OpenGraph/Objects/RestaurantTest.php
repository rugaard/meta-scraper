<?php
declare (strict_types = 1);

namespace Tests\Namespaces\OpenGraph\Objects;

use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;
use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;
use Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Restaurant;
use Tests\Namespaces\OpenGraph\AbstractOpenGraphTestCase;

/**
 * Class RestaurantTest.
 */
class RestaurantTest extends AbstractOpenGraphTestCase
{
    /**
     * Restaurant instance
     *
     * @var \Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Restaurant|null
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
     * Test method [getCategory].
     *
     * @return void
     */
    public function testCategories()
    {
        $category = $this->restaurant->getCategory();

        $this->assertNotEmpty($category);
        $this->assertInternalType('array', $category);
        $this->assertCount(3, $category);

        $this->assertEquals('Danish', $category[0]);
        $this->assertEquals('Italian', $category[1]);
        $this->assertEquals('Chinese', $category[2]);
    }

    /**
     * Test method [getStreetAddress].
     *
     * @return void
     */
    public function testStreetAddress()
    {
        $streetAddress = $this->restaurant->getStreetAddress();

        $this->assertNotEmpty($streetAddress);
        $this->assertEquals('Random Street 28', $streetAddress);
    }

    /**
     * Test method [getPostalCode].
     *
     * @return void
     */
    public function testPostalCode()
    {
        $postalCode = $this->restaurant->getPostalCode();

        $this->assertNotEmpty($postalCode);
        $this->assertEquals('280787', $postalCode);
    }

    /**
     * Test method [getLocality].
     *
     * @return void
     */
    public function testCityLocality()
    {
        $cityLocality = $this->restaurant->getLocality();

        $this->assertNotEmpty($cityLocality);
        $this->assertEquals('Downtown', $cityLocality);
    }

    /**
     * Test method [getRegion].
     *
     * @return void
     */
    public function testRegion()
    {
        $region = $this->restaurant->getRegion();

        $this->assertNotEmpty($region);
        $this->assertEquals('Capital Region', $region);
    }

    /**
     * Test method [getCountry].
     *
     * @return void
     */
    public function testCountry()
    {
        $country = $this->restaurant->getCountryName();

        $this->assertNotEmpty($country);
        $this->assertEquals('The World', $country);
    }

    /**
     * Test method [getEmail].
     *
     * @return void
     */
    public function testEmail()
    {
        $email = $this->restaurant->getEmail();

        $this->assertNotEmpty($email);
        $this->assertNotFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
        $this->assertEquals('info@example.com', $email);
    }

    /**
     * Test method [getPhone].
     *
     * @return void
     */
    public function testPhoneNumber()
    {
        $phoneNumber = $this->restaurant->getPhoneNumber();

        $this->assertNotEmpty($phoneNumber);
        $this->assertEquals('1234567890', $phoneNumber);
    }

    /**
     * Test method [getFax].
     *
     * @return void
     */
    public function testFaxNumber()
    {
        $faxNumber = $this->restaurant->getFaxNumber();

        $this->assertNotEmpty($faxNumber);
        $this->assertEquals('0987654321', $faxNumber);
    }

    /**
     * Test method [getWebsite].
     *
     * @return void
     */
    public function testWebsiteUrl()
    {
        $website = $this->restaurant->getWebsite();

        $this->assertNotEmpty($website);
        $this->assertNotFalse(filter_var($website, FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com', $website);
    }

    /**
     * Test method [getItem].
     *
     * @return void
     */
    public function testItems()
    {
        $item = $this->restaurant->getItem();

        $this->assertNotEmpty($item);
        $this->assertInternalType('array', $item);
        $this->assertCount(2, $item);

        $this->assertNotFalse(filter_var($item[0], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/item-1', $item[0]);

        $this->assertNotFalse(filter_var($item[1], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/item-2', $item[1]);
    }

    /**
     * Test method [getMenu].
     *
     * @return void
     */
    public function testMenus()
    {
        $menu = $this->restaurant->getMenu();

        $this->assertNotEmpty($menu);
        $this->assertInternalType('array', $menu);
        $this->assertCount(2, $menu);

        $this->assertNotFalse(filter_var($menu[0], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/menu-1', $menu[0]);

        $this->assertNotFalse(filter_var($menu[1], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/menu-2', $menu[1]);
    }

    /**
     * Test method [getSection].
     *
     * @return void
     */
    public function testSections()
    {
        $section = $this->restaurant->getSection();

        $this->assertNotEmpty($section);
        $this->assertInternalType('array', $section);
        $this->assertCount(2, $section);

        $this->assertNotFalse(filter_var($section[0], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/section-1', $section[0]);

        $this->assertNotFalse(filter_var($section[1], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/section-2', $section[1]);
    }

    /**
     * Test method [getPriceRating].
     *
     * @return void
     */
    public function testPriceRating()
    {
        $priceRating = $this->restaurant->getPriceRating();

        $this->assertNotEmpty($priceRating);
        $this->assertInternalType('int', $priceRating);
        $this->assertEquals(2, $priceRating);
    }

    /**
     * Test method [getVariation].
     *
     * @return void
     */
    public function testVariations()
    {
        $variation = $this->restaurant->getVariation();

        $this->assertNotEmpty($variation);
        $this->assertInternalType('array', $variation);
        $this->assertCount(2, $variation);

        $this->assertArrayHasKey('price', $variation[0]);
        $this->assertEquals('2807.87', $variation[0]['price']['amount']);
        $this->assertEquals('USD', $variation[0]['price']['currency']);
        $this->assertArrayHasKey('name', $variation[0]);
        $this->assertEquals('Beef with fries', $variation[0]['name']);

        $this->assertArrayHasKey('price', $variation[1]);
        $this->assertEquals('1234.56', $variation[1]['price']['amount']);
        $this->assertEquals('EUR', $variation[1]['price']['currency']);
        $this->assertArrayHasKey('name', $variation[1]);
        $this->assertEquals('Beef with mashed potatoes', $variation[1]['name']);
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

        $this->invokeMethod($this->trait, 'parseOpenGraphObjects', []);

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
    <meta property="restaurant:category" content="Danish">
    <meta property="restaurant:category" content="Italian">
    <meta property="restaurant:category" content="Chinese">
    <meta property="restaurant:contact_info:street_address" content="Random Street 28">
    <meta property="restaurant:contact_info:postal_code" content="280787">
    <meta property="restaurant:contact_info:locality" content="Downtown">
    <meta property="restaurant:contact_info:region" content="Capital Region">
    <meta property="restaurant:contact_info:country_name" content="The World">
    <meta property="restaurant:contact_info:email" content="info@example.com">
    <meta property="restaurant:contact_info:phone_number" content="1234567890">
    <meta property="restaurant:contact_info:fax_number" content="0987654321">
    <meta property="restaurant:contact_info:website" content="http://example.com">
    <meta property="restaurant:item" content="http://example.com/item-1">
    <meta property="restaurant:item" content="http://example.com/item-2">
    <meta property="restaurant:menu" content="http://example.com/menu-1">
    <meta property="restaurant:menu" content="http://example.com/menu-2">
    <meta property="restaurant:section" content="http://example.com/section-1">
    <meta property="restaurant:section" content="http://example.com/section-2">
    <meta property="restaurant:price_rating" content="2">
    <meta property="restaurant:variation:price:amount" content="2807.87">
    <meta property="restaurant:variation:price:currency" content="USD">
    <meta property="restaurant:variation:name" content="Beef with fries">
    <meta property="restaurant:variation:price:amount" content="1234.56">
    <meta property="restaurant:variation:price:currency" content="EUR">
    <meta property="restaurant:variation:name" content="Beef with mashed potatoes">
</head><body></body></html>
HTML;
    }
}
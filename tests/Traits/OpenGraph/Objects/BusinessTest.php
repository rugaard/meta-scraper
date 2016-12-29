<?php
declare (strict_types = 1);

namespace Tests\Traits\OpenGraph\Objects;

use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;
use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;
use Rugaard\MetaScraper\Traits\OpenGraph\Objects\Business;

/**
 * Class BusinessTest.
 */
class BusinessTest extends AbstractOpenGraphObjectTestCase
{
    /**
     * Business instance
     *
     * @var \Rugaard\MetaScraper\Traits\OpenGraph\Objects\Business|null
     */
    protected $business;

    /**
     * Test that object is a Business instance.
     *
     * @return void
     */
    public function testIsBusinessInstance()
    {
        $this->assertNotEmpty($this->business);
        $this->assertInstanceOf(Business::class, $this->business);
    }

    /**
     * Test method [getStreetAddress].
     *
     * @return void
     */
    public function testStreetAddress()
    {
        $streetAddress = $this->business->getStreetAddress();

        $this->assertNotEmpty($streetAddress);
        $this->assertEquals('Anfield Road', $streetAddress);
    }

    /**
     * Test method [getLocality].
     *
     * @return void
     */
    public function testCityLocality()
    {
        $cityLocality = $this->business->getLocality();

        $this->assertNotEmpty($cityLocality);
        $this->assertEquals('Liverpool', $cityLocality);
    }

    /**
     * Test method [getPostalCode].
     *
     * @return void
     */
    public function testPostalCode()
    {
        $postalCode = $this->business->getPostalCode();

        $this->assertNotEmpty($postalCode);
        $this->assertEquals('L4 0TH', $postalCode);
    }

    /**
     * Test method [getCountry].
     *
     * @return void
     */
    public function testCountry()
    {
        $country = $this->business->getCountry();

        $this->assertNotEmpty($country);
        $this->assertEquals('Great Britain', $country);
    }

    /**
     * Test method [getEmail].
     *
     * @return void
     */
    public function testEmail()
    {
        $email = $this->business->getEmail();

        $this->assertNotEmpty($email);
        $this->assertNotFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
        $this->assertEquals('anfield@liverpoolfc.tv', $email);
    }

    /**
     * Test method [getPhone].
     *
     * @return void
     */
    public function testPhoneNumber()
    {
        $phoneNumber = $this->business->getPhone();

        $this->assertNotEmpty($phoneNumber);
        $this->assertEquals('+44 0151-263-2361', $phoneNumber);
    }

    /**
     * Test method [getFax].
     *
     * @return void
     */
    public function testFaxNumber()
    {
        $faxNumber = $this->business->getFax();

        $this->assertNotEmpty($faxNumber);
        $this->assertEquals('+44 0151-260-8813', $faxNumber);
    }

    /**
     * Test method [getWebsite].
     *
     * @return void
     */
    public function testWebsiteUrl()
    {
        $website = $this->business->getWebsite();

        $this->assertNotEmpty($website);
        $this->assertNotFalse(filter_var($website, FILTER_VALIDATE_URL));
        $this->assertEquals('http://liverpoolfc.tv', $website);
    }

    /**
     * Test method [getHours].
     *
     * @return void
     */
    public function testOpeningHours()
    {
        $hours = $this->business->getHours();

        $this->assertNotEmpty($hours);
        $this->assertInternalType('array', $hours);
        $this->assertCount(7, $hours);
        $this->assertArraySubset([
            ['day' => 'monday', 'start' => '10 AM', 'end' => '3 PM'],
            ['day' => 'tuesday', 'start' => '10 AM', 'end' => '3 PM'],
            ['day' => 'wednesday', 'start' => '10 AM', 'end' => '3 PM'],
            ['day' => 'thursday', 'start' => '10 AM', 'end' => '3 PM'],
            ['day' => 'friday', 'start' => '10 AM', 'end' => '3 PM'],
            ['day' => 'saturday', 'start' => '10 AM', 'end' => '3 PM'],
            ['day' => 'sunday', 'start' => '10 AM', 'end' => '3 PM'],
        ], $hours);
    }

    /**
     * Test magic [__call] method.
     *
     * @return void
     */
    public function testMagicInvalidGetMethod()
    {
        $this->expectException(MethodNotFoundException::class);
        $this->business->callNoneExistingGetMethod();
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
        $this->business->getNonExistingAttribute();
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

        $this->business = array_key_exists('business', $data['objects']) ? $data['objects']['business'] : null;
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
    <meta property="business:contact_data:street_address" content="Anfield Road">
    <meta property="business:contact_data:locality" content="Liverpool">
    <meta property="business:contact_data:postal_code" content="L4 0TH">
    <meta property="business:contact_data:country" content="Great Britain">
    <meta property="business:contact_data:email" content="anfield@liverpoolfc.tv">
    <meta property="business:contact_data:phone" content="+44 0151-263-2361">
    <meta property="business:contact_data:fax" content="+44 0151-260-8813">
    <meta property="business:contact_data:website" content="http://liverpoolfc.tv">
    <meta property="business:hours:day" content="monday">
    <meta property="business:hours:start" content="10 AM">
    <meta property="business:hours:end" content="3 PM">
    <meta property="business:hours:day" content="tuesday">
    <meta property="business:hours:start" content="10 AM">
    <meta property="business:hours:end" content="3 PM">
    <meta property="business:hours:day" content="wednesday">
    <meta property="business:hours:start" content="10 AM">
    <meta property="business:hours:end" content="3 PM">
    <meta property="business:hours:day" content="thursday">
    <meta property="business:hours:start" content="10 AM">
    <meta property="business:hours:end" content="3 PM">
    <meta property="business:hours:day" content="friday">
    <meta property="business:hours:start" content="10 AM">
    <meta property="business:hours:end" content="3 PM">
    <meta property="business:hours:day" content="saturday">
    <meta property="business:hours:start" content="10 AM">
    <meta property="business:hours:end" content="3 PM">
    <meta property="business:hours:day" content="sunday">
    <meta property="business:hours:start" content="10 AM">
    <meta property="business:hours:end" content="3 PM">
</head><body></body></html>
HTML;
    }
}
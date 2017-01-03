<?php
declare (strict_types = 1);

namespace Tests\Traits\OpenGraph\Objects;

use DateTime;
use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;
use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;
use Rugaard\MetaScraper\Traits\OpenGraph\Objects\Product;

/**
 * Class ProductTest.
 */
class ProductTest extends AbstractOpenGraphObjectTestCase
{
    /**
     * Product instance
     *
     * @var \Rugaard\MetaScraper\Traits\OpenGraph\Objects\Product|null
     */
    protected $product;

    /**
     * Test that object is a Product instance.
     *
     * @return void
     */
    public function testIsProductInstance()
    {
        $this->assertNotEmpty($this->product);
        $this->assertInstanceOf(Product::class, $this->product);
    }

    /**
     * Test method [getAgeGroup].
     *
     * @return void
     */
    public function testAgeGroup()
    {
        $ageGroup = $this->product->getAgeGroup();

        $this->assertNotEmpty($ageGroup);
        $this->assertEquals('adult', $ageGroup);
    }

    /**
     * Test method [getAvailability].
     *
     * @return void
     */
    public function testAvailability()
    {
        $availability = $this->product->getAvailability();

        $this->assertNotEmpty($availability);
        $this->assertEquals('instock', $availability);
    }

    /**
     * Test method [getBrand].
     *
     * @return void
     */
    public function testBrand()
    {
        $brand = $this->product->getBrand();

        $this->assertNotEmpty($brand);
        $this->assertEquals('Apple Inc.', $brand);
    }

    /**
     * Test method [getCategory].
     *
     * @return void
     */
    public function testCategory()
    {
        $category = $this->product->getCategory();

        $this->assertNotEmpty($category);
        $this->assertEquals('Electronics', $category);
    }

    /**
     * Test method [getColor].
     *
     * @return void
     */
    public function testColor()
    {
        $color = $this->product->getColor();

        $this->assertNotEmpty($color);
        $this->assertEquals('Silver', $color);
    }

    /**
     * Test method [getCondition].
     *
     * @return void
     */
    public function testCondition()
    {
        $condition = $this->product->getCondition();

        $this->assertNotEmpty($condition);
        $this->assertEquals('new', $condition);
    }

    /**
     * Test method [getEan].
     *
     * @return void
     */
    public function testEan()
    {
        $ean = $this->product->getEan();

        $this->assertNotEmpty($ean);
        $this->assertEquals('888462916226', $ean);
    }

    /**
     * Test method [getExpirationTime].
     *
     * @return void
     */
    public function testExpirationTime()
    {
        $expirationTime = $this->product->getExpirationTime();

        $this->assertNotEmpty($expirationTime);
        $this->assertInstanceOf(DateTime::class, $expirationTime);
        $this->assertEquals('2018-12-31T23:59:59+00:00', $expirationTime->format(DATE_W3C));
    }

    /**
     * Test method [getIsProductSharable].
     *
     * @return void
     */
    public function testIsProductShareable()
    {
        $isProductShareable = $this->product->getIsProductShareable();

        $this->assertNotEmpty($isProductShareable);
        $this->assertTrue($isProductShareable);
    }

    /**
     * Test method [getIsbn].
     *
     * @return void
     */
    public function testIsbn()
    {
        $isbn = $this->product->getIsbn();

        $this->assertNotEmpty($isbn);
        $this->assertEquals('1234567890000', $isbn);
    }

    /**
     * Test method [getMaterial].
     *
     * @return void
     */
    public function testMaterial()
    {
        $material = $this->product->getMaterial();

        $this->assertNotEmpty($material);
        $this->assertEquals('Aluminium', $material);
    }

    /**
     * Test method [getMfrPartNo].
     *
     * @return void
     */
    public function testMfrPartNo()
    {
        $mfrPartNo = $this->product->getMfrPartNo();

        $this->assertNotEmpty($mfrPartNo);
        $this->assertEquals('N/A', $mfrPartNo);
    }

    /**
     * Test method [getOriginalPrice].
     *
     * @return void
     */
    public function testOriginalPrice()
    {
        $originalPrice = $this->product->getOriginalPrice();

        $this->assertNotEmpty($originalPrice);
        $this->assertInternalType('array', $originalPrice);
        $this->assertEquals('2799.00', $originalPrice['amount']);
        $this->assertEquals('USD', $originalPrice['currency']);
    }

    /**
     * Test method [getPattern].
     *
     * @return void
     */
    public function testPattern()
    {
        $pattern = $this->product->getPattern();

        $this->assertNotEmpty($pattern);
        $this->assertEquals('Solid', $pattern);
    }

    /**
     * Test method [getPluralTitle].
     *
     * @return void
     */
    public function testPluralTitle()
    {
        $pluralTitle = $this->product->getPluralTitle();

        $this->assertNotEmpty($pluralTitle);
        $this->assertEquals('Macbook Pro\'s', $pluralTitle);
    }

    /**
     * Test method [getPretaxPrice].
     *
     * @return void
     */
    public function testPretaxPrice()
    {
        $pretaxPrice = $this->product->getPretaxPrice();

        $this->assertNotEmpty($pretaxPrice);
        $this->assertInternalType('array', $pretaxPrice);
        $this->assertEquals('2099.25', $pretaxPrice['amount']);
        $this->assertEquals('USD', $pretaxPrice['currency']);
    }

    /**
     * Test method [getPrice].
     *
     * @return void
     */
    public function testPrice()
    {
        $price = $this->product->getPrice();

        $this->assertNotEmpty($price);
        $this->assertInternalType('array', $price);
        $this->assertEquals('2799.00', $price['amount']);
        $this->assertEquals('USD', $price['currency']);
    }

    /**
     * Test method [getProductLink].
     *
     * @return void
     */
    public function testProductLink()
    {
        $productLink = $this->product->getProductLink();

        $this->assertNotEmpty($productLink);
        $this->assertNotFalse(filter_var($productLink, FILTER_VALIDATE_URL));
        $this->assertEquals('http://www.apple.com/macbook-pro/specs/#gallery-navigation-15-inch', $productLink);
    }

    /**
     * Test method [getPurchaseLimit].
     *
     * @return void
     */
    public function testPurchaseLimit()
    {
        $purchaseLimit = $this->product->getPurchaseLimit();

        $this->assertNotEmpty($purchaseLimit);
        $this->assertInternalType('int', $purchaseLimit);
        $this->assertEquals(1, $purchaseLimit);
    }

    /**
     * Test method [getRetailer].
     *
     * @return void
     */
    public function testRetailer()
    {
        $retailer = $this->product->getRetailer();

        $this->assertNotEmpty($retailer);
        $this->assertNotFalse(filter_var($retailer, FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/retailer', $retailer);
    }

    /**
     * Test method [getRetailerCategory].
     *
     * @return void
     */
    public function testRetailerCategory()
    {
        $retailerCategory = $this->product->getRetailerCategory();

        $this->assertNotEmpty($retailerCategory);
        $this->assertEquals('Mac', $retailerCategory);
    }

    /**
     * Test method [getRetailerPartNo].
     *
     * @return void
     */
    public function testRetailerPartNo()
    {
        $retailerPartNo = $this->product->getRetailerPartNo();

        $this->assertNotEmpty($retailerPartNo);
        $this->assertEquals('N/A', $retailerPartNo);
    }

    /**
     * Test method [getRetailerTitle].
     *
     * @return void
     */
    public function testRetailerTitle()
    {
        $retailerTitle = $this->product->getRetailerTitle();

        $this->assertNotEmpty($retailerTitle);
        $this->assertEquals('Apple Store', $retailerTitle);
    }

    /**
     * Test method [getSalePrice].
     *
     * @return void
     */
    public function testSalePrice()
    {
        $salePrice = $this->product->getSalePrice();

        $this->assertNotEmpty($salePrice);
        $this->assertInternalType('array', $salePrice);
        $this->assertEquals('1999.00', $salePrice['amount']);
        $this->assertEquals('USD', $salePrice['currency']);
    }

    /**
     * Test method [getSalePriceDates].
     *
     * @return void
     */
    public function testSalePriceDates()
    {
        $salePriceDates = $this->product->getSalePriceDates();

        $this->assertNotEmpty($salePriceDates);
        $this->assertInternalType('array', $salePriceDates);

        $this->assertInstanceOf(DateTime::class, $salePriceDates['start']);
        $this->assertEquals('2017-01-01T00:00:00+00:00', $salePriceDates['start']->format(DATE_W3C));

        $this->assertInstanceOf(DateTime::class, $salePriceDates['end']);
        $this->assertEquals('2017-01-14T23:59:59+00:00', $salePriceDates['end']->format(DATE_W3C));
    }

    /**
     * Test method [getShippingCost].
     *
     * @return void
     */
    public function testShippingCost()
    {
        $shippingCost = $this->product->getShippingCost();

        $this->assertNotEmpty($shippingCost);
        $this->assertInternalType('array', $shippingCost);
        $this->assertEquals('0.00', $shippingCost['amount']);
        $this->assertEquals('USD', $shippingCost['currency']);
    }

    /**
     * Test method [getShippingWeight].
     *
     * @return void
     */
    public function testShippingWeight()
    {
        $shippingWeight = $this->product->getShippingWeight();

        $this->assertNotEmpty($shippingWeight);
        $this->assertInternalType('array', $shippingWeight);
        $this->assertEquals('3.28', $shippingWeight['value']);
        $this->assertEquals('kg', $shippingWeight['units']);
    }

    /**
     * Test method [getSize].
     *
     * @return void
     */
    public function testSize()
    {
        $size = $this->product->getSize();

        $this->assertNotEmpty($size);
        $this->assertEquals('L', $size);
    }

    /**
     * Test method [getTargetGender].
     *
     * @return void
     */
    public function testTargetGender()
    {
        $targetGender = $this->product->getTargetGender();

        $this->assertNotEmpty($targetGender);
        $this->assertEquals('unisex', $targetGender);
    }

    /**
     * Test method [getUpc].
     *
     * @return void
     */
    public function testUpc()
    {
        $upc = $this->product->getUpc();

        $this->assertNotEmpty($upc);
        $this->assertEquals('888462786867', $upc);
    }

    /**
     * Test method [getWeight].
     *
     * @return void
     */
    public function testWeight()
    {
        $weight = $this->product->getWeight();

        $this->assertNotEmpty($weight);
        $this->assertInternalType('array', $weight);
        $this->assertEquals('1.83', $weight['value']);
        $this->assertEquals('kg', $weight['units']);
    }

    /**
     * Test magic [__call] method.
     *
     * @return void
     */
    public function testMagicInvalidGetMethod()
    {
        $this->expectException(MethodNotFoundException::class);
        $this->product->callNoneExistingGetMethod();
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
        $this->product->getNonExistingAttribute();
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

        $this->product = array_key_exists('product', $data['objects']) ? $data['objects']['product'] : null;
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
    <meta property="product:age_group" content="adult">
    <meta property="product:availability" content="instock">
    <meta property="product:brand" content="Apple Inc.">
    <meta property="product:category" content="Electronics">
    <meta property="product:color" content="Silver">
    <meta property="product:condition" content="new">
    <meta property="product:ean" content="888462916226">
    <meta property="product:expiration_time" value="2018-12-31T23:59:59+00:00">
    <meta property="product:is_product_shareable" value="true">
    <meta property="product:isbn" value="1234567890000">
    <meta property="product:material" value="Aluminium">
    <meta property="product:mfr_part_no" value="N/A">
    <meta property="product:original_price:amount" value="2799.00">
    <meta property="product:original_price:currency" value="USD">
    <meta property="product:pattern" value="Solid">
    <meta property="product:plural_title" value="Macbook Pro's">
    <meta property="product:pretax_price:amount" value="2099.25">
    <meta property="product:pretax_price:currency" value="USD">
    <meta property="product:price:amount" value="2799.00">
    <meta property="product:price:currency" value="USD">
    <meta property="product:product_link" value="http://www.apple.com/macbook-pro/specs/#gallery-navigation-15-inch">
    <meta property="product:purchase_limit" value="1">
    <meta property="product:retailer" value="http://example.com/retailer">
    <meta property="product:retailer_category" value="Mac">
    <meta property="product:retailer_part_no" value="N/A">
    <meta property="product:retailer_title" value="Apple Store">
    <meta property="product:sale_price:amount" value="1999.00">
    <meta property="product:sale_price:currency" value="USD">
    <meta property="product:sale_price_dates:start" value="2017-01-01T00:00:00+00:00">
    <meta property="product:sale_price_dates:end" value="2017-01-14T23:59:59+00:00">
    <meta property="product:shipping_cost:amount" value="0.00">
    <meta property="product:shipping_cost:currency" value="USD">
    <meta property="product:shipping_weight:value" value="3.28">
    <meta property="product:shipping_weight:units" value="kg">
    <meta property="product:size" value="L">
    <meta property="product:target_gender" value="unisex">
    <meta property="product:upc" value="888462786867">
    <meta property="product:weight:value" value="1.83">
    <meta property="product:weight:units" value="kg">
</head><body></body></html>
HTML;
    }
}
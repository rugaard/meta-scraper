<?php
declare (strict_types = 1);

namespace Tests\Namespaces\Twitter\MediaTypes;

use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;
use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;
use Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\App;
use Tests\Namespaces\Twitter\AbstractTwitterTestCase;

/**
 * Class AppTest.
 */
class AppTest extends AbstractTwitterTestCase
{
    /**
     * App instance
     *
     * @var \Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\App|null
     */
    protected $app;

    /**
     * Test that object is a App instance.
     *
     * @return void
     */
    public function testIsAppInstance()
    {
        $this->assertNotEmpty($this->app);
        $this->assertInstanceOf(App::class, $this->app);
    }

    /**
     * Test method [getCountry].
     *
     * @return void
     */
    public function testCountry()
    {
        $country = $this->app->getCountry();

        $this->assertNotEmpty($country);
        $this->assertEquals('US', $country);
    }

    /**
     * Test method [getIphone].
     *
     * @return void
     */
    public function testIphone()
    {
        $iPhone = $this->app->getIphone();

        $this->assertNotEmpty($iPhone);
        $this->assertInternalType('array', $iPhone);
        $this->assertCount(3, $iPhone);

        $this->assertArrayHasKey('id', $iPhone);
        $this->assertEquals('929750075', $iPhone['id']);

        $this->assertArrayHasKey('name', $iPhone);
        $this->assertEquals('Cannonball', $iPhone['name']);

        $this->assertArrayHasKey('url', $iPhone);
        $this->assertNotFalse(filter_var($iPhone['url'], FILTER_VALIDATE_URL));
        $this->assertEquals('cannonball://poem/5149e249222f9e600a7540ef', $iPhone['url']);
    }

    /**
     * Test method [getIpad].
     *
     * @return void
     */
    public function testIpad()
    {
        $iPad = $this->app->getIpad();

        $this->assertNotEmpty($iPad);
        $this->assertInternalType('array', $iPad);
        $this->assertCount(3, $iPad);

        $this->assertArrayHasKey('id', $iPad);
        $this->assertEquals('929750075', $iPad['id']);

        $this->assertArrayHasKey('name', $iPad);
        $this->assertEquals('Cannonball', $iPad['name']);

        $this->assertArrayHasKey('url', $iPad);
        $this->assertNotFalse(filter_var($iPad['url'], FILTER_VALIDATE_URL));
        $this->assertEquals('cannonball://poem/5149e249222f9e600a7540ef', $iPad['url']);
    }

    /**
     * Test method [getGooglePlay].
     *
     * @return void
     */
    public function testGooglePlay()
    {
        $googlePlay = $this->app->getGooglePlay();

        $this->assertNotEmpty($googlePlay);
        $this->assertInternalType('array', $googlePlay);
        $this->assertCount(3, $googlePlay);

        $this->assertArrayHasKey('id', $googlePlay);
        $this->assertEquals('io.fabric.samples.cannonball', $googlePlay['id']);

        $this->assertArrayHasKey('name', $googlePlay);
        $this->assertEquals('Cannonball', $googlePlay['name']);

        $this->assertArrayHasKey('url', $googlePlay);
        $this->assertNotFalse(filter_var($googlePlay['url'], FILTER_VALIDATE_URL));
        $this->assertEquals('http://cannonball.fabric.io/poem/5149e249222f9e600a7540ef', $googlePlay['url']);
    }

    /**
     * Test magic [__call] method.
     *
     * @return void
     */
    public function testMagicInvalidGetMethod()
    {
        $this->expectException(MethodNotFoundException::class);
        $this->app->callNoneExistingGetMethod();
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
        $this->app->getNonExistingAttribute();
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

        $this->app = array_key_exists('app', $data) ? $data['app'] : null;
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
    <meta name="twitter:app:country" content="US">
    <meta name="twitter:app:name:iphone" content="Cannonball">
    <meta name="twitter:app:id:iphone" content="929750075">
    <meta name="twitter:app:url:iphone" content="cannonball://poem/5149e249222f9e600a7540ef">
    <meta name="twitter:app:name:ipad" content="Cannonball">
    <meta name="twitter:app:id:ipad" content="929750075">
    <meta name="twitter:app:url:ipad" content="cannonball://poem/5149e249222f9e600a7540ef">
    <meta name="twitter:app:name:googleplay" content="Cannonball">
    <meta name="twitter:app:id:googleplay" content="io.fabric.samples.cannonball">
    <meta name="twitter:app:url:googleplay" content="http://cannonball.fabric.io/poem/5149e249222f9e600a7540ef">
</head><body></body></html>
HTML;
    }
}
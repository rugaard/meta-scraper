<?php
declare (strict_types = 1);

namespace Tests\Traits\Facebook;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Illuminate\Support\Collection;
use Rugaard\MetaScraper\Traits\Facebook\Facebook;
use Tests\AbstractTestCase;

/**
 * Class FacebookTest.
 */
class FacebookTest extends AbstractTestCase
{
    /**
     * Mocked trait object.
     *
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $trait;

    /**
     * Test method [facebook].
     *
     * @return void
     */
    public function testFacebook()
    {
        $data = $this->trait->facebook();

        $this->assertArrayHasKey('app_id', $data);
        $this->assertArrayHasKey('admins', $data);
    }

    /**
     * Test method to parse Facebook App ID.
     *
     * @return void
     */
    public function testFacebookAppId()
    {
        $data = $this->trait->facebook();

        $this->assertArrayHasKey('app_id', $data);
        $this->assertEquals('1234567890', $data['app_id']);
    }

    /**
     * Test method [parseFacebookAppId] can handle an empty Collection.
     *
     * @return void
     */
    public function testFacebookAppIdIsEmpty()
    {
        $this->invokeMethod($this->trait, 'parseFacebookAppId', [new Collection]);

        $data = $this->trait->getFacebook();

        $this->assertArrayNotHasKey('app_id', $data);
    }

    /**
     * Test method to parse Facebook App Admins.
     *
     * @return void
     */
    public function testFacebookAppAdmins()
    {
        $data = $this->trait->facebook();

        $this->assertArrayHasKey('admins', $data);
        $this->assertInternalType('array', $data['admins']);
        $this->assertEquals('12345678', $data['admins'][0]);
        $this->assertEquals('87654321', $data['admins'][1]);
        $this->assertEquals('13579', $data['admins'][2]);
        $this->assertEquals('86420', $data['admins'][3]);
    }

    /**
     * Test method [parseFacebookAppAdmins] can handle an empty Collection.
     *
     * @return void
     */
    public function testFacebookAppAdminsIsEmpty()
    {
        $this->invokeMethod($this->trait, 'parseFacebookAppAdmins', [new Collection]);

        $data = $this->trait->getFacebook();

        $this->assertArrayNotHasKey('admins', $data);
    }

    /**
     * Prepare test case.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->trait = $this->createPartialMock(get_class($this->getMockForTrait(Facebook::class)), ['getAllByNamespace']);
        $this->trait->method('getAllByNamespace')->will($this->returnCallback(function ($namespace) {
            return $this->invokeMethod($this->scraper, 'getAllByNamespace', [$namespace]);
        }));

        $this->scraper->setClient($this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], $this->getMockedResponse())
        ]))->load('http://127.0.0.1');
    }

    /**
     * Reset test case.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        unset($this->trait);
    }
}
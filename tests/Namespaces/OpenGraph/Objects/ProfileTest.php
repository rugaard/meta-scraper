<?php
declare(strict_types=1);

namespace Tests\Namespaces\OpenGraph\Objects;

use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;
use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;
use Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Profile;
use Tests\Namespaces\OpenGraph\AbstractOpenGraphTestCase;

/**
 * Class ProfileTest.
 */
class ProfileTest extends AbstractOpenGraphTestCase
{
    /**
     * Profile instance
     *
     * @var \Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Profile|null
     */
    protected $profile;

    /**
     * Test that object is a Profile instance.
     *
     * @return void
     */
    public function testIsProfileInstance()
    {
        $this->assertNotEmpty($this->profile);
        $this->assertInstanceOf(Profile::class, $this->profile);
    }

    /**
     * Test method [getFirstName].
     *
     * @return void
     */
    public function testFirstName()
    {
        $firstName = $this->profile->getFirstName();

        $this->assertNotEmpty($firstName);
        $this->assertEquals('John', $firstName);
    }

    /**
     * Test method [getLastName].
     *
     * @return void
     */
    public function testLastName()
    {
        $lastName = $this->profile->getLastName();

        $this->assertNotEmpty($lastName);
        $this->assertEquals('Doe', $lastName);
    }

    /**
     * Test method [getGender].
     *
     * @return void
     */
    public function testGender()
    {
        $gender = $this->profile->getGender();

        $this->assertNotEmpty($gender);
        $this->assertEquals('male', $gender);
    }

    /**
     * Test method [getUsername].
     *
     * @return void
     */
    public function testUsername()
    {
        $username = $this->profile->getUsername();

        $this->assertNotEmpty($username);
        $this->assertEquals('JohnDoe28', $username);
    }

    /**
     * Test magic [__call] method.
     *
     * @return void
     */
    public function testMagicInvalidGetMethod()
    {
        $this->expectException(MethodNotFoundException::class);
        $this->profile->callNoneExistingGetMethod();
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
        $this->profile->getNonExistingAttribute();
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

        $this->profile = array_key_exists('profile', $data['objects']) ? $data['objects']['profile'] : null;
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
    <meta property="profile:first_name" content="John">
    <meta property="profile:last_name" content="Doe">
    <meta property="profile:gender" content="male">
    <meta property="profile:username" content="JohnDoe28">
</head><body></body></html>
HTML;
    }
}

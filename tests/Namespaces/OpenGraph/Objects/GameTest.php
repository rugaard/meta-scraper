<?php
declare (strict_types = 1);

namespace Tests\Namespaces\OpenGraph\Objects;

use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;
use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;
use Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Game;
use Tests\Namespaces\OpenGraph\AbstractOpenGraphTestCase;

/**
 * Class GameTest.
 */
class GameTest extends AbstractOpenGraphTestCase
{
    /**
     * Game instance
     *
     * @var \Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Game|null
     */
    protected $game;

    /**
     * Test that object is a Game instance.
     *
     * @return void
     */
    public function testIsGameInstance()
    {
        $this->assertNotEmpty($this->game);
        $this->assertInstanceOf(Game::class, $this->game);
    }

    /**
     * Test method [getPoints].
     *
     * @return void
     */
    public function testPoints()
    {
        $points = $this->game->getPoints();

        $this->assertNotEmpty($points);
        $this->assertInternalType('int', $points);
        $this->assertEquals(2807, $points);
    }

    /**
     * Test method [getSecret].
     *
     * @return void
     */
    public function testSecret()
    {
        $secret = $this->game->getSecret();

        $this->assertNotEmpty($secret);
        $this->assertInternalType('bool', $secret);
        $this->assertTrue($secret);
    }

    /**
     * Test magic [__call] method.
     *
     * @return void
     */
    public function testMagicInvalidGetMethod()
    {
        $this->expectException(MethodNotFoundException::class);
        $this->game->callNoneExistingGetMethod();
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
        $this->game->getNonExistingAttribute();
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

        $this->game = array_key_exists('game', $data['objects']) ? $data['objects']['game'] : null;
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
    <meta property="game:points" content="2807">
    <meta property="game:secret" content="true">
</head><body></body></html>
HTML;
    }
}
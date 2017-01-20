<?php
declare(strict_types=1);

namespace Tests\Namespaces\OpenGraph\MediaTypes;

use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;
use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;
use Rugaard\MetaScraper\Namespaces\OpenGraph\MediaTypes\Audio;
use Tests\Namespaces\OpenGraph\AbstractOpenGraphTestCase;

/**
 * Class AudioTest.
 */
class AudioTest extends AbstractOpenGraphTestCase
{
    /**
     * Array of audios.
     *
     * @var array|null
     */
    protected $audios;

    /**
     * Test that audios is returned as an array.
     *
     * @return void
     */
    public function testIsArrayAudios()
    {
        $this->assertInternalType('array', $this->audios);
        $this->assertCount(2, $this->audios);
    }

    /**
     * Test that object is a Audio instance.
     *
     * @return void
     */
    public function testIsAudioInstances()
    {
        foreach ($this->audios as $audio) {
            $this->assertNotEmpty($audio);
            $this->assertInstanceOf(Audio::class, $audio);
        }
    }

    /**
     * Test method [getUrl].
     *
     * @return void
     */
    public function testUrl()
    {
        $audioOneUrl = $this->audios[0]->getUrl();
        $this->assertNotFalse(filter_var($audioOneUrl, FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/audio.mp3', $audioOneUrl);

        $audioTwoUrl = $this->audios[1]->getUrl();
        $this->assertNotFalse(filter_var($audioTwoUrl, FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/alternative.mp3', $audioTwoUrl);
    }

    /**
     * Test method [getSecureUrl].
     *
     * @return void
     */
    public function testSecureUrl()
    {
        $audioOneSecureUrl = $this->audios[0]->getSecureUrl();
        $this->assertNotFalse(filter_var($audioOneSecureUrl, FILTER_VALIDATE_URL));
        $this->assertEquals('https://example.com/audio.mp3', $audioOneSecureUrl);

        $this->expectException(AttributeNotFoundException::class);
        $this->audios[1]->getSecureUrl();
    }

    /**
     * Test method [getMimeType].
     *
     * @return void
     */
    public function testMimeType()
    {
        $audioOneMimeType = $this->audios[0]->getMimeType();
        $this->assertEquals('audio/mpeg', $audioOneMimeType);

        $this->expectException(AttributeNotFoundException::class);
        $this->audios[1]->getMimeType();
    }

    /**
     * Test magic [__call] method.
     *
     * @return void
     */
    public function testMagicInvalidGetMethod()
    {
        $this->expectException(MethodNotFoundException::class);

        foreach ($this->audios as $audio) {
            $audio->callNoneExistingGetMethod();
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

        foreach ($this->audios as $audio) {
            $audio->getNonExistingAttribute();
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

        $this->audios = array_key_exists('audio', $data) ? $data['audio'] : null;
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
    <meta property="og:audio" content="http://example.com/audio.mp3">
    <meta property="og:audio:secure_url" content="https://example.com/audio.mp3">
    <meta property="og:audio:type" content="audio/mpeg">
    <meta property="og:audio" content="http://example.com/alternative.mp3">
</head><body></body></html>
HTML;
    }
}

<?php
declare(strict_types=1);

namespace Tests\Namespaces\Twitter;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Rugaard\MetaScraper\Namespaces\Twitter\Twitter;
use Tests\AbstractTestCase;

/**
 * Class AbstractTwitterTestCase.
 */
abstract class AbstractTwitterTestCase extends AbstractTestCase
{
    /**
     * Mocked trait object.
     *
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $trait;

    /**
     * Prepare test case.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->scraper->setClient($this->createMockedGuzzleClient([
            new GuzzleResponse(200, [], $this->getMockedResponse())
        ]))->load('http://127.0.0.1');

        $this->trait = $this->createPartialMock(get_class($this->getMockForTrait(Twitter::class)), ['getAllByNamespace']);
        $this->trait->method('getAllByNamespace')->will($this->returnCallback(function ($namespace) {
            return $this->invokeMethod($this->scraper, 'getAllByNamespace', [$namespace]);
        }));
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

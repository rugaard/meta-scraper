<?php
declare (strict_types = 1);

namespace Tests\Traits\OpenGraph\Objects;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Rugaard\MetaScraper\Traits\OpenGraph\OpenGraph;
use Tests\AbstractTestCase;

/**
 * Class AbstractObjectTestCase.
 */
abstract class AbstractObjectTestCase extends AbstractTestCase
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

        $this->trait = $this->createPartialMock(get_class($this->getMockForTrait(OpenGraph::class)), ['getAllByNamespace']);
        $this->trait->method('getAllByNamespace')->will($this->returnCallback(function ($namespace) {
            return $this->invokeMethod($this->scraper, 'getAllByNamespace', [$namespace]);
        }));

        $this->invokeMethod($this->trait, 'parseOpenGraphObjects', []);
    }
}
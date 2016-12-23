<?php
declare (strict_types = 1);

namespace Tests;

use ReflectionClass;
use PHPUnit\Framework\TestCase;
use Rugaard\MetaScraper\Scraper;

/**
 * Class AbstractTestCase.
 */
abstract class AbstractTestCase extends TestCase
{
    /**
     * Scraper instance
     *
     * @var \Rugaard\MetaScraper\Scraper
     */
    protected $scraper;

    /**
     * Prepare test case.
     *
     * @return void
     */
    public function setUp() : void
    {
        $this->scraper = new Scraper;
    }

    /**
     * Reset test case.
     *
     * @return void
     */
    public function tearDown() : void
    {
        unset($this->scraper);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param  object &$object
     * @param  string $methodName
     * @param  array  $parameters
     * @return mixed
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
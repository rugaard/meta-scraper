<?php
declare (strict_types = 1);

namespace Tests\Namespaces\OpenGraph\Objects;

use DateTime;
use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;
use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;
use Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Fitness;
use Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Place;
use Tests\Namespaces\OpenGraph\AbstractOpenGraphTestCase;

/**
 * Class FitnessTest.
 */
class FitnessTest extends AbstractOpenGraphTestCase
{
    /**
     * Fitness instance
     *
     * @var \Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Fitness|null
     */
    protected $fitness;

    /**
     * Test that object is a Fitness instance.
     *
     * @return void
     */
    public function testIsFitnessInstance()
    {
        $this->assertNotEmpty($this->fitness);
        $this->assertInstanceOf(Fitness::class, $this->fitness);
    }

    /**
     * Test method [getCalories].
     *
     * @return void
     */
    public function testCalories()
    {
        $calories = $this->fitness->getCalories();

        $this->assertNotEmpty($calories);
        $this->assertInternalType('int', $calories);
        $this->assertEquals(1028, $calories);
    }

    /**
     * Test method [getCustomUnitEnergy].
     *
     * @return void
     */
    public function testCustomUnitEnergy()
    {
        $customUnitEnergy = $this->fitness->getCustomUnitEnergy();

        $this->assertNotEmpty($customUnitEnergy);
        $this->assertInternalType('array', $customUnitEnergy);
        $this->assertCount(2, $customUnitEnergy);
        $this->assertArrayHasKey('value', $customUnitEnergy);
        $this->assertEquals(1.28, $customUnitEnergy['value']);
        $this->assertArrayHasKey('units', $customUnitEnergy);
        $this->assertNotFalse(filter_var($customUnitEnergy['units'], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/custom-unit', $customUnitEnergy['units']);
    }

    /**
     * Test method [getDistance].
     *
     * @return void
     */
    public function testDistance()
    {
        $distance = $this->fitness->getDistance();

        $this->assertNotEmpty($distance);
        $this->assertInternalType('array', $distance);
        $this->assertCount(2, $distance);
        $this->assertArrayHasKey('value', $distance);
        $this->assertEquals(5.28, $distance['value']);
        $this->assertArrayHasKey('units', $distance);
        $this->assertEquals('km', $distance['units']);
    }

    /**
     * Test method [getDuration].
     *
     * @return void
     */
    public function testDuration()
    {
        $duration = $this->fitness->getDuration();

        $this->assertNotEmpty($duration);
        $this->assertInternalType('array', $duration);
        $this->assertCount(2, $duration);
        $this->assertArrayHasKey('value', $duration);
        $this->assertEquals(28.07, $duration['value']);
        $this->assertArrayHasKey('units', $duration);
        $this->assertEquals('min', $duration['units']);
    }

    /**
     * Test method [getLiveText].
     *
     * @return void
     */
    public function testLiveText()
    {
        $liveText = $this->fitness->getLiveText();

        $this->assertNotEmpty($liveText);
        $this->assertEquals('Send me cheers!', $liveText);
    }

    /**
     * Test method [getMetrics].
     *
     * @return void
     */
    public function testMetrics()
    {
        $metrics = $this->fitness->getMetrics();

        $this->assertNotEmpty($metrics);
        $this->assertInternalType('array', $metrics);
        $this->assertCount(2, $metrics);

        $this->assertArrayHasKey('location', $metrics[0]);
        $this->assertInstanceOf(Place::class, $metrics[0]['location']);
        $this->assertArrayHasKey('timestamp', $metrics[0]);
        $this->assertInstanceOf(DateTime::class, $metrics[0]['timestamp']);
        $this->assertEquals('2017-01-01T09:15:55+00:00', $metrics[0]['timestamp']->format(DATE_W3C));
        $this->assertArrayHasKey('distance', $metrics[0]);
        $this->assertInternalType('array', $metrics[0]['distance']);
        $this->assertArraySubset(['value' => 2.87, 'units' => 'km'], $metrics[0]['distance']);
        $this->assertArrayHasKey('duration', $metrics[0]);
        $this->assertInternalType('array', $metrics[0]['duration']);
        $this->assertArraySubset(['value' => 15.55, 'units' => 'min'], $metrics[0]['duration']);
        $this->assertArrayHasKey('pace', $metrics[0]);
        $this->assertInternalType('array', $metrics[0]['pace']);
        $this->assertArraySubset(['value' => 5.28, 'units' => 'min/km'], $metrics[0]['pace']);
        $this->assertArrayHasKey('speed', $metrics[0]);
        $this->assertInternalType('array', $metrics[0]['speed']);
        $this->assertArraySubset(['value' => 9.28, 'units' => 'kmh'], $metrics[0]['speed']);
        $this->assertArrayHasKey('steps', $metrics[0]);
        $this->assertEquals(2807, $metrics[0]['steps']);
        $this->assertArrayHasKey('calories', $metrics[0]);
        $this->assertEquals(687, $metrics[0]['calories']);
        $this->assertArrayHasKey('custom_unit_energy', $metrics[0]);
        $this->assertInternalType('array', $metrics[0]['custom_unit_energy']);
        $this->assertEquals(0.78, $metrics[0]['custom_unit_energy']['value']);
        $this->assertNotFalse(filter_var($metrics[0]['custom_unit_energy']['units'], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/custom-unit-metrics', $metrics[0]['custom_unit_energy']['units']);

        $this->assertArrayHasKey('location', $metrics[1]);
        $this->assertInstanceOf(Place::class, $metrics[1]['location']);
        $this->assertArrayHasKey('timestamp', $metrics[1]);
        $this->assertInstanceOf(DateTime::class, $metrics[1]['timestamp']);
        $this->assertEquals('2017-01-01T09:28:07+00:00', $metrics[1]['timestamp']->format(DATE_W3C));
        $this->assertArrayHasKey('distance', $metrics[1]);
        $this->assertInternalType('array', $metrics[1]['distance']);
        $this->assertArraySubset(['value' => 2.41, 'units' => 'km'], $metrics[1]['distance']);
        $this->assertArrayHasKey('duration', $metrics[1]);
        $this->assertInternalType('array', $metrics[1]['duration']);
        $this->assertArraySubset(['value' => 18.13, 'units' => 'min'], $metrics[1]['duration']);
        $this->assertArrayHasKey('pace', $metrics[1]);
        $this->assertInternalType('array', $metrics[1]['pace']);
        $this->assertArraySubset(['value' => 5.07, 'units' => 'min/km'], $metrics[1]['pace']);
        $this->assertArrayHasKey('speed', $metrics[1]);
        $this->assertInternalType('array', $metrics[1]['speed']);
        $this->assertArraySubset(['value' => 8.55, 'units' => 'kmh'], $metrics[1]['speed']);
        $this->assertArrayHasKey('steps', $metrics[1]);
        $this->assertEquals(2187, $metrics[1]['steps']);
        $this->assertArrayHasKey('calories', $metrics[1]);
        $this->assertEquals(341, $metrics[1]['calories']);
        $this->assertArrayHasKey('custom_unit_energy', $metrics[1]);
        $this->assertInternalType('array', $metrics[1]['custom_unit_energy']);
        $this->assertEquals(0.50, $metrics[1]['custom_unit_energy']['value']);
        $this->assertNotFalse(filter_var($metrics[1]['custom_unit_energy']['units'], FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/custom-unit-metrics', $metrics[0]['custom_unit_energy']['units']);
    }

    /**
     * Test method [getPace].
     *
     * @return void
     */
    public function testPace()
    {
        $pace = $this->fitness->getPace();

        $this->assertNotEmpty($pace);
        $this->assertInternalType('array', $pace);
        $this->assertCount(2, $pace);
        $this->assertArrayHasKey('value', $pace);
        $this->assertEquals(5.15, $pace['value']);
        $this->assertArrayHasKey('units', $pace);
        $this->assertEquals('min/km', $pace['units']);
    }

    /**
     * Test method [getSpeed].
     *
     * @return void
     */
    public function testSpeed()
    {
        $speed = $this->fitness->getSpeed();

        $this->assertNotEmpty($speed);
        $this->assertInternalType('array', $speed);
        $this->assertCount(2, $speed);
        $this->assertArrayHasKey('value', $speed);
        $this->assertEquals(9.15, $speed['value']);
        $this->assertArrayHasKey('units', $speed);
        $this->assertEquals('kmh', $speed['units']);
    }

    /**
     * Test method [getSplits].
     *
     * @return void
     */
    public function testSplits()
    {
        $splits = $this->fitness->getSplits();

        $this->assertNotEmpty($splits);
        $this->assertInternalType('array', $splits);
        $this->assertArrayHasKey('unit', $splits);
        $this->assertEquals('km', $splits['unit']);
        $this->assertArrayHasKey('values', $splits);
        $this->assertArraySubset([
            ['value' => 5.28, 'units' => 'min/km'],
            ['value' => 5.07, 'units' => 'min/km'],
        ], $splits['values']);
    }

    /**
     * Test method [getSteps].
     *
     * @return void
     */
    public function testSteps()
    {
        $steps = $this->fitness->getSteps();

        $this->assertNotEmpty($steps);
        $this->assertInternalType('int', $steps);
        $this->assertEquals(4994, $steps);
    }

    /**
     * Test magic [__call] method.
     *
     * @return void
     */
    public function testMagicInvalidGetMethod()
    {
        $this->expectException(MethodNotFoundException::class);
        $this->fitness->callNoneExistingGetMethod();
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
        $this->fitness->getNonExistingAttribute();
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

        $this->fitness = array_key_exists('fitness', $data['objects']) ? $data['objects']['fitness'] : null;
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
    <meta property="fitness:calories" content="1028">
    <meta property="fitness:custom_unit_energy:value" content="1.28">
    <meta property="fitness:custom_unit_energy:units" content="http://example.com/custom-unit">
    <meta property="fitness:distance:value" content="5.28">
    <meta property="fitness:distance:units" content="km">
    <meta property="fitness:duration:value" content="28.07">
    <meta property="fitness:duration:units" content="min">
    <meta property="fitness:live_text" content="Send me cheers!">
    <meta property="fitness:metrics:location:latitude" content="55.618024">
    <meta property="fitness:metrics:location:longitude" content="12.650763">
    <meta property="fitness:metrics:location:altitude" content="3.0">
    <meta property="fitness:metrics:timestamp" content="2017-01-01T09:15:55+00:00">
    <meta property="fitness:metrics:distance:value" content="2.87">
    <meta property="fitness:metrics:distance:units" content="km">
    <meta property="fitness:metrics:duration:value" content="15.55">
    <meta property="fitness:metrics:duration:units" content="min">
    <meta property="fitness:metrics:pace:value" content="5.28">
    <meta property="fitness:metrics:pace:units" content="min/km">
    <meta property="fitness:metrics:speed:value" content="9.28">
    <meta property="fitness:metrics:speed:units" content="kmh">
    <meta property="fitness:metrics:steps" content="2807">
    <meta property="fitness:metrics:calories" content="687">
    <meta property="fitness:metrics:custom_unit_energy:value" content="0.78">
    <meta property="fitness:metrics:custom_unit_energy:units" content="http://example.com/custom-unit-metrics">
    <meta property="fitness:metrics:location:latitude" content="55.676097">
    <meta property="fitness:metrics:location:longitude" content="12.568337">
    <meta property="fitness:metrics:location:altitude" content="6.0">
    <meta property="fitness:metrics:timestamp" content="2017-01-01T09:28:07+00:00">
    <meta property="fitness:metrics:distance:value" content="2.41">
    <meta property="fitness:metrics:distance:units" content="km">
    <meta property="fitness:metrics:duration:value" content="18.13">
    <meta property="fitness:metrics:duration:units" content="min">
    <meta property="fitness:metrics:pace:value" content="5.07">
    <meta property="fitness:metrics:pace:units" content="min/km">
    <meta property="fitness:metrics:speed:value" content="8.55">
    <meta property="fitness:metrics:speed:units" content="kmh">
    <meta property="fitness:metrics:steps" content="2187">
    <meta property="fitness:metrics:calories" content="341">
    <meta property="fitness:metrics:custom_unit_energy:value" content="0.5">
    <meta property="fitness:metrics:custom_unit_energy:units" content="http://example.com/custom-unit-metrics">
    <meta property="fitness:pace:value" content="5.15">
    <meta property="fitness:pace:units" content="min/km">
    <meta property="fitness:speed:value" content="9.15">
    <meta property="fitness:speed:units" content="kmh">
    <meta property="fitness:splits:unit" content="km">
    <meta property="fitness:splits:values:value" content="5.28">
    <meta property="fitness:splits:values:units" content="min/km">
    <meta property="fitness:splits:values:value" content="5.07">
    <meta property="fitness:splits:values:units" content="min/km">
    <meta property="fitness:steps" content="4994">
</head><body></body></html>
HTML;
    }
}
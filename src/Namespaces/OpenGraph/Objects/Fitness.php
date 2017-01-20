<?php
declare(strict_types=1);

namespace Rugaard\MetaScraper\Namespaces\OpenGraph\Objects;

use Illuminate\Support\Collection;
use Rugaard\MetaScraper\Contracts\Item;
use Rugaard\MetaScraper\Meta;

/**
 * Class Fitness.
 *
 * @link https://developers.facebook.com/docs/opengraph/guides/fitness
 * @package Rugaard\MetaScraper\Namespaces\OpenGraph\Objects
 */
class Fitness extends Item
{
    /**
     * Parse fitness object.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return void
     */
    public function parse(Collection $data)
    {
        // Fitness Metrics counter.
        $metricsCount = null;

        // Loop through collection and parse each entry.
        $data->each(function ($item) use (&$metricsCount) {
            // Until proving otherwise ...
            $insideMetrics = false;

            /* @var \Rugaard\MetaScraper\Meta $item */
            $properties = explode(':', $item->getName());

            // Check if we're inside a metric item
            if ($properties[0] == 'metrics') {
                $properties = array_slice($properties, 1);
                $insideMetrics = true;
            }

            switch ($properties[0]) {
                case 'custom_unit_energy':
                case 'distance':
                case 'duration':
                case 'pace':
                case 'speed':
                    $value = $properties[1] == 'value' ? (float) $item->getValue() : $item->getValue();
                    $insideMetrics ? $this->attributes['metrics'][$metricsCount][$properties[0]][$properties[1]] = $value
                                   : $this->attributes[$properties[0]][$properties[1]] = $value;
                    break;
                case 'location':
                    // Whenever we hit the property "latitude" it means
                    // we've should bump the "metrics count" since we've
                    // now started to parse a new ActivityDataPoint (metric).
                    if ($insideMetrics && $properties[1] == 'latitude') {
                        $metricsCount = !is_null($metricsCount) ? $metricsCount + 1 : 0;
                    }

                    if ($insideMetrics && (empty($this->attributes['metrics']) || !array_key_exists($properties[0], $this->attributes['metrics']))) {
                        $this->attributes['metrics'][$metricsCount][$properties[0]] = new Place;
                    } elseif (!$insideMetrics && !array_key_exists($properties[0], $this->attributes)) {
                        $this->attributes[$properties[0]] = new Place;
                    }

                    // Since we have a nested Place object, with information scattered
                    // since another object, we had to start of by creating an empty Place object.
                    // To inject data into the Place object, we need to "fake" that it's being inserted
                    // like it would be, as if it was it's own object instead of being nested.
                    $disguiseDataAsCollection = new Collection([
                        new Meta(['name' => $item->getNameWithNamespace(), 'content' => $item->getValue()]),
                    ]);

                    $insideMetrics ? $this->attributes['metrics'][$metricsCount][$properties[0]]->parse($disguiseDataAsCollection)
                                   : $this->attributes[$properties[0]]->parse($disguiseDataAsCollection);
                    break;
                case 'timestamp':
                    $value = date_create($item->getValue());
                    $insideMetrics ? $this->attributes['metrics'][$metricsCount][$properties[0]] = $value
                                   : $this->attributes[$properties[0]] = $value;
                    break;
                case 'splits':
                    if ($properties[1] == 'unit') {
                        $this->attributes[$properties[0]][$properties[1]] = $item->getValue();
                    } else {
                        $currentKey = isset($this->attributes['splits']) && array_key_exists($properties[1], $this->attributes['splits']) ? count($this->attributes['splits'][$properties[1]]) - 1 : null;
                        if ($properties[2] == 'value') {
                            $currentKey = is_null($currentKey) ? 0 : $currentKey + 1;
                        }
                        $this->attributes['splits'][$properties[1]][$currentKey][$properties[2]] = $item->getValue();
                    }
                    break;
                default:
                    $value = is_numeric($item->getValue()) ? (int) $item->getValue() : $item->getValue();
                    $insideMetrics ? $this->attributes['metrics'][$metricsCount][$properties[0]] = $value
                                   : $this->attributes[$properties[0]] = $value;
            }
        });
    }
}

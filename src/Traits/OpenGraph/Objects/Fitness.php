<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Traits\OpenGraph\Objects;

use Illuminate\Support\Collection;

/**
 * Class Fitness.
 *
 * @package Rugaard\MetaScraper\Traits\OpenGraph\Objects
 */
class Fitness extends AbstractObject
{
    /**
     * Parse fitness object.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return void
     */
    public function parse(Collection $data)
    {
        // Loop through collection and parse each entry.
        $data->each(function($item) {
            // Until proving otherwise ...
            $insideMetrics = false;

            /** @var \Rugaard\MetaScraper\Meta $item */
            $properties = explode(':', $item->getName());

            // Check if we're inside a metric item
            if ($properties[0] == 'metrics') {
                $properties = array_slice($properties, 1);
                $insideMetrics = true;
            }

            switch($properties[0]) {
                case 'custom_unit_energy':
                case 'distance':
                case 'duration':
                case 'pace':
                case 'speed':
                    $value = $properties[1] == 'value' ? (float) $item->getValue() : $item->getValue();
                    $insideMetrics ? $this->attributes['metrics'][$properties[0]][$properties[1]] = $value
                                   : $this->attributes[$properties[0]][$properties[1]] = $value;
                    break;
                case 'location':
                    if ($insideMetrics && !array_key_exists($properties[0], $this->attributes['metrics'])) {
                        $this->attributes['metrics'][$properties[0]] = new Place;
                    } elseif (!$insideMetrics && !array_key_exists($properties[0], $propertyGroup)) {
                        $this->attributes[$properties[0]] = new Place;
                    }

                    $value = $item->getValue();
                    $insideMetrics ? $this->attributes['metrics'][$properties[0]]->{$properties[1]} = $value
                                   : $this->attributes[$properties[0]]->{$properties[1]} = $value;
                    break;
                case 'timestamp':
                    $value = date_create($item->getValue());
                    $insideMetrics ? $this->attributes['metrics'][$properties[0]] = $value
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
                    $insideMetrics ? $this->attributes['metrics'][$properties[0]] = $value
                                   : $this->attributes[$properties[0]] = $value;
            }
        });
    }
}
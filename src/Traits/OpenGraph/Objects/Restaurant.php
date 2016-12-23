<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Traits\OpenGraph\Objects;

use Illuminate\Support\Collection;

/**
 * Class Restaurant.
 *
 * @package Rugaard\MetaScraper\Traits\OpenGraph\Objects
 */
class Restaurant extends AbstractObject
{
    /**
     * Parse restaurant object.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return void
     */
    public function parse(Collection $data) : void
    {
        // Container.
        $propertyGroup = [];

        // Key manager.
        $keyManager = [];

        // Loop through collection and parse each
        // entry and add it to the container (by reference).
        $data->each(function($item) use (&$propertyGroup, &$keyManager) {
            /** @var \Rugaard\MetaScraper\Meta $item */
            $properties = explode(':', $item->getName());
            switch($properties[0]) {
                case 'contact_info':
                    $propertyGroup[$properties[1]] = $item->getValue();
                    break;
                case 'category':
                case 'item':
                case 'section':
                    $propertyGroup[$properties[0]][] = $item->getValue();
                    break;
                case 'price_rating':
                    $propertyGroup[$properties[0]] = (int) $item->getValue();
                    break;
                case 'variation':
                    $currentKey = array_key_exists($properties[0], $keyManager) ? $keyManager[$properties[0]] : null;
                    if (is_null($currentKey) || count($propertyGroup[$properties[0]][$currentKey]) == 2) {
                        $currentKey = !is_null($currentKey) ? $currentKey + 1 : 0;
                        $keyManager[$properties[0]] = $currentKey;
                    }
                    $propertyGroup[$properties[0]][$currentKey][$properties[1]] = $item->getValue();
                    break;
                default:
                    $propertyGroup[$properties[0]] = $item->getValue();
            }
        });

        // Loop through property group and assign
        // each key to a public variable with it's value
        foreach ($propertyGroup as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
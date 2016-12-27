<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Traits\OpenGraph\Objects;

use Illuminate\Support\Collection;

/**
 * Class Business.
 *
 * @package Rugaard\MetaScraper\Traits\OpenGraph\Objects
 */
class Business extends AbstractObject
{
    /**
     * Parse business object.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return void
     */
    public function parse(Collection $data)
    {
        // Container.
        $propertyGroup = [];

        // Loop through collection and parse each
        // entry and add it to the container (by reference).
        $data->each(function($item) use (&$propertyGroup) {
            /** @var \Rugaard\MetaScraper\Meta $item */
            $properties = explode(':', $item->getName());
            switch($properties[0]) {
                case 'contact_data':
                    $propertyGroup[$properties[1]] = $item->getValue();
                    break;
                case 'hours':
                    $currentKey = array_key_exists($properties[0], $propertyGroup) ? count($propertyGroup[$properties[0]]) - 1 : null;
                    if ($properties[1] == 'day') {
                        $currentKey = is_null($currentKey) ? 0 : $currentKey + 1;
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
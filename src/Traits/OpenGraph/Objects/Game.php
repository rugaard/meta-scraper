<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Traits\OpenGraph\Objects;

use Illuminate\Support\Collection;

/**
 * Class Game.
 *
 * @package Rugaard\MetaScraper\Traits\OpenGraph\Objects
 */
class Game extends AbstractObject
{
    /**
     * Parse game object.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return void
     */
    public function parse(Collection $data) : void
    {
        // Container.
        $propertyGroup = [];

        // Loop through collection and parse each
        // entry and add it to the container (by reference).
        $data->each(function($item) use (&$propertyGroup) {
            /** @var \Rugaard\MetaScraper\Meta $item */
            $properties = explode(':', $item->getName());

            switch($properties[0]) {
                case 'importance':
                    $propertyGroup[$properties[0]] = (float) $item->getValue();
                    break;
                case 'points':
                    $propertyGroup[$properties[0]] = (int) $item->getValue();
                    break;
                case 'secret':
                    $propertyGroup[$properties[0]] = $item->getValue() == 'true' ? true : false;
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
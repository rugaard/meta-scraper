<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Traits\OpenGraph\Objects;

use Illuminate\Support\Collection;

/**
 * Class Profile.
 *
 * @package Rugaard\MetaScraper\Traits\OpenGraph\Objects
 */
class Profile extends AbstractObject
{
    /**
     * Parse profile object.
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
            $propertyGroup[$properties[0]] = $item->getValue();
        });

        // Loop through property group and assign
        // each key to a public variable with it's value
        foreach ($propertyGroup as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
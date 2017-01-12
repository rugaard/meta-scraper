<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Namespaces\OpenGraph\Objects;

use Illuminate\Support\Collection;

/**
 * Class Place.
 *
 * @package Rugaard\MetaScraper\Namespaces\OpenGraph\Objects
 */
class Place extends AbstractObject
{
    /**
     * Parse place object.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return void
     */
    public function parse(Collection $data)
    {
        // Loop through collection and parse each entry.
        $data->each(function($item) {
            /* @var \Rugaard\MetaScraper\Meta $item */
            $properties = explode(':', $item->getName());
            $this->attributes[$properties[1]] = $item->getValue();
        });
    }
}
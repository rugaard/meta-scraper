<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Namespaces\OpenGraph\Objects;

use Illuminate\Support\Collection;
use Rugaard\MetaScraper\Contracts\Item;

/**
 * Class Profile.
 *
 * @package Rugaard\MetaScraper\Namespaces\OpenGraph\Objects
 */
class Profile extends Item
{
    /**
     * Parse profile object.
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
            $this->attributes[$properties[0]] = $item->getValue();
        });
    }
}
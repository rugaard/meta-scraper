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
    public function parse(Collection $data)
    {
        // Loop through collection and parse each entry.
        $data->each(function($item) {
            /** @var \Rugaard\MetaScraper\Meta $item */
            $properties = explode(':', $item->getName());
            $this->attributes[$properties[0]] = $item->getValue();
        });
    }
}
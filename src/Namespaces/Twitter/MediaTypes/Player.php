<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes;

use Illuminate\Support\Collection;
use Rugaard\MetaScraper\Contracts\Item;

/**
 * Class Player.
 *
 * @package Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes
 */
class Player extends Item
{
    /**
     * Parse player data.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return void
     */
    protected function parse(Collection $data)
    {
        $data->each(function($item) {
            /* @var \Rugaard\MetaScraper\Meta $item */
            $properties = explode(':', $item->getName());

            $property = count($properties) > 1 ? $properties[1] : 'url';
            switch($property) {
                case 'stream':
                    if (count($properties) > 2 && $properties[2] == 'content_type') {
                        $this->attributes[$property]['type'] = $item->getValue();
                    } else {
                        $this->attributes[$property]['url'] = $item->getValue();
                    }
                    break;
                default:
                    $this->attributes[$property] = $item->getValue();
            }
        });
    }
}
<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Namespaces\OpenGraph\Objects;

use Illuminate\Support\Collection;

/**
 * Class Restaurant.
 *
 * @package Rugaard\MetaScraper\Namespaces\OpenGraph\Objects
 */
class Restaurant extends AbstractObject
{
    /**
     * Parse restaurant object.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return void
     */
    public function parse(Collection $data)
    {
        // Key manager.
        $keyManager = [];

        // Loop through collection and parse each entry.
        $data->each(function($item) use (&$keyManager) {
            /* @var \Rugaard\MetaScraper\Meta $item */
            $properties = explode(':', $item->getName());
            switch($properties[0]) {
                case 'contact_info':
                    $this->attributes[$properties[1]] = $item->getValue();
                    break;
                case 'category':
                case 'item':
                case 'menu':
                case 'section':
                    $this->attributes[$properties[0]][] = $item->getValue();
                    break;
                case 'price_rating':
                    $this->attributes[$properties[0]] = (int) $item->getValue();
                    break;
                case 'variation':
                    $currentKey = array_key_exists($properties[0], $keyManager) ? $keyManager[$properties[0]] : null;
                    if (is_null($currentKey) || count($this->attributes[$properties[0]][$currentKey]) == 2) {
                        $currentKey = !is_null($currentKey) ? $currentKey + 1 : 0;
                        $keyManager[$properties[0]] = $currentKey;
                    }

                    if ($properties[1] == 'price') {
                        $this->attributes[$properties[0]][$currentKey][$properties[1]][$properties[2]] = $item->getValue();
                    } else {
                        $this->attributes[$properties[0]][$currentKey][$properties[1]] = $item->getValue();
                    }
                    break;
                default:
                    $this->attributes[$properties[0]] = $item->getValue();
            }
        });
    }
}
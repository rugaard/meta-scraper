<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Namespaces\OpenGraph\Objects;

use Illuminate\Support\Collection;

/**
 * Class Video.
 *
 * @package Rugaard\MetaScraper\Namespaces\OpenGraph\Objects
 */
class Video extends AbstractObject
{
    /**
     * Parse video object.
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
                case 'actor':
                    $currentKey = array_key_exists($properties[0], $keyManager) ? $keyManager[$properties[0]] : null;
                    if (is_null($currentKey) || $properties[1] == 'id') {
                        $currentKey = !is_null($currentKey) ? $currentKey + 1 : 0;
                        $keyManager[$properties[0]] = $currentKey;
                    }
                    $this->attributes[$properties[0]][$currentKey][$properties[1]] = $item->getValue();
                    break;
                case 'director':
                case 'tag':
                case 'writer':
                    $this->attributes[$properties[0]][] = $item->getValue();
                    break;
                case 'duration':
                    $this->attributes[$properties[0]] = (int) $item->getValue();
                    break;
                case 'release_date':
                    $this->attributes[$properties[0]] = date_create($item->getValue());
                    break;
                default:
                    $this->attributes[$properties[0]] = $item->getValue();
            }
        });
    }
}
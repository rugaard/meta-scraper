<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Namespaces\OpenGraph\Objects;

use Illuminate\Support\Collection;

/**
 * Class Music.
 *
 * @package Rugaard\MetaScraper\Namespaces\OpenGraph\Objects
 */
class Music extends AbstractObject
{
    /**
     * Parse music object.
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
                case 'album':
                case 'song':
                case 'preview_url':
                    $currentKey = array_key_exists($properties[0], $keyManager) ? $keyManager[$properties[0]] : null;
                    if (is_null($currentKey) || $properties[1] == 'url') {
                        $currentKey = !is_null($currentKey) ? $currentKey + 1 : 0;
                        $keyManager[$properties[0]] = $currentKey;
                    }
                    $this->attributes[$properties[0]][$currentKey][$properties[1]] = is_numeric($item->getValue()) ? (int) $item->getValue() : $item->getValue();
                    break;
                case 'musician':
                    $this->attributes[$properties[0]][] = $item->getValue();
                    break;
                case 'duration':
                case 'song_count':
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
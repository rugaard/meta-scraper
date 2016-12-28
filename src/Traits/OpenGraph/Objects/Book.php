<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Traits\OpenGraph\Objects;

use Illuminate\Support\Collection;

/**
 * Class Book.
 *
 * @package Rugaard\MetaScraper\Traits\OpenGraph\Objects
 */
class Book extends AbstractObject
{
    /**
     * Parse book object.
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
            switch($properties[0]) {
                case 'author':
                case 'book':
                case 'genre':
                case 'language':
                    $this->attributes[$properties[0]][] = $item->getValue();
                    break;
                case 'page_count':
                    $this->attributes[$properties[0]] = (int) $item->getValue();
                    break;
                case 'rating':
                    $this->attributes[$properties[0]][$properties[1]] = $properties[1] == 'value' ? (float) $item->getValue() : (int) $item->getValue();
                    break;
                case 'initial_release_date':
                case 'release_date':
                    $this->attributes[$properties[0]] = date_create($item->getValue());
                    break;
                default:
                    $this->attributes[$properties[0]] = $item->getValue();
            }
        });
    }
}
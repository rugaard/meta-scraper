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
        // Container.
        $propertyGroup = [];

        // Loop through collection and parse each
        // entry and add it to the container (by reference).
        $data->each(function($item) use (&$propertyGroup) {
            /** @var \Rugaard\MetaScraper\Meta $item */
            $properties = explode(':', $item->getName());
            switch($properties[0]) {
                case 'author':
                case 'book':
                case 'genre':
                case 'language':
                    $propertyGroup[$properties[0]][] = $item->getValue();
                    break;
                case 'page_count':
                    $propertyGroup[$properties[0]] = (int) $item->getValue();
                    break;
                case 'rating':
                    $propertyGroup[$properties[0]][$properties[1]] = $properties[1] == 'value' ? (float) $item->getValue() : (int) $item->getValue();
                    break;
                case 'initial_release_date':
                case 'release_date':
                    $propertyGroup[$properties[0]] = date_create($item->getValue());
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
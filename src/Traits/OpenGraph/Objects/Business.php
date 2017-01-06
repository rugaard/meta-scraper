<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Traits\OpenGraph\Objects;

use Illuminate\Support\Collection;

/**
 * Class Business.
 *
 * @package Rugaard\MetaScraper\Traits\OpenGraph\Objects
 */
class Business extends AbstractObject
{
    /**
     * Parse business object.
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
            switch($properties[0]) {
                case 'contact_data':
                    $this->attributes[$properties[1]] = $item->getValue();
                    break;
                case 'hours':
                    $currentKey = array_key_exists($properties[0], $this->attributes) ? count($this->attributes[$properties[0]]) - 1 : null;
                    if ($properties[1] == 'day') {
                        $currentKey = is_null($currentKey) ? 0 : $currentKey + 1;
                    }
                    $this->attributes[$properties[0]][$currentKey][$properties[1]] = $item->getValue();
                    break;
                default:
                    $this->attributes[$properties[0]] = $item->getValue();
            }
        });
    }
}
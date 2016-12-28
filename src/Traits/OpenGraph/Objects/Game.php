<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Traits\OpenGraph\Objects;

use Illuminate\Support\Collection;

/**
 * Class Game.
 *
 * @package Rugaard\MetaScraper\Traits\OpenGraph\Objects
 */
class Game extends AbstractObject
{
    /**
     * Parse game object.
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
                case 'importance':
                    $this->attributes[$properties[0]] = (float) $item->getValue();
                    break;
                case 'points':
                    $this->attributes[$properties[0]] = (int) $item->getValue();
                    break;
                case 'secret':
                    $this->attributes[$properties[0]] = $item->getValue() == 'true' ? true : false;
                    break;
                default:
                    $this->attributes[$properties[0]] = $item->getValue();
            }
        });
    }
}
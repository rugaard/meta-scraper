<?php
declare(strict_types=1);

namespace Rugaard\MetaScraper\Namespaces\OpenGraph\Objects;

use Illuminate\Support\Collection;
use Rugaard\MetaScraper\Contracts\Item;

/**
 * Class Game.
 *
 * @package Rugaard\MetaScraper\Namespaces\OpenGraph\Objects
 */
class Game extends Item
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
        $data->each(function ($item) {
            /* @var \Rugaard\MetaScraper\Meta $item */
            $properties = explode(':', $item->getName());

            switch ($properties[0]) {
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

<?php
declare(strict_types=1);

namespace Rugaard\MetaScraper\Namespaces\OpenGraph\MediaTypes;

use Illuminate\Support\Collection;
use Rugaard\MetaScraper\Contracts\Item;

/**
 * Class Audio.
 *
 * @package Rugaard\MetaScraper\Namespaces\OpenGraph\Objects
 */
class Audio extends Item
{
    /**
     * Parse audio data.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return void
     */
    public function parse(Collection $data)
    {
        $data->each(function ($item) {
            /* @var \Rugaard\MetaScraper\Meta $item */
            $properties = explode(':', $item->getName());

            // Support "hidden" URL property
            $property = count($properties) > 1 ? $properties[1] : 'url';

            switch ($property) {
                case 'type':
                    $this->attributes['mime_type'] = $item->getValue();
                    break;
                default:
                    $this->attributes[$property] = $item->getValue();
            }
        });
    }
}

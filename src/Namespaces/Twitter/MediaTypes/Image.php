<?php
declare(strict_types=1);

namespace Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes;

use Illuminate\Support\Collection;
use Rugaard\MetaScraper\Contracts\Item;

/**
 * Class Image.
 *
 * @package Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes
 */
class Image extends Item
{
    /**
     * Parse image data.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return void
     */
    protected function parse(Collection $data)
    {
        $data->each(function ($item) {
            /* @var \Rugaard\MetaScraper\Meta $item */
            $properties = explode(':', $item->getName());

            $property = count($properties) > 1 ? $properties[1] : 'url';
            switch ($property) {
                case 'alt':
                    $this->attributes['description'] = $item->getValue();
                    break;
                default:
                    $this->attributes[$property] = $item->getValue();
            }
        });
    }
}

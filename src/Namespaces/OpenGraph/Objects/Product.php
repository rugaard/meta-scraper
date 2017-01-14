<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Namespaces\OpenGraph\Objects;

use Illuminate\Support\Collection;
use Rugaard\MetaScraper\Contracts\Item;

/**
 * Class Product.
 *
 * @package Rugaard\MetaScraper\Namespaces\OpenGraph\Objects
 */
class Product extends Item
{
    /**
     * Parse product object.
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
                case 'original_price':
                case 'pretax_price':
                case 'price':
                case 'sale_price':
                case 'shipping_cost':
                    $this->attributes[$properties[0]][$properties[1]] = $properties[1] == 'amount' ? (float) $item->getValue() : $item->getValue();
                    break;
                case 'shipping_weight':
                case 'weight':
                    $this->attributes[$properties[0]][$properties[1]] = $properties[1] == 'value' ? (float) $item->getValue() : $item->getValue();
                    break;
                case 'purchase_limit':
                    $this->attributes[$properties[0]] = (int) $item->getValue();
                    break;
                case 'is_product_shareable':
                    $this->attributes[$properties[0]] = $item->getValue() == 'true' ? true : false;
                    break;
                case 'expiration_time':
                case 'sale_price_dates':
                    count($properties) > 1 ? $this->attributes[$properties[0]][$properties[1]] = date_create($item->getValue())
                                           : $this->attributes[$properties[0]] = date_create($item->getValue());
                    break;
                default:
                    $this->attributes[$properties[0]] = $item->getValue();
            }
        });
    }
}
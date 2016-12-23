<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Traits\OpenGraph\Objects;

use Illuminate\Support\Collection;

/**
 * Class Product.
 *
 * @package Rugaard\MetaScraper\Traits\OpenGraph\Objects
 */
class Product extends AbstractObject
{
    /**
     * Parse product object.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return void
     */
    public function parse(Collection $data) : void
    {
        // Container.
        $propertyGroup = [];

        // Key manager.
        $keyManager = [];

        // Loop through collection and parse each
        // entry and add it to the container (by reference).
        $data->each(function($item) use (&$propertyGroup, &$keyManager) {
            /** @var \Rugaard\MetaScraper\Meta $item */
            $properties = explode(':', $item->getName());

            switch($properties[0]) {
                case 'original_price':
                case 'pretax_price':
                case 'price':
                case 'sale_price':
                case 'shipping_cost':
                    $currentKey = array_key_exists($properties[0], $keyManager) ? $keyManager[$properties[0]] : null;
                    if (is_null($currentKey) || count($propertyGroup[$properties[0]][$currentKey]) == 2) {
                        $currentKey = !is_null($currentKey) ? $currentKey + 1 : 0;
                        $keyManager[$properties[0]] = $currentKey;
                    }
                    $propertyGroup[$properties[0]][$currentKey][$properties[1]] = $properties[1] == 'amount' ? (float) $item->getValue() : $item->getValue();
                    break;
                case 'shipping_weight':
                case 'weight':
                    $propertyGroup[$properties[0]][$properties[1]] = $properties[1] == 'value' ? (float) $item->getValue() : $item->getValue();
                    break;
                case 'purchase_limit':
                    $propertyGroup[$properties[0]] = (int) $item->getValue();
                    break;
                case 'is_product_shareable':
                    $propertyGroup[$properties[0]] = $item->getValue() == 'true' ? true : false;
                    break;
                case 'expiration_time':
                case 'sale_price_dates':
                    count($properties) > 1 ? $propertyGroup[$properties[0]][$properties[1]] = date_create($item->getValue())
                                           : $propertyGroup[$properties[0]] = date_create($item->getValue());
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
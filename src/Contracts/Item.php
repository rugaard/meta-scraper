<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Contracts;

use Illuminate\Support\Collection;
use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;
use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;

/**
 * Class Item.
 *
 * @abstract
 * @package Rugaard\MetaScraper\Contracts\Item
 */
abstract class Item
{
    /**
     * Array of attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Item constructor.
     *
     * @param \Illuminate\Support\Collection $data
     */
    public function __construct(Collection $data = null)
    {
        $data = $data ?: new Collection;
        $this->parse($data);
    }

    /**
     * Parse item data.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return void
     */
    abstract protected function parse(Collection $data);

    /**
     * __call.
     *
     * @param  string $name
     * @param  array  $arguments
     * @return mixed
     * @throws \Rugaard\MetaScraper\Exceptions\MethodNotFoundException
     * @throws \Rugaard\MetaScraper\Exceptions\AttributeNotFoundException
     */
    public function __call($name, $arguments)
    {
        // If $name does not start with "get"
        // then we do not support the request.
        if (substr($name, 0, 3) != 'get') {
            throw new MethodNotFoundException(sprintf('Method [%s] not found.', $name), 500);
        }

        // Convert name into a snake_case attribute.
        $attribute = snake_case($name);

        // Make sure attribute exists.
        if (!array_key_exists($attribute, $this->attributes)) {
            throw new AttributeNotFoundException(sprintf('Attribute [%s] not found.', $attribute), 500);
        }

        return $this->attributes[$attribute];
    }
}
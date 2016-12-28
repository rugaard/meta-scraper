<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Traits\OpenGraph\Objects;

use Illuminate\Support\Collection;

/**
 * Class AbstractObject.
 *
 * @package Rugaard\MetaScraper\Traits\OpenGraph\Objects
 */
abstract class AbstractObject
{
    protected $attributes = [];

    /**
     * AbstractObject constructor.
     *
     * @param \Illuminate\Support\Collection $data
     */
    public function __construct(Collection $data = null)
    {
        if (!is_null($data) && !$data->isEmpty()) {
            $this->parse($data);
        }
    }

    /**
     * Parse object type.
     *
     * @param  \Illuminate\Support\Collection $data
     * @return void
     */
    abstract public function parse(Collection $data);

    public function __call($name, $arguments)
    {
        if (substr($name, 0, 3) != 'get') {
            die('Method found');
        }

        $attribute = strtolower(preg_replace('/(?<=\\w)(?=[A-Z])/',"_$1", substr($name, 3)));
        if (!array_key_exists($attribute, $this->attributes)) {
            die('Attribute does not exist');
        }

        return $this->attributes[$attribute];
    }
}
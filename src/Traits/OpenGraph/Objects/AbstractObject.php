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
    abstract public function parse(Collection $data)
}
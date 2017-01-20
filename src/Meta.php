<?php
declare(strict_types=1);

namespace Rugaard\MetaScraper;

use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;

/**
 * Class Meta.
 *
 * @package Rugaard\MetaScraper
 */
class Meta
{
    /**
     * Array of attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Namespace of <meta> tag.
     *
     * @var string
     */
    protected $namespace;

    /**
     * Map name and value to original attribute.
     *
     * @var array
     */
    private $mappings = [];

    /**
     * Meta constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->parseAttributes($attributes);
    }

    /**
     * Parse attributes to provide more consistent naming.
     *
     * @param  array $data
     * @return \Rugaard\MetaScraper\Meta
     */
    private function parseAttributes(array $data) : Meta
    {
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'name':
                case 'equiv':
                case 'http-equiv':
                case 'property':
                case 'itemprop':
                    // Add original property name to mappings array
                    $this->mappings['name'] = $key;

                    // Split property name into potential namespace
                    $name = explode(':', $value);
                    if (count($name) > 1) {
                        $this->namespace = $name[0];
                        $this->attributes['name'] = implode(':', array_splice($name, 1));
                    } else {
                        $this->attributes['name'] = $name[0];
                    }
                    break;
                default:
                    // Add original property value to mappings array
                    $this->mappings['value'] = $key;
                    $this->attributes['value'] = $value;
            }
        }

        return $this;
    }

    /**
     * Check if tag has attribute.
     *
     * @param  string $key
     * @return bool
     */
    public function hasAttribute($key) : bool
    {
        return array_key_exists($key, $this->attributes);
    }

    /**
     * Get attribute of tag.
     *
     * @param  string $key
     * @return string
     * @throws \Rugaard\MetaScraper\Exceptions\AttributeNotFoundException
     */
    public function getAttribute($key) : string
    {
        if (!$this->hasAttribute($key)) {
            throw new AttributeNotFoundException(sprintf('Attribute [%s] not found', $key), 500);
        }

        return $this->attributes[$key];
    }

    /**
     * Check if meta tag is part of a namespace.
     *
     * @return bool
     */
    public function hasNamespace() : bool
    {
        return !is_null($this->namespace);
    }

    /**
     * Get namespace of meta tag.
     *
     * @return string
     * @throws \Rugaard\MetaScraper\Exceptions\AttributeNotFoundException
     */
    public function getNamespace() : string
    {
        if (!$this->hasNamespace()) {
            throw new AttributeNotFoundException('Meta tag does not have a namespace.', 500);
        }

        return $this->namespace;
    }

    /**
     * Get name of meta tag.
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->getAttribute('name');
    }

    /**
     * Get name of meta tag with it's namespace.
     *
     * @return string
     */
    public function getNameWithNamespace() : string
    {
        return $this->hasNamespace() ? sprintf('%s:%s', $this->getNamespace(), $this->getName()) : $this->getName();
    }

    /**
     * Get value of meta tag.
     *
     * @return string
     */
    public function getValue() : string
    {
        return $this->getAttribute('value');
    }
}

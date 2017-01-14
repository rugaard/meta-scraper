<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Namespaces\OpenGraph;

use Illuminate\Support\Collection;
use Rugaard\MetaScraper\Namespaces\OpenGraph\MediaTypes\Audio;
use Rugaard\MetaScraper\Namespaces\OpenGraph\MediaTypes\Image;
use Rugaard\MetaScraper\Namespaces\OpenGraph\MediaTypes\Video;
use Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Book as ObjectBook;
use Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Business as ObjectBusiness;
use Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Fitness as ObjectFitness;
use Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Game as ObjectGame;
use Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Music as ObjectMusic;
use Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Place as ObjectPlace;
use Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Product as ObjectProduct;
use Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Profile as ObjectProfile;
use Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Restaurant as ObjectRestaurant;
use Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Video as ObjectVideo;

/**
 * Trait OpenGraph.
 *
 * @trait
 * @package Rugaard\MetaScraper\Namespaces\OpenGraph
 */
trait OpenGraph
{
    /**
     * Open Graph data.
     *
     * @var array
     */
    protected $openGraph = [];

    /**
     * Get Open Graph details.
     *
     * @return array
     */
    public function openGraph() : array
    {
        // Get all tags with Open Graph namespace.
        $openGraphTags = $this->getAllByNamespace('og');

        // Parse all standard Open Graph properties.
        $this->parseOpenGraphStandard($openGraphTags);

        // Parse all Open Graph media types.
        $this->parseOpenGraphMedia($openGraphTags);

        // Parse all Open Graph object types
        $this->parseOpenGraphObjects();

        return $this->getOpenGraph();
    }

    /**
     * Parse standard Open Graph properties.
     *
     * @param  \Illuminate\Support\Collection $tags
     * @return void
     */
    private function parseOpenGraphStandard(Collection $tags)
    {
        foreach ($this->getOpenGraphStandardProperties() as $property) {
            // Loop through our collection of tags and carefully
            // select only those that matches our current property.
            $matches = $tags->filter(function ($tag) use ($property) {
                // We split on ":" so potential structural properties
                // will also be included in our matches.
                /* @var \Rugaard\MetaScraper\Meta $tag */
                return explode(':', $tag->getName())[0] == $property;
            });

            // No matches found.
            // Move on to next property.
            if ($matches->isEmpty()) {
                continue;
            }

            switch ($property) {
                // Locale property.
                case 'locale':
                    $matches->each(function ($item) use ($property) {
                        /* @var \Rugaard\MetaScraper\Meta $item */
                        $this->openGraph[$property][] = $item->getValue();
                    });
                    break;
                // Restrictions property.
                case 'restrictions':
                    $matches->each(function ($item) use ($property) {
                        /* @var \Rugaard\MetaScraper\Meta $item */
                        $itemProperties = array_slice(explode(':', $item->getName()), 1);
                        if (count($itemProperties) > 1) {
                            $this->openGraph[$property][sprintf('%s_%s', $itemProperties[0], $itemProperties[1])][] = $item->getValue();
                        } else {
                            $this->openGraph[$property][$itemProperties[0]] = $item->getValue();
                        }
                    });
                    break;
                case 'rich_attachment':
                    $this->openGraph[$property] = $matches->first()->getValue() == 'true' ? true : false;
                    break;
                case 'updated_time':
                    $this->openGraph[$property] = date_create($matches->first()->getValue());
                    break;
                // Standard properties.
                default:
                    $this->openGraph[$property] = $matches->first()->getValue();
            }
        }
    }

    /**
     * Parse Open Graph media types.
     *
     * @param  \Illuminate\Support\Collection $tags
     * @return void
     */
    private function parseOpenGraphMedia(Collection $tags)
    {
        foreach ($this->getOpenGraphMediaTypes() as $mediaType => $mediaTypeClass) {
            // Loop through our collection of tags and carefully
            // select only those that matches our current property.
            $matches = $tags->filter(function ($tag) use ($mediaType) {
                // We split on ":" so potential structural properties
                // will also be included in our matches.
                /* @var \Rugaard\MetaScraper\Meta $tag */
                return explode(':', $tag->getName())[0] == $mediaType;
            });

            // No matches found.
            // Move on to next property.
            if ($matches->isEmpty()) {
                continue;
            }

            // Container used to group images
            $images = [];

            // Iteration counter
            $iteration = 0;

            $matches->each(function($item) use (&$images, &$iteration) {
                /* @var \Rugaard\MetaScraper\Meta $item */
                $properties = explode(':', $item->getName());

                if (is_null($iteration) || count($properties) == 1 || $properties[1] == 'url') {
                    $iteration = !is_null($iteration) ? $iteration + 1 : 0;
                }

                $images[$iteration][] = $item;
            });

            collect($images)->each(function($image) use ($mediaType, $mediaTypeClass) {
                $this->openGraph[$mediaType][] = new $mediaTypeClass(new Collection($image));
            });

        }
    }

    /**
     * Parse Open Graph object types.
     *
     * @return void
     */
    private function parseOpenGraphObjects()
    {
        foreach ($this->getOpenGraphObjectTypes() as $objectType => $objectTypeClass) {
            /** @var \Illuminate\Support\Collection $tags */
            $tags = $this->getAllByNamespace($objectType);
            if ($tags->isEmpty()) {
                continue;
            }

            $this->openGraph['objects'][$objectType] = new $objectTypeClass($tags);
        }
    }

    /**
     * Get parsed Open Graph data.
     *
     * @return array
     */
    public function getOpenGraph() : array
    {
        return $this->openGraph;
    }

    /**
     * Get all supported Open Graph standard properties.
     *
     * @return array
     */
    private function getOpenGraphStandardProperties() : array
    {
        return [
            'title',
            'type',
            'url',
            'description',
            'locale',
            'site_name',
            'determiner',
            'updated_time',
            'see_also',
            'rich_attachment',
            'ttl',
            'restrictions',
        ];
    }

    /**
     * Get all supported Open Graph media properties.
     *
     * @return array
     */
    private function getOpenGraphMediaTypes() : array
    {
        return [
            'image' => Image::class,
            'video' => Video::class,
            'audio' => Audio::class,
        ];
    }

    /**
     * Get all supported Open Graph object types.
     *
     * @return array
     */
    private function getOpenGraphObjectTypes() : array
    {
        return [
            'books' => ObjectBook::class,
            'business' => ObjectBusiness::class,
            'fitness' => ObjectFitness::class,
            'game' => ObjectGame::class,
            'music' => ObjectMusic::class,
            'place' => ObjectPlace::class,
            'product' => ObjectProduct::class,
            'profile' => ObjectProfile::class,
            'restaurant' => ObjectRestaurant::class,
            'video' => ObjectVideo::class,
        ];
    }
}
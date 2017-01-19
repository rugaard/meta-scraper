<?php
declare(strict_types=1);

namespace Rugaard\MetaScraper\Namespaces\Twitter;

use Illuminate\Support\Collection;
use Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\App;
use Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\Image;
use Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\Player;

/**
 * Trait Twitter.
 *
 * @trait
 * @package Rugaard\MetaScraper\Namespaces\Twitter
 */
trait Twitter
{
    /**
     * Twitter data.
     *
     * @var array
     */
    protected $twitter = [];

    /**
     * Get Twitter details.
     *
     * @return array
     */
    public function twitter() : array
    {
        // Get all tags with Twitter namespace.
        $twitterTags = $this->getAllByNamespace('twitter');

        // Parse all standard Twitter properties.
        $this->parseTwitterStandard($twitterTags);

        // Parse all Twitter media properties.
        $this->parseTwitterMedia($twitterTags);

        return $this->getTwitter();
    }

    /**
     * Parse standard Twitter properties.
     *
     * @param  \Illuminate\Support\Collection $tags
     * @return void
     */
    private function parseTwitterStandard(Collection $tags)
    {
        foreach ($this->getTwitterStandardProperties() as $property) {
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

            // Add property to parsed data container.
            $this->twitter[$property] = $matches->first()->getValue();
        }
    }

    /**
     * Parse Twitter media.
     *
     * @param  \Illuminate\Support\Collection $tags
     * @return void
     */
    public function parseTwitterMedia(Collection $tags)
    {
        foreach ($this->getTwitterMediaTypes() as $mediaType => $mediaTypeClass) {
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

            $this->twitter[$mediaType] = new $mediaTypeClass($matches);
        }
    }

    /**
     * Get parsed Twitter data.
     *
     * @return array
     */
    public function getTwitter() : array
    {
        return $this->twitter;
    }

    /**
     * Get all supported Twitter standard properties.
     *
     * @return array
     */
    private function getTwitterStandardProperties() : array
    {
        return [
            'title',
            'description',
            'card',
            'site',
            'creator',
        ];
    }

    /**
     * Get all supported Twitter media types.
     *
     * @return array
     */
    private function getTwitterMediaTypes() : array
    {
        return [
            'app' => App::class,
            'image' => Image::class,
            'player' => Player::class,
        ];
    }
}

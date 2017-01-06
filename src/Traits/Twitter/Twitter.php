<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Traits\Twitter;

use Illuminate\Support\Collection;

/**
 * Trait Twitter.
 *
 * @package Rugaard\MetaScraper\Traits\Twitter
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
                /** @var \Rugaard\MetaScraper\Meta $tag */
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
}
<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Namespaces\Twitter;

use Illuminate\Support\Collection;
use Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\App;
use Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\Image;
use Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\Player;

/**
 * Trait Twitter.
 *
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

        $this->parseTwitterMediaTypes($twitterTags);

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
     * Parse Twitter media types.
     *
     * @param  \Illuminate\Support\Collection $tags
     * @return void
     */
    public function parseTwitterMediaTypes(Collection $tags)
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

            // Determine which item iteration
            // we're currently trying to parse.
            $iteration = null;

            $matches->each(function ($item) use ($mediaTypeClass, &$iteration) {
                /* @var \Rugaard\MetaScraper\Meta $item */
                $properties = explode(':', $item->getName());

                // Add media type to Twitter container
                if (!array_key_exists($properties[0], $this->twitter)) {
                    $this->twitter[$properties[0]] = new $mediaTypeClass;
                }

                // I don't know what the guys at Twitter has been smoking,
                // but not grouping id, name and URL by device is just idiotic.
                //
                // For that reason, we need to make a special "app" switch case,
                // to keep the consistency throughout the package.
                if ($properties[0] == 'app') {
                    switch ($properties[1]) {
                        case 'id':
                        case 'name':
                        case 'url':
                            $this->twitter[$properties[0]]->{'set' . camel_case($properties[2])}($properties[1], $item->getValue());
                            break;
                        default:
                            $this->twitter[$properties[0]]->{$properties[1]} = $item->getValue();
                    }
                } else {
                    $property = count($properties) > 1 ? $properties[1] : 'url';
                    switch ($property) {
                        case 'alt':
                            $this->twitter[$properties[0]]->setDescription($item->getValue());
                            break;
                        case 'stream':
                            if (count($properties) > 2 && $properties[2] == 'content_type') {
                                $this->twitter[$properties[0]]->setVideoType($item->getValue());
                            } else {
                                $this->twitter[$properties[0]]->setVideoUrl($item->getValue());
                            }
                            break;
                        default:
                            $this->twitter[$properties[0]]->{$property} = $item->getValue();
                    }
                }
            });
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
<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Traits\Facebook;

use Illuminate\Support\Collection;

/**
 * Trait Facebook.
 *
 * @package Rugaard\MetaScraper\Traits\Facebook
 */
trait Facebook
{
    /**
     * Facebook data.
     *
     * @var array
     */
    protected $facebook = [];

    /**
     * Get Facebook details.
     *
     * @return array
     */
    public function facebook() : array
    {
        // Get all tags with Facebook namespace.
        $facebookTags = $this->getAllByNamespace('fb');

        // Parse Facebook App ID
        $this->parseFacebookAppId($facebookTags);

        // Parse Facebook App admins
        $this->parseFacebookAppAdmins($facebookTags);

        return $this->getFacebook();
    }

    /**
     * Parse Facebook App ID.
     *
     * @param \Illuminate\Support\Collection $tags
     * @return void
     */
    private function parseFacebookAppId(Collection $tags)
    {
        // Loop through our collection of tags and carefully
        // select only those that matches our current property.
        $facebookAppIdTag = $tags->filter(function ($tag) {
            // We split on ":" so potential structural properties
            // will also be included in our matches.
            /* @var \Rugaard\MetaScraper\Meta $tag */
            return explode(':', $tag->getName())[0] == 'app_id';
        })->first();

        // No matches found.
        // Move on to next property.
        if (!$facebookAppIdTag) {
            return;
        }

        // Add Facebook App ID to parsed data container.
        $this->facebook['app_id'] = $facebookAppIdTag->getValue();
    }

    /**
     * Parse Facebook App Admins.
     *
     * @param \Illuminate\Support\Collection $tags
     * @return void
     */
    private function parseFacebookAppAdmins(Collection $tags)
    {
        // Loop through our collection of tags and carefully
        // select only those that matches our current property.
        $facebookAppAdminsTag = $tags->filter(function ($tag) {
            // We split on ":" so potential structural properties
            // will also be included in our matches.
            /* @var \Rugaard\MetaScraper\Meta $tag */
            return explode(':', $tag->getName())[0] == 'admins';
        })->first();

        // No matches found.
        // Move on to next property.
        if (!$facebookAppAdminsTag) {
            return;
        }

        // Add Facebook App ID to parsed data container.
        $this->facebook['admins'] = explode(',', str_replace(' ', '', $facebookAppAdminsTag->getValue()));
    }

    /**
     * Get parsed Facebook data.
     *
     * @return array
     */
    public function getFacebook() : array
    {
        return $this->facebook;
    }
}
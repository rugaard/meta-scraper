<?php
declare (strict_types = 1);

namespace Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes;

/**
 * Class App.
 *
 * @package Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes
 */
class App extends AbstractMediaType
{
    /**
     * iPhone details.
     *
     * @var array
     */
    protected $iPhone;

    /**
     * iPad details.
     *
     * @var array
     */
    protected $iPad;

    /**
     * Google Play details.
     *
     * @var array
     */
    protected $googlePlay;

    /**
     * App Country.
     *
     * @var string
     */
    protected $country;

    /**
     * Set iPhone details.
     *
     * @param  string $field
     * @param  string $value
     * @return \Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\App
     */
    public function setIPhone($field, $value) : App
    {
        $this->iPhone[$field] = $value;
        return $this;
    }

    /**
     * Get iPhone details.
     *
     * @return array
     */
    public function getIPhone() : array
    {
        return (array) $this->iPhone;
    }

    /**
     * Set iPad details.
     *
     * @param  string $field
     * @param  string $value
     * @return \Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\App
     */
    public function setIPad($field, $value) : App
    {
        $this->iPad[$field] = $value;
        return $this;
    }

    /**
     * Get iPad details.
     *
     * @return array
     */
    public function getIPad() : array
    {
        return (array) $this->iPad;
    }

    /**
     * Set Google Play details.
     *
     * @param  string $field
     * @param  string $value
     * @return \Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\App
     */
    public function setGooglePlay($field, $value) : App
    {
        $this->googlePlay[$field] = $value;
        return $this;
    }

    /**
     * Get Google Play details
     *
     * @return array
     */
    public function getGooglePlay() : array
    {
        return (array) $this->googlePlay;
    }

    /**
     * Set App country.
     *
     * @param  string $country
     * @return \Rugaard\MetaScraper\Namespaces\Twitter\MediaTypes\App
     */
    public function setCountry($country) : App
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get App country.
     *
     * @return string
     */
    public function getCountry() : string
    {
        return $this->country;
    }
}
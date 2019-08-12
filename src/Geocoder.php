<?php

declare(strict_types=1);

namespace p810\GeoInfo;

use function str_replace;

class Geocoder
{
    /**
     * @param \p810\GeoInfo\ClientAdapterInterface $client
     */
    function __construct(ClientAdapterInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Returns a `p810\GeoInfo\GeocoderResponse` for a pair of coordinates
     * 
     * @param float $latitude
     * @param float $longitude
     * @return \p810\GeoInfo\GeocoderResponse
     * @throws \p810\GeoInfo\GeocoderException
     */
    public function geocode(float $latitude, float $longitude): GeocoderResponse
    {
        return $this->client->get("$latitude,$longitude");
    }

    /**
     * Returns a `\p810\GeoInfo\GeocoderResponse` object for a named location
     *
     * @param string $location
     * @return \p810\GeoInfo\GeocoderResponse
     * @throws \p810\GeoInfo\GeocoderException
     */
    public function reverseGeocode(string $location): GeocoderResponse
    {
        $location = str_replace(' ', '', $location);

        return $this->client->get($location);
    }

    /**
     * An alias for \p810\GeoInfo\Geocoder::reverseGeocode()
     * 
     * @param string $location
     * @return \p810\GeoInfo\GeocoderResponse
     * @throws \p810\GeoInfo\GeocoderException
     */
    public function reverse(string $location): GeocoderResponse
    {
        return $this->reverseGeocode($location);
    }
}

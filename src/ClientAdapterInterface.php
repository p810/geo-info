<?php

declare(strict_types=1);

namespace p810\GeoInfo;

interface ClientAdapterInterface
{
    /**
     * The API's base URL
     * 
     * @var string
     */
    const API_URL = 'https://geo-info.co/';

    /**
     * Returns the result of a request to the API as a `p810\GeoInfo\GeocoderResponse` object
     * 
     * @param string $uri
     * @return \p810\GeoInfo\GeocoderResponse
     * @throws \p810\GeoInfo\GeocoderException if there was a problem with the request
     */
    public function get(string $uri): GeocoderResponse;
}

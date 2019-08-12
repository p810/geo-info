<?php

namespace p810\GeoInfo\Test\Mock;

use p810\GeoInfo\GeocoderResponse;

/**
 * @codeCoverageIgnore
 */
class GeocoderResponseFactory
{
    /**
     * @return \p810\GeoInfo\GeocoderResponse
     */
    public static function getDefault(): GeocoderResponse
    {
        return new GeocoderResponse([
            'city' => 'Birmingham',
            'cityCode' => '',
            'community' => '',
            'country' => 'US',
            'county' => 'Shelby',
            'countyCode' => '117',
            'latitude' => 33.3813,
            'longitude' => -86.7046,
            'nearby' => '',
            'postalCode' => '35242',
            'state' => 'Alabama',
            'stateCode' => 'AL'
        ]);
    }

    /**
     * @return \p810\GeoInfo\GeocoderResponse
     */
    public static function withError(): GeocoderResponse
    {
        return new GeocoderResponse([
            'error' => 'Hello world!'
        ]);
    }

    /**
     * @return \p810\GeoInfo\GeocoderResponse
     */
    public static function withNearby(): GeocoderResponse
    {   
        return new GeocoderResponse([
            'city' => 'Birmingham',
            'cityCode' => '',
            'community' => '',
            'country' => 'US',
            'county' => 'Shelby',
            'countyCode' => '117',
            'latitude' => 33.3813,
            'longitude' => -86.7046,
            'nearby' => [[
                'city' => 'Birmingham',
                'cityCode' => '',
                'community' => '',
                'country' => 'US',
                'county' => 'Shelby',
                'countyCode' => '117',
                'latitude' => 33.3813,
                'longitude' => -86.7046,
                'nearby' => '',
                'postalCode' => '35242',
                'state' => 'Alabama',
                'stateCode' => 'AL'
            ]],
            'postalCode' => '35242',
            'state' => 'Alabama',
            'stateCode' => 'AL'
        ]);
    }
}

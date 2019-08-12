<?php

namespace p810\GeoInfo\Test\Mock;

use p810\GeoInfo\GuzzleAdapter;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\{Client, HandlerStack};
use GuzzleHttp\Psr7\{Request, Response};
use GuzzleHttp\Exception\RequestException;

use function json_encode;

/**
 * @codeCoverageIgnore
 */
class GuzzleAdapterFactory
{
    /**
     * @var array<string,mixed>
     */
    const RESPONSE_BODY_NORMAL = [
        'city' => 'Birmingham',
        'cityCode' => null,
        'community' => null,
        'country' => 'US',
        'county' => 'Shelby',
        'countyCode' => '117',
        'latitude' => 33.3813,
        'longitude' => -86.7046,
        'nearby' => null,
        'postalCode' => '35242',
        'state' => 'Alabama',
        'stateCode' => 'AL'
    ];

    /**
     * @var array<string,string>
     */
    const RESPONSE_BODY_ERROR = [
        'error' => 'The requested location could not be found.'
    ];

    /**
     * @var array<string,string>
     */
    const REQUEST_HEADERS_DEFAULT = [
        'Content-Type' => 'application/json'
    ];

    /**
     * @var \p810\GeoInfo\GuzzleAdapter
     */
    private static $client = null;

    /**
     * @return \p810\GeoInfo\GuzzleAdapter
     */
    public static function getClient(): GuzzleAdapter
    {
        if (! static::$client) {
            static::$client = self::makeClient();
        }

        return static::$client;
    }

    /**
     * @return \p810\GeoInfo\GuzzleAdapter
     */
    private static function makeClient(): GuzzleAdapter
    {
        $handler = new MockHandler([
            new Response(200, self::REQUEST_HEADERS_DEFAULT, json_encode(self::RESPONSE_BODY_NORMAL)),
            new Response(500, self::REQUEST_HEADERS_DEFAULT, json_encode(self::RESPONSE_BODY_ERROR)),
            new Response(500, self::REQUEST_HEADERS_DEFAULT, null),
            new RequestException('There was an error communicating with the server', new Request('GET', '/'))
        ]);

        return new GuzzleAdapter(new Client([
            'handler' => HandlerStack::create($handler),
            'http_errors' => false
        ]));
    }
}

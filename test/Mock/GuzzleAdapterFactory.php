<?php

namespace p810\GeoInfo\Test\Mock;

use p810\GeoInfo\GuzzleAdapter;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\{Client, HandlerStack};
use GuzzleHttp\Psr7\{Request, Response};
use GuzzleHttp\Exception\RequestException;

/**
 * @codeCoverageIgnore
 */
class GuzzleAdapterFactory
{
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

    const RESPONSE_BODY_ERROR = [
        'error' => 'The requested location could not be found.'
    ];

    private static $instance = null;

    public static function getInstance(): GuzzleAdapterFactory
    {
        if (! static::$instance) {
            static::$instance = new GuzzleAdapterFactory();
        }

        return static::$instance;
    }

    private function __construct()
    {
    }

    private function getGuzzleAdapter(array $responses): GuzzleAdapter
    {
        $handler = new MockHandler($responses);

        return new GuzzleAdapter(new Client([
            'handler' => HandlerStack::create($handler),
            'http_errors' => false
        ]));
    }

    public function withDefaultResponse(): GuzzleAdapter
    {
        return $this->getGuzzleAdapter([
            new Response(200, [
                'Content-Type' => 'application/json'
            ], json_encode(self::RESPONSE_BODY_NORMAL))
        ]);
    }

    public function withErrorResponse(): GuzzleAdapter
    {
        return $this->getGuzzleAdapter([
            new Response(500, [
                'Content-Type' => 'application/json'
            ], json_encode(self::RESPONSE_BODY_ERROR))
        ]);
    }

    public function withNetworkErrorException(): GuzzleAdapter
    {
        return $this->getGuzzleAdapter([
            new RequestException('There was an error communicating with the server', new Request('GET', '/'))
        ]);
    }

    public function withEmptyResponse(): GuzzleAdapter
    {
        return $this->getGuzzleAdapter([
            new Response(500, [
                'Content-Type' => 'application/json'
            ], null)
        ]);
    }
}

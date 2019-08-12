<?php

namespace p810\GeoInfo\Test;

use PHPUnit\Framework\TestCase;
use p810\GeoInfo\Test\Mock\GuzzleAdapterFactory;
use p810\GeoInfo\{GeocoderResponse, GeocoderException};

class GuzzleAdapterTest extends TestCase
{
    public function testClientReturnsGeocoderResponse()
    {
        $client = GuzzleAdapterFactory::getClient();
        $response = $client->get('Birmingham, AL, US');

        $this->assertInstanceOf(GeocoderResponse::class, $response);
    }

    public function testClientThrowsGeocoderExceptionWithErrorMessage()
    {
        $client = GuzzleAdapterFactory::getClient();
        $this->expectException(GeocoderException::class);
        $this->expectExceptionMessage('The requested location could not be found.');

        $client->get('DoesNotExist, NO, WAY');
    }

    public function testClientThrowsGeocoderExceptionWhenResponseIsEmpty()
    {
        $client = GuzzleAdapterFactory::getClient();
        $this->expectException(GeocoderException::class);
        $this->expectExceptionMessage('Received an empty response from the API');

        $client->get('/');
    }

    public function testClientThrowsGeocoderExceptionFromNetworkError()
    {
        $client = GuzzleAdapterFactory::getClient();
        $this->expectException(GeocoderException::class);
        $this->expectExceptionMessage('There was an error communicating with the server');

        $client->get('/');
    }
}

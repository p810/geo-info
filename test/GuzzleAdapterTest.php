<?php

namespace p810\GeoInfo\Test;

use PHPUnit\Framework\TestCase;
use p810\GeoInfo\Test\Mock\GuzzleAdapterFactory;
use p810\GeoInfo\{GeocoderResponse, GeocoderException};

class GuzzleAdapterTest extends TestCase
{
    public function setUp(): void
    {
        $this->factory = GuzzleAdapterFactory::getInstance();
    }

    public function testClientReturnsGeocoderResponse()
    {
        $client = $this->factory->withDefaultResponse();
        $response = $client->get('Birmingham, AL, US');

        $this->assertInstanceOf(GeocoderResponse::class, $response);
    }

    public function testClientThrowsGeocoderExceptionWithErrorMessage()
    {
        $client = $this->factory->withErrorResponse();
        $this->expectException(GeocoderException::class);
        $this->expectExceptionMessage('The requested location could not be found.');

        $client->get('DoesNotExist, NO, WAY');
    }

    public function testClientThrowsGeocoderExceptionFromNetworkError()
    {
        $client = $this->factory->withNetworkErrorException();
        $this->expectException(GeocoderException::class);
        $this->expectExceptionMessage('There was an error communicating with the server');

        $client->get('/');
    }

    public function testClientThrowsGeocoderExceptionWhenResponseIsEmpty()
    {
        $client = $this->factory->withEmptyResponse();
        $this->expectException(GeocoderException::class);
        $this->expectExceptionMessage('Received an empty response from the API');

        $client->get('/');
    }
}

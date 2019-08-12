<?php

namespace p810\GeoInfo\Test;

use PHPUnit\Framework\TestCase;
use p810\GeoInfo\GeocoderResponse;
use p810\GeoInfo\Test\Mock\GeocoderResponseFactory;

use function is_array;
use function json_decode;

class GeocoderResponseTest extends TestCase
{
    public function testGeocoderResponseReturnsBirminghamData(): GeocoderResponse
    {
        $response = GeocoderResponseFactory::getDefault();

        $this->assertEquals('Birmingham', $response->getCity());
        $this->assertEquals('AL', $response->getStateCode());
        $this->assertEquals('US', $response->getCountry());
        $this->assertEquals('Shelby', $response->getCounty());
        $this->assertEquals('Alabama', $response->getState());
        $this->assertEquals('117', $response->getCountyCode());
        $this->assertEquals('35242', $response->getPostalCode());

        return $response;
    }

    /**
     * @depends testGeocoderResponseReturnsBirminghamData
     */
    public function testGeocoderResponseReturnsLatLonAsFloat(GeocoderResponse $response): GeocoderResponse
    {
        $this->assertIsFloat($response->getLatitude());
        $this->assertIsFloat($response->getLongitude());

        return $response;
    }

    /**
     * @depends testGeocoderResponseReturnsLatLonAsFloat
     */
    public function testGeocoderResponseReturnsEmptyFieldsAsNull(GeocoderResponse $response): GeocoderResponse
    {
        $this->assertNull($response->getCommunity());
        $this->assertNull($response->getCityCode());

        return $response;
    }

    /**
     * @depends testGeocoderResponseReturnsEmptyFieldsAsNull
     */
    public function testGeocoderResponseConversionMethods(GeocoderResponse $response)
    {
        $this->assertTrue(is_array($response->toArray()));
        $this->assertNotNull(json_decode($response->toJson()));
    }

    public function testGeocoderResponseNearbyIsArrayOfGeocoderResponse()
    {
        $response = GeocoderResponseFactory::withNearby();

        $this->assertContainsOnlyInstancesOf(GeocoderResponse::class, $response->getNearby());
    }

    public function testGeocoderResponseWithError()
    {
        $response = GeocoderResponseFactory::withError();

        $this->assertEquals('Hello world!', $response->getError());
        $this->assertNull($response->getCity());
    }
}

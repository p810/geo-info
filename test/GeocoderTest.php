<?php

namespace p810\GeoInfo\Test;

use PHPUnit\Framework\TestCase;
use p810\GeoInfo\Test\Mock\MockClientAdapter;
use p810\GeoInfo\{Geocoder, GeocoderResponse, GeocoderException};

class GeocoderTest extends TestCase
{
    public function setUp(): void
    {
        $this->geocoder = new Geocoder(new MockClientAdapter());
    }

    public function testGeocodeReturnsResponse()
    {
        $response = $this->geocoder->geocode(33.3813, -86.7046);

        $this->assertInstanceOf(GeocoderResponse::class, $response);
    }

    public function testReverseGeocodeReturnsResponse()
    {
        $response = $this->geocoder->reverseGeocode('Birmingham, AL, US');

        $this->assertInstanceOf(GeocoderResponse::class, $response);
    }

    public function testAliasForReverseGeocode()
    {
        $response = $this->geocoder->reverse('Birmingham, AL, US');

        $this->assertInstanceOf(GeocoderResponse::class, $response);
    }

    public function testErrorResponseThrowsGeocoderException()
    {
        $this->expectException(GeocoderException::class);
        
        $this->geocoder->reverseGeocode('DoesNotExist,NO,US');
    }
}

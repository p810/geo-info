<?php

namespace p810\GeoInfo\Test\Mock;

use p810\GeoInfo\{GeocoderResponse, GeocoderException, ClientAdapterInterface};

/**
 * @codeCoverageIgnore
 */
class MockClientAdapter implements ClientAdapterInterface
{
    public function get(string $uri): GeocoderResponse
    {
        switch ($uri) {
            case '33.3813,-86.7046':
            case 'Birmingham,AL,US':
                return GeocoderResponseFactory::getDefault();
                break;
            default:
                throw new GeocoderException();
                break;
        }
    }
}

# php-geo-info
> A PHP SDK for interacting with the GeoInfo API

## Installing
```
$ composer require p810/geo-info
```

## Usage
Geocoding and reverse geocoding are done with an instance of `p810\GeoInfo\Geocoder`, which takes a `p810\GeoInfo\ClientAdapterInterface` to make calls to the API. `p810\GeoInfo\GuzzleAdapter` is provided by default:

```php
$geocoder = new p810\GeoInfo\Geocoder(new p810\GeoInfo\GuzzleAdapter());
```

You can optionally provide your own `GuzzleHttp\Client` to the adapter:

```php
$adapter = new p810\GeoInfo\GuzzleAdapter(new GuzzleHttp\Client([
    /* ... */
]));
```

Then, you can use the `geocode()` and `reverseGeocode()` (or `reverse()` for brevity) methods to geocode a pair of coordinates or location, respectively:

```php
$geocoder->geocode(33.3813, -86.7046); //=> p810\GeoInfo\GeocoderResponse#1
$geocoder->reverseGeocode('Birmingham, AL, US'); //=> p810\GeoInfo\GeocoderResponse#2
```

Each method returns a `p810\GeoInfo\GeocoderResponse` which provides getters for the fields returned from the API request, as well as methods for transforming the response into JSON or an array:

```php
$response->getPostalCode(); //=> string(5) 35242
$response->getCity(); //=> string(10) Birmingham

$response->toArray(); //=> array(12) {'city' => ...}
$response->toJson(); //=> string(247) {"city": ...}
```

`p810\GeoInfo\GeocoderException` is thrown when:

- the API is unreachable (e.g. the site is down, DNS couldn't be resolved, etc.)
- the API returned an error code

If the API returns an error message it will be the exception's message. If the API was unreachable and you're using `p810\GeoInfo\GuzzleAdapter`, the message from a `GuzzleHttp\Exception\TransferException` will be used for the `GeocoderException`, and the `TransferException` will also be accessible via `getPrevious()`.

## License
This package is released under the [MIT License](https://github.com/p810/geo-info/blob/master/LICENSE).

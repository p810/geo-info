<?php

declare(strict_types=1);

namespace p810\GeoInfo;

use function is_array;
use function json_encode;
use function array_key_exists;

class GeocoderResponse
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @param array $data
     */
    function __construct(array $data)
    {
        if (array_key_exists('nearby', $data) && is_array($data['nearby'])) {
            foreach ($data['nearby'] as $key => $location) {
                $data['nearby'][$key] = new GeocoderResponse($location);
            }
        }

        $this->data = array_map(function ($value) {
            if ($value == '') {
                return null;
            }

            return $value;
        }, $data);
    }

    /**
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->data);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * Searches for a key in \p810\GeoInfo\GeocoderResponse::$data and returns its value, or null
     * 
     * @param string $field
     * @return null|mixed
     */
    public function get(string $field)
    {
        if (array_key_exists($field, $this->data)) {
            return $this->data[$field];
        }

        return null;
    }

    /**
     * @return null|string
     */
    public function getError(): ?string
    {
        return $this->get('error');
    }

    /**
     * @return null|string
     */
    public function getCity(): ?string
    {
        return $this->get('city');
    }

    /**
     * @return null|string
     */
    public function getCityCode(): ?string
    {
        return $this->get('cityCode');
    }

    /**
     * @return null|string
     */
    public function getCommunity(): ?string
    {
        return $this->get('community');
    }

    /**
     * @return null|string
     */
    public function getCountry(): ?string
    {
        return $this->get('country');
    }

    /**
     * @return null|string
     */
    public function getCounty(): ?string
    {
        return $this->get('county');
    }

    /**
     * @return null|string
     */
    public function getCountyCode(): ?string
    {
        return $this->get('countyCode');
    }

    /**
     * @return null|float
     */
    public function getLatitude(): ?float
    {
        return $this->get('latitude');
    }

    /**
     * @return null|float
     */
    public function getLongitude(): ?float
    {
        return $this->get('longitude');
    }

    /**
     * @return null|\p810\GeoInfo\GeocoderResponse[]
     */
    public function getNearby(): ?array
    {
        return $this->get('nearby');
    }

    /**
     * @return null|string
     */
    public function getPostalCode(): ?string
    {
        return $this->get('postalCode');
    }

    /**
     * @return null|string
     */
    public function getState(): ?string
    {
        return $this->get('state');
    }

    /**
     * @return null|string
     */
    public function getStateCode(): ?string
    {
        return $this->get('stateCode');
    }
}

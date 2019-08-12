<?php

declare(strict_types=1);

namespace p810\GeoInfo;

use \GuzzleHttp\Client;
use \GuzzleHttp\Exception\TransferException;

use function json_decode;

class GuzzleAdapter implements ClientAdapterInterface
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @param \GuzzleHttp\Client|null $client
     * @return void
     */
    function __construct(?Client $client = null)
    {
        $this->client = $client ?: new Client([
            'base_uri' => self::API_URL,
            'http_errors' => false
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $uri): GeocoderResponse
    {
        try {
            $response = $this->client->get($uri);
            $body = json_decode((string) $response->getBody(), true, JSON_NUMERIC_CHECK);

            if ($body === null) {
                throw new GeocoderException('Received an empty response from the API');
            } elseif ($body && $response->getStatusCode() !== 200) {
                throw new GeocoderException($body['error']);
            }

            return new GeocoderResponse($body);
        } catch (TransferException $e) {
            throw new GeocoderException($e->getMessage(), $e->getCode(), $e);
        }
    }
}

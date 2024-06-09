<?php

namespace App\Shortener\Validators;

use App\Shortener\Enums\HTTPStatuses;
use App\Shortener\Interfaces\IUrlValidator;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;

class UrlValidator implements IUrlValidator
{
    public function __construct(protected ClientInterface $client)
    {

    }

    /**
     * @param string $url
     * @return void
     * @throws InvalidArgumentException
     */
    public function validateUrl(string $url): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("Invalid URL: $url");
        }
    }

    /**
     * @param string $url
     * @return void
     * @throws InvalidArgumentException
     */
    public function validateIsRealUrl(string $url): void
    {
        try {
            $response = $this->client->head($url);

            $statusCode = $response->getStatusCode();
            if (!in_array($statusCode, HTTPStatuses::getValidStatuses())) {
                throw new InvalidArgumentException("Invalid response code ($statusCode) for URL: $url");
            }
        } catch (GuzzleException $exception) {
            throw new InvalidArgumentException("Invalid URL: $url");
        }
    }
}
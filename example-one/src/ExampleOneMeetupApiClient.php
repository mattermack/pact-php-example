<?php
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;

class ExampleOneMeetupApiClient
{
    const version = "2";

    /**
     * @var GuzzleHttp\Client
     */
    private $httpClient;

    /**
     * @var \GuzzleHttp\Psr7\Uri
     */
    private $baseUri;

    public function __construct($baseUri)
    {
        $this->httpClient = new Client();
        $this->baseUri = $baseUri;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function categories()
    {
        $uri = $this->baseUri;
        $uri = $uri->withPath(ExampleOneMeetupApiClient::version . '/categories');

        $response = $this->httpClient->get($uri, [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        return $response;
    }
}
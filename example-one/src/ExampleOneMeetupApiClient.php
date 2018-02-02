<?php
use GuzzleHttp\Client;

class ExampleOneMeetupApiClient
{
    const version = "2";

    private $_httpClient;
    private $_baseUrl;

    public function __construct($baseUrl)
    {
        $this->_httpClient = new Client();
        $this->_baseUrl = $baseUrl;
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
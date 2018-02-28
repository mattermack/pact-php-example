<?php

use GuzzleHttp\Client;

class ExampleTwoMeetupApiClient
{
    const version = '2';

    /** @var \PhpPact\Http\ClientInterface */
    private $httpClient;

    /** @var \GuzzleHttp\Psr7\Uri */
    private $baseUri;

    public function __construct($baseUri)
    {
        $this->httpClient = new Client();
        $this->baseUri    = $baseUri;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function cities()
    {
        $uri = $this->baseUri;
        $uri = $uri->withPath(ExampleTwoMeetupApiClient::version . '/cities');

        $response = $this->httpClient->get($uri, [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        return $response;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function dashboard()
    {
        $uri = $this->baseUri;
        $uri = $uri->withPath('dashboard');

        $response = $this->httpClient->get($uri, [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        return $response;
    }

}
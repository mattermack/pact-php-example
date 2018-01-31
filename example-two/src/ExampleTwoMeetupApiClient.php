<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;

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
        $uri = $uri->withPort(7200);

        $response = $this->httpClient->get($uri, [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        return $response;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    /*
    public function dashboard()
    {
        $response = $this->httpClient->get(new Uri($this->baseUri . '/dashboard'), [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        return $response;
    }
    */
}
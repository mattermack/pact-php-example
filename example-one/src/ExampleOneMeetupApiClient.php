<?php

class ExampleOneMeetupApiClient
{
    const version = "2";

    private $_httpClient;
    private $_baseUrl;

    public function __construct($httpClient, $baseUrl)
    {
        $this->_httpClient = $httpClient;
        $this->_baseUrl = $baseUrl;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function categories()
    {
        $uri = (new \Windwalker\Uri\PsrUri($this->_baseUrl))
            ->withPath('/' . ExampleOneMeetupApiClient::version . '/categories');

        $httpRequest = (new \Windwalker\Http\Request\Request())
            ->withUri($uri)
            ->withAddedHeader("Content-Type", "application/json")
            ->withMethod("get");

        return $this->_httpClient->sendRequest($httpRequest);
    }

}
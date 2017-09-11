<?php

class ExampleTwoMeetupApiClient
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
    public function cities()
    {
        $uri = (new \Windwalker\Uri\PsrUri($this->_baseUrl))
            ->withPath('/' . ExampleTwoMeetupApiClient::version . '/cities');

        $httpRequest = (new \Windwalker\Http\Request\Request())
            ->withUri($uri)
            ->withAddedHeader("Content-Type", "application/json")
            ->withMethod("get");

        return $this->_httpClient->sendRequest($httpRequest);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function dashboard()
    {
        $uri = (new \Windwalker\Uri\PsrUri($this->_baseUrl))
            ->withPath('/dashboard');

        $httpRequest = (new \Windwalker\Http\Request\Request())
            ->withUri($uri)
            ->withAddedHeader("Content-Type", "application/json")
            ->withMethod("get");

        return $this->_httpClient->sendRequest($httpRequest);
    }
}
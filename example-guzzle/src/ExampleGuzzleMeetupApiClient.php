<?php

class ExampleGuzzleMeetupApiClient
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

        $fullUrl =  $this->_baseUrl . '/' . ExampleGuzzleMeetupApiClient::version . '/categories';
        $headers = array("Content-Type" => "application/json");
            
        $httpRequest = (new \GuzzleHttp\Psr7\Request('GET', $fullUrl, $headers));

        return $this->_httpClient->send($httpRequest);
    }

}
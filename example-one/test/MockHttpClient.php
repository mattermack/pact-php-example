<?php

use PhpPact\Mocks\MockHttpService\MockProviderHost;
class MockHttpClient
{

    /**
     * @var MockProviderHost
     */
    private $_mockHost;

    /**
     * MockHttpClient constructor.
     * @param MockProviderHost $mockHost
     */
    public function __construct(&$mockHost)
    {
        $this->_mockHost = $mockHost;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $httpRequest
     * @return callable|null|\Psr\Http\Message\ResponseInterface
     */
    public function sendRequest(\Psr\Http\Message\RequestInterface $httpRequest)
    {
         return $this->_mockHost->handle($httpRequest);
    }
}
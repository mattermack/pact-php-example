<?php

require_once(__DIR__ . '/../src/ExampleOneMeetupApiClient.php');
require_once(__DIR__ . '/MockHttpClient.php');

use PHPUnit\Framework\TestCase;

class MeetupAPIClientTest extends TestCase
{

    /**
     * @var \PhpPact\PactBuilder
     */
    protected $_build;

    const TEST_URL = "https://api.meetup.com";
    const CONSUMER_NAME = "ExampleOneMeetupApiClient";
    const PROVIDER_NAME = "MeetupAPI";


    /**
     * Before each test, rebuild the builder
     */
    protected function setUp()
    {
        parent::setUp();
        $config = new \PhpPact\PactConfig();
        $config->setBaseUri(MeetupAPIClientTest::TEST_URL);

        $this->_build = new \PhpPact\PactBuilder($config);
        $this->_build->ServiceConsumer(self::CONSUMER_NAME)
            ->HasPactWith(self::PROVIDER_NAME);
    }

    protected function tearDown()
    {
        parent::tearDown();

        unset($this->_build);
    }

    public function testCategories()
    {
        // build the request
        $reqHeaders = array();
        $reqHeaders["Content-Type"] = "application/json";
        $method = \PhpPact\Mocks\MockHttpService\Models\HttpVerb::GET;
        $path = '/' . ExampleOneMeetupApiClient::version . '/categories';
        $request = new \PhpPact\Mocks\MockHttpService\Models\ProviderServiceRequest($method, $path, $reqHeaders);

        // build the response
        $resHeaders = array();
        $resHeaders["Content-Type"] = "application/json";

        $response = new \PhpPact\Mocks\MockHttpService\Models\ProviderServiceResponse('200', $resHeaders);
        $response->setBody("{\"results\":[{\"name\":\"Games\",\"sort_name\":\"Games\",\"id\":11,\"shortname\":\"Games\"},{\"name\":\"Book Clubs\",\"sort_name\":\"Book Clubs\",\"id\":18,\"shortname\":\"Book Clubs\"}]}");


        // build up the expected results and appropriate responses
        $mockService = $this->_build->getMockService();
        $mockService->Given("General Meetup Categories")
            ->UponReceiving("A GET request to return JSON using Meetups category api under version 2")
            ->With($request)
            ->WillRespondWith($response);


        // set the host for the httpClient
        $host = $mockService->getHost();
        $httpClient = new MockHttpClient($host);

        // build system under test
        // inject the http client and mock server
        $client = new ExampleOneMeetupApiClient($httpClient, MeetupAPIClientTest::TEST_URL);
        $response = $client->categories();


        // do some asserts on the return
        $this->assertEquals('200', $response->getStatusCode(), "Let's make sure we have an OK response");

        // do something with the body returned
        $body = (string) $response->getBody();
        $this->assertTrue((json_decode($body) ? true : false), "Expect the JSON to be decoded without error");
    }
}
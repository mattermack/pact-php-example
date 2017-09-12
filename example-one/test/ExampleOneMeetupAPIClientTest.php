<?php

require_once(__DIR__ . '/../src/ExampleOneMeetupApiClient.php');
require_once(__DIR__ . '/MockHttpClient.php');

use PHPUnit\Framework\TestCase;

class ExampleOneMeetupAPIClientTest extends TestCase
{

    /**
     * @var \PhpPact\PactBuilder
     */
    protected static $build;

    const TEST_URL = "https://api.meetup.com";
    const CONSUMER_NAME = "ExampleOneMeetupApiClient";
    const PROVIDER_NAME = "MeetupAPI";
    const PACT_DIR = "D:\\Temp\\pact-examples\\";
    const version = '2';

    public static function setUpBeforeClass()
    {
        $config = new \PhpPact\PactConfig();
        $config->setBaseUri(self::TEST_URL);
        $config->setPactDir(self::PACT_DIR);

        self::$build = new \PhpPact\PactBuilder($config);
        self::$build->ServiceConsumer(self::CONSUMER_NAME)
            ->HasPactWith(self::PROVIDER_NAME);
    }

    public static function tearDownAfterClass()
    {
        $mockService = self::$build->getMockService();

        $pact = $mockService->getPactFile();
        $pact->setProvider(new \PhpPact\Models\Pacticipant(self::PROVIDER_NAME));
        $pact->setConsumer(new \PhpPact\Models\Pacticipant(self::CONSUMER_NAME));

        self::$build->Build($pact);
    }

    public function testCategories()
    {
        // build the request
        $reqHeaders = array();
        $reqHeaders["Content-Type"] = "application/json";
        $method = \PhpPact\Mocks\MockHttpService\Models\HttpVerb::GET;
        $path = '/' . self::version . '/categories';
        $request = new \PhpPact\Mocks\MockHttpService\Models\ProviderServiceRequest($method, $path, $reqHeaders);

        // build the response
        $resHeaders = array();
        $resHeaders["Content-Type"] = "application/json";

        $response = new \PhpPact\Mocks\MockHttpService\Models\ProviderServiceResponse('200', $resHeaders);
        $response->setBody("{\"results\":[{\"name\":\"Games\",\"sort_name\":\"Games\",\"id\":11,\"shortname\":\"Games\"},{\"name\":\"Book Clubs\",\"sort_name\":\"Book Clubs\",\"id\":18,\"shortname\":\"Book Clubs\"}]}");


        // build up the expected results and appropriate responses
        $mockService = self::$build->getMockService();
        $mockService->Given("General Meetup Categories")
            ->UponReceiving("A GET request to return JSON using Meetups category api under version 2")
            ->With($request)
            ->WillRespondWith($response);


        // set the host for the httpClient
        $host = $mockService->getHost();
        $httpClient = new MockHttpClient($host);

        // build system under test
        // inject the http client and mock server
        $client = new ExampleOneMeetupApiClient($httpClient, self::TEST_URL);
        $response = $client->categories();


        // do some asserts on the return
        $this->assertEquals('200', $response->getStatusCode(), "Let's make sure we have an OK response");

        // do something with the body returned
        $body = (string) $response->getBody();
        $this->assertTrue((json_decode($body) ? true : false), "Expect the JSON to be decoded without error");

        // verify the interactions
        $hasException = false;
        try {
            $results = $mockService->VerifyInteractions();

        } catch (\PhpPact\PactFailureException $e) {
            $hasException = true;
        }
        $this->assertFalse($hasException, "This categories call get should verify the interactions and not throw an exception");
    }
}
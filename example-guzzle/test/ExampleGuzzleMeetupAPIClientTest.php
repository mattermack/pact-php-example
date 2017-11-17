<?php

require_once(__DIR__ . '/../src/ExampleGuzzleMeetupApiClient.php');
require_once(__DIR__ . '/MockHttpClient.php');

use PHPUnit\Framework\TestCase;
use PhpPact\Models\Pacticipant;
use PhpPact\Mocks\MockHttpService\Models\ProviderServiceRequest;
use PhpPact\Mocks\MockHttpService\Models\ProviderServiceResponse;
use PhpPact\Mocks\MockHttpService\Models\HttpVerb;
use PhpPact\Matchers\Rules\MatchingRule;
use PhpPact\Matchers\Rules\MatcherRuleTypes;

class ExampleGuzzleMeetupAPIClientTest extends TestCase
{

    /**
     * @var \PhpPact\PactBuilder
     */
    protected static $build;

    const TEST_URL = "https://api.meetup.com";
    const CONSUMER_NAME = "ExampleGuzzleMeetupApiClient";
    const PROVIDER_NAME = "MeetupAPI";
    const PACT_DIR = "./pact-examples/";
    const version = '2';

    public static function setUpBeforeClass()
    {
        $config = new \PhpPact\PactConfig();
        $config->setBaseUri(self::TEST_URL);
        $config->setPactDir(self::PACT_DIR);

        self::$build = new \PhpPact\PactBuilder($config);
        self::$build->serviceConsumer(self::CONSUMER_NAME)
            ->hasPactWith(self::PROVIDER_NAME);
    }

    public static function tearDownAfterClass()
    {
        $mockService = self::$build->getMockService();

        $pact = $mockService->getPactFile();
        $pact->setProvider(new Pacticipant(self::PROVIDER_NAME));
        $pact->setConsumer(new Pacticipant(self::CONSUMER_NAME));

        self::$build->build($pact);
    }


    /**
     * @test
     */
    public function testCategories()
    {
        // build the request
        $reqHeaders = array();
        $reqHeaders["Content-Type"] = "application/json";
        $method = HttpVerb::GET;
        $path = '/' . self::version . '/categories';
        $request = new ProviderServiceRequest($method, $path, $reqHeaders);

        // build the response
        $resHeaders = array();
        $resHeaders["Content-Type"] = "application/json";

        $response = new ProviderServiceResponse('200', $resHeaders);
        $jsonBody = \json_decode("{\"results\":[{\"name\":\"Games\",\"sort_name\":\"Games\",\"id\":11,\"shortname\":\"Games\"},{\"name\":\"Book Clubs\",\"sort_name\":\"Book Clubs\",\"id\":18,\"shortname\":\"Book Clubs\"}]}");
        $response->setBody(\json_encode($jsonBody));

        $resMatchers = array();
        $resMatchers['$.body.results'] = new MatchingRule('$.body.results[*].name', array(
                MatcherRuleTypes::RULE_TYPE => MatcherRuleTypes::REGEX_TYPE,
                MatcherRuleTypes::REGEX_PATTERN => 'Games|Book Clubs')
        );

        $response->setMatchingRules($resMatchers);

        // build up the expected results and appropriate responses
        $mockService = self::$build->getMockService();
        $mockService->given("General Meetup Categories")
            ->uponReceiving("A GET request to return JSON using Meetups category api under version 2")
            ->with($request)
            ->willRespondWith($response);


        // set the host for the httpClient
        $host = $mockService->getHost();
        $httpClient = new MockHttpClient($host);

        // build system under test
        // inject the http client and mock server
        $client = new ExampleGuzzleMeetupApiClient($httpClient, self::TEST_URL);
        $response = $client->categories();


        // do some asserts on the return
        $this->assertEquals('200', $response->getStatusCode(), "Let's make sure we have an OK response");

        // do something with the body returned
        $body = (string) $response->getBody();
        $this->assertTrue((json_decode($body) ? true : false), "Expect the JSON to be decoded without error");

        // verify the interactions
        $hasException = false;
        try {
            $results = $mockService->verifyInteractions();

        } catch (\PhpPact\PactFailureException $e) {
            $hasException = true;
        }
        $this->assertFalse($hasException, "This categories call get should verify the interactions and not throw an exception");
    }
}
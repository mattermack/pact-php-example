<?php

require_once ('../src/ExampleOneMeetupApiClient.php');

use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Http\GuzzleClient;
use PhpPact\Standalone\MockService\MockServerEnvConfig;
use PhpPact\Standalone\MockService\Service\MockServerHttpService;
use PHPUnit\Framework\TestCase;


class ExampleOneMeetupAPIClientTest extends TestCase
{
    const version = '2';

    /**
     * @test
     */
    public function testCategories()
    {
        // build the request
        $path = '/' . self::version . '/categories';

        // build the request
        $request = new ConsumerRequest();
        $request
            ->setMethod('GET')
            ->setPath($path)
            ->addHeader('Content-Type', 'application/json');

        // build the response
        $body = \json_decode("{\"results\":[{\"name\":\"Games\",\"sort_name\":\"Games\",\"id\":11,\"shortname\":\"Games\"},{\"name\":\"Book Clubs\",\"sort_name\":\"Book Clubs\",\"id\":18,\"shortname\":\"Book Clubs\"}]}");

        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->addHeader('Content-Type', 'application/json')
            ->setBody($body);

        /*
        $resMatchers = array();
        $resMatchers['$.body.results'] = new MatchingRule('$.body.results[*].name', array(
                MatcherRuleTypes::RULE_TYPE => MatcherRuleTypes::REGEX_TYPE,
                MatcherRuleTypes::REGEX_PATTERN => 'Games|Book Clubs')
        );

        $response->setMatchingRules($resMatchers);
        */

        // build up the expected results and appropriate responses
        $config      = new MockServerEnvConfig();

        $mockService = new InteractionBuilder($config);
        $mockService->given("General Meetup Categories")
            ->uponReceiving("A GET request to return JSON using Meetups category api under version 2")
            ->with($request)
            ->willRespondWith($response);


        $service = new \ExampleOneMeetupApiClient($config->getBaseUri()); // Pass in the URL to the Mock Server.
        $serviceResponse = $service->categories();

        // do some asserts on the return
        $this->assertEquals('200', $serviceResponse->getStatusCode(), "Let's make sure we have an OK response");

        // do something with the body returned
        $body = (string) $serviceResponse->getBody();
        $this->assertTrue((json_decode($body) ? true : false), "Expect the JSON to be decoded without error");

        $hasException = false;
        try {
            $mockService->verify();
        } catch(\Exception $e) {
            $hasException = true;
        }

        $this->assertFalse($hasException, "We expect the pacts to validate");
    }
}
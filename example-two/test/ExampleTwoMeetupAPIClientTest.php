<?php

namespace Consumer\Service;

require_once ('../src/ExampleTwoMeetupApiClient.php');

use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Http\GuzzleClient;
use PhpPact\Standalone\MockService\MockServerEnvConfig;
use PhpPact\Standalone\MockService\Service\MockServerHttpService;
use PHPUnit\Framework\TestCase;


class ExampleTwoMeetupAPIClientTest extends TestCase
{
    const version = '2';

    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function testCities()
    {

        // build the request
        $path = '/' . self::version . '/cities';

        // build the request
        $request = new ConsumerRequest();
        $request
            ->setMethod('GET')
            ->setPath($path)
            ->addHeader('Content-Type', 'application/json');

        // build the response
        $body = "{\"results\":[{\"zip\":\"73301\",\"country\":\"us\",\"localized_country_name\":\"USA\",\"distance\":1.8526514121759305,\"city\":\"Austin\",\"lon\":-97.75,\"ranking\":0,\"id\":73301,\"state\":\"TX\",\"member_count\":57163,\"lat\":30.219999313354492},{\"zip\":\"78664\",\"country\":\"us\",\"localized_country_name\":\"USA\",\"distance\":19.468625978898555,\"city\":\"Round Rock\",\"lon\":-97.66999816894531,\"ranking\":1,\"id\":78664,\"state\":\"TX\",\"member_count\":3342,\"lat\":30.510000228881836}]}";
        $body = \json_decode($body);


        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->addHeader('Content-Type', 'application/json;charset=utf-8')
            ->setBody($body);


        // build up the expected results and appropriate responses
        $config      = new MockServerEnvConfig();

        $mockService = new InteractionBuilder($config);
        $mockService->given("General Meetup Cities")
                ->uponReceiving("A GET request to return JSON using Meetups city api under version 2")
                ->with($request)
                ->willRespondWith($response);


        $service = new \ExampleTwoMeetupApiClient($config->getBaseUri()); // Pass in the URL to the Mock Server.
        $serviceResponse = $service->cities();


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

    /**
     * @test
     */
    public function testDashboard()
    {
        // build the request
        $path = '/dashboard';

        // build the request
        $request = new ConsumerRequest();
        $request
            ->setMethod('GET')
            ->setPath($path)
            ->addHeader('Content-Type', 'application/json');

        // build the response
        $body = "{\"stats\":{\"city_top_groups\":100,\"global_top_groups\":100,\"upcoming_events\":14,\"memberships\":7,\"nearby_events\":2444}}";
        $body = \json_decode($body);

        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->addHeader('Content-Type', 'application/json;charset=utf-8')
            ->setBody($body);


        // build up the expected results and appropriate responses
        $config      = new MockServerEnvConfig();

        $mockService = new InteractionBuilder($config);
        $mockService->given("General Meetup Dashboard")
            ->uponReceiving("A GET request to return JSON using Meetups Dashboard that is version agnostic")
            ->with($request)
            ->willRespondWith($response);


        $service = new \ExampleTwoMeetupApiClient($config->getBaseUri()); // Pass in the URL to the Mock Server.
        $serviceResponse = $service->dashboard();

        // do some asserts on the return
        $this->assertEquals('200', $serviceResponse->getStatusCode(), "Expect this to be a valid URL");

        $hasException = false;
        try {
            $mockService->verify();
        } catch(\Exception $e) {
            $hasException = true;
        }

        $this->assertFalse($hasException, "We expect the pacts to validate");
    }
}
<?php

require_once ('../src/ExampleOneMeetupApiClient.php');

use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Consumer\Matcher\RegexMatcher;
use PhpPact\Consumer\Matcher\LikeMatcher;
use PhpPact\Standalone\MockService\MockServerEnvConfig;
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
        $category1 = new stdClass();
        $category1->name = new RegexMatcher('Games', 'Games|Book Clubs');
        $category1->sort_name = new RegexMatcher('Games', 'Games|Book Clubs');
        $category1->id = new LikeMatcher(11);
        $category1->shortname = new RegexMatcher('Games', 'Games|Book Clubs');

        $category2 = new stdClass();
        $category2->name = "Book Clubs";
        $category2->sort_name = "Book Clubs";
        $category2->id = 18;
        $category2->shortname = "Book Clubs";

        $body = array(
            "results" => array(
                $category1,
                $category2
            )
        );

        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->addHeader('Content-Type', 'application/json')
            ->setBody($body);

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
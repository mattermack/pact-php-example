<?php

use PHPUnit\Framework\TestCase;

class ExampleApiServerTest extends TestCase
{
    const PACT_DIR = "D:\\Temp\\pact-examples\\";

    /**
     * @test
     */
    public function testServerExists() {

        $http = new \Windwalker\Http\HttpClient();
        $uri = 'http://' . WEB_SERVER_HOST . ':' . WEB_SERVER_PORT . '/index.php';

        $response = $http->get($uri);
        $status = $response->getStatusCode();

        $this->assertEquals(200, (int) $status, "Expect a 200 status code");
    }

    /**
     * @test
     */
    public function testExampleOne() {

        $uri = WEB_SERVER_HOST . ':' . WEB_SERVER_PORT;

        $httpClient = new \Windwalker\Http\HttpClient();

        $pactVerifier = new \PhpPact\PactVerifier($uri);
        $hasException = false;
        try {

            $json = self::PACT_DIR . 'exampleonemeetupapiclient-meetupapi.json';

            // could be build an object mapper to make this easier

            $pactVerifier->ProviderState("General Meetup Categories")
                ->ServiceProvider("MeetupApi", $httpClient)
                ->HonoursPactWith("ExampleOneMeetupApiClient")
                ->PactUri($json)
                ->Verify();

        }catch(\PhpPact\PactFailureException $e) {
            $hasException = true;
        }
        $this->assertFalse($hasException, "Expect Pact to validate.");
    }

    /**
     * @test
     */
    public function testExampleTwo() {

        $uri = WEB_SERVER_HOST . ':' . WEB_SERVER_PORT;

        $httpClient = new \Windwalker\Http\HttpClient();

        $pactVerifier = new \PhpPact\PactVerifier($uri);
        $hasException = false;

        $setUpFunction = function() {
            $fileName = "index.php";
            $currentDir = dirname(__FILE__);
            $absolutePath = realpath($currentDir . '/../src/dashboard' );
            $absolutePath .= '/' . $fileName;


            file_put_contents($absolutePath, $this->DashboardState());
        };



        try {
            $json = self::PACT_DIR . 'exampletwomeetupapiclient-meetupapi.json';

            $pactVerifier->ProviderState("General Meetup Dashboard", $setUpFunction)
                ->ServiceProvider("MeetupApi", $httpClient)
                ->HonoursPactWith("ExampleTwoMeetupApiClient")
                ->PactUri($json)
                ->Verify(); // note that this should test all as we can run setup and tear down

        }catch(\PhpPact\PactFailureException $e) {
            $hasException = true;
        }
        $this->assertFalse($hasException, "Expect Pact to validate.");
    }

    private function DashboardState()
    {
        $str = <<<STR
<?php

header('Content-Type: application/json');

?>
{
    "stats":
    {
        "city_top_groups": 100,
        "global_top_groups": 100,
        "upcoming_events": 14,
        "memberships": 7,
        "nearby_events": 2444
    }
}
STR;
        return $str;

    }

}

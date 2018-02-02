<?php

use PHPUnit\Framework\TestCase;

use GuzzleHttp\Psr7\Uri;
use PhpPact\Broker\Service\BrokerHttpService;
use PhpPact\Http\GuzzleClient;
use PhpPact\Standalone\ProviderVerifier\Model\VerifierConfig;
use PhpPact\Standalone\ProviderVerifier\Verifier;

class ExampleApiServerTest extends TestCase
{
    const PACT_DIR = "D:\\Temp\\";

    /**
     * @test
     */
    public function testExampleOne() {

        $url = 'http://' . WEB_SERVER_HOST . ':' . WEB_SERVER_PORT;

        $config = new VerifierConfig();
        $config
            ->setProviderName('ExampleTwo') // Providers name to fetch.
            ->setProviderBaseUrl(new Uri($url)) // URL of the Provider.
            ->setBrokerUri(new Uri('http://localhost')) ;

        $hasException = false;
        try {

            $file = self::PACT_DIR . 'exampletwo-exampleapi.json';

            // could be build an object mapper to make this easier

            $verifier = new Verifier($config, new BrokerHttpService(new GuzzleClient(), $config->getBrokerUri()));
            $verifier->verifyFiles(array($file));

        }catch(\Exception $e) {
            $hasException = true;
        }

        $this->assertFalse($hasException, "Expect Pact to validate.");
    }

    /**
     * @tst
     */
    public function tstExampleTwo() {

        $uri = WEB_SERVER_HOST . ':' . WEB_SERVER_PORT;

        $httpClient = new \Windwalker\Http\HttpClient();

        $pactVerifier = new \PhpPact\PactVerifier($uri);
        $hasException = false;

        $setUpFunction = function() {
            $fileName = "index.php";
            $currentDir = dirname(__FILE__);
            $absolutePath = realpath($currentDir . '/../src/dashboard' );
            $absolutePath .= '/' . $fileName;


            file_put_contents($absolutePath, $this->dashboardState());
        };



        try {
            $json = self::PACT_DIR . 'exampletwomeetupapiclient-meetupapi.json';

            $pactVerifier->providerState("General Meetup Dashboard", $setUpFunction)
                ->serviceProvider("MeetupApi", $httpClient)
                ->honoursPactWith("ExampleTwoMeetupApiClient")
                ->pactUri($json)
                ->verify(); // note that this should test all as we can run setup and tear down

        }catch(\PhpPact\PactFailureException $e) {
            $hasException = true;
        }
        $this->assertFalse($hasException, "Expect Pact to validate.");
    }

    private function dashboardState()
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

<?php

use PHPUnit\Framework\TestCase;

use GuzzleHttp\Psr7\Uri;
use PhpPact\Broker\Service\BrokerHttpService;
use PhpPact\Http\GuzzleClient;
use PhpPact\Standalone\ProviderVerifier\Model\VerifierConfig;
use PhpPact\Standalone\ProviderVerifier\Verifier;

class ExampleApiServerTest extends TestCase
{
    const PACT_DIR = "D:/Temp/";

    /**
     * @test
     */
    public function testExampleOne() {
        $url = 'http://' . WEB_SERVER_HOST . ':' . WEB_SERVER_PORT;

        $config = new VerifierConfig();
        $config
            ->setProviderName('ExampleOne') // Providers name to fetch.
            ->setProviderBaseUrl(new Uri($url)) // URL of the Provider.
            ->setBrokerUri(new Uri('http://localhost')) ;


        $hasException = false;
        $exceptionDetails = "";
        try {
            $file = self::PACT_DIR . 'exampleone-exampleapi.json';

            // could be build an object mapper to make this easier
            $verifier = new Verifier($config);
            $verifier->verifyFiles([$file]);
        } catch(\Exception $e) {
            $hasException = true;
            $exceptionDetails = $e->getMessage();
        }

        $this->assertFalse($hasException, "Expect Pact to validate: " . $exceptionDetails);
    }

    /**
     * @test
     */
    public function testExampleTwo() {


        $url = 'http://' . WEB_SERVER_HOST . ':' . WEB_SERVER_PORT;

        $config = new VerifierConfig();
        $config
            ->setProviderName('ExampleTwo') // Providers name to fetch.
            ->setProviderBaseUrl(new Uri($url)) // URL of the Provider.
            ->setBrokerUri(new Uri('http://localhost')) // do we need this?
            ->setProviderStatesSetupUrl($url . '/state/exampletwosetup.php');

        error_log("about to verify");
        $hasException = false;
        $exceptionDetails = "";
        try {
            $file = self::PACT_DIR . 'exampletwo-exampleapi.json';

            // could be build an object mapper to make this easier
            $verifier = new Verifier($config);
            $verifier->verifyFiles(array($file));
        } catch(\Exception $e) {
            $hasException = true;
            $exceptionDetails = $e->getMessage();
        }
        error_log("verified verify");

        $this->assertFalse($hasException, "Expect Pact to validate: " . $exceptionDetails);
    }


}

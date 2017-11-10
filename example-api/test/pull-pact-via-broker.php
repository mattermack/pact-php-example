<?php

require __DIR__ . '/../vendor/autoload.php';

$uriOptions = new \PhpPact\PactUriOptions("http://ec2-34-212-75-79.us-west-2.compute.amazonaws.com" );
$connector = new \PhpPact\PactBrokerConnector($uriOptions);

// particular pact - latest version
$pact = $connector->retrievePact("MeetupAPI", "ExampleTwoMeetupApiClient");
echo \json_encode($pact,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

// get all pacts for this provider
$pacts = $connector->retrieveLatestProviderPacts("MeetupAPI");
$pact = array_pop($pacts);
echo \json_encode($pact,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
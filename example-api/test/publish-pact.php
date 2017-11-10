<?php

require __DIR__ . '/../vendor/autoload.php';

$uriOptions = new \PhpPact\PactUriOptions("http://ec2-34-212-75-79.us-west-2.compute.amazonaws.com" );
$connector = new \PhpPact\PactBrokerConnector($uriOptions);

$dir = "D:\\Temp\\pact-examples\\";
$file = $dir . "exampleonemeetupapiclient-meetupapi.json";

$statusCode = $connector->publishFile($file, '1.0.1');

$dir = "D:\\Temp\\pact-examples\\";
$file = $dir . "exampletwomeetupapiclient-meetupapi.json";

$statusCode = $connector->publishFile($file, '3.1.7');

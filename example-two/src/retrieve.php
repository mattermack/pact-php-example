<?php
require_once ("../vendor/autoload.php");
require_once ("ExampleTwoMeetupApiClient.php");

$uri = new \GuzzleHttp\Psr7\Uri("http://localhost:1349");
$meetup = new \ExampleTwoMeetupApiClient($uri);

$cities = $meetup->cities();
echo print_r((string) $cities->getBody(), true);

$dashboard = $meetup->dashboard();

// https://www.meetup.com/meetup_api/docs/2/cities/
// https://secure.meetup.com/meetup_api/console/?path=/2/cities
// https://secure.meetup.com/meetup_api/console/?path=/dashboard




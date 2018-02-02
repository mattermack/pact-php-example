<?php
require_once ("../vendor/autoload.php");
require_once ("ExampleTwoMeetupApiClient.php");

$meetup = new ExampleTwoMeedupApiClient("https://api.meetup.com");

// https://www.meetup.com/meetup_api/docs/2/cities/
// https://secure.meetup.com/meetup_api/console/?path=/2/cities
// https://secure.meetup.com/meetup_api/console/?path=/dashboard

$cities = $meetup->cities();
$dashboard = $meetup->dashboard();



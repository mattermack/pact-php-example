<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/ExampleGuzzleMeetupApiClient.php');

$httpClient = new \GuzzleHttp\Client();
$meetup = new ExampleGuzzleMeetupApiClient($httpClient, "http://localhost:1349");

// https://www.meetup.com/meetup_api/docs/2/categories/
//https://secure.meetup.com/meetup_api/console/?path=/2/categories
/*

HTTP/1.1 200 success
{

    "results": [
        {
                "name": "Games",
                "sort_name": "Games",
                "id": 11,
                "shortname": "Games"
        },
        {
            "name": "Book Clubs",
            "sort_name": "Book Clubs",
            "id": 18,
            "shortname": "Book Clubs"
        }
    ]
}
 */
$categories = $meetup->categories();
echo print_r($categories, true);
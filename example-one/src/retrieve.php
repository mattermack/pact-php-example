<?php
require_once ("../vendor/autoload.php");
require_once ("ExampleOneMeetupApiClient.php");

$uri = new \GuzzleHttp\Psr7\Uri("http://localhost:1349");
$meetup = new \ExampleOneMeetupApiClient($uri);

$categories = $meetup->categories();
echo print_r((string) $categories->getBody(), true);

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

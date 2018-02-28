<?php
/*
To allow the correct data to be set up before each interaction is replayed, you will need to create a dev/test only HTTP
endpoint that accepts a JSON document that looks like:
{
"consumer": "CONSUMER_NAME",
"state": "PROVIDER_STATE"
}
The endpoint should set up the given provider state for the given consumer synchronously, and return an error if the provider
state is not recognised. Namespacing your provider states within each consumer will avoid clashes if more than one consumer
defines the same provider state with different data.
The following flag is required when running the CLI:

The following flag is required when running the CLI:
--provider-states-setup-url - the full url of the endpoint which sets the active consumer and provider state.

Rather than tearing down the specific test data created after each interaction, you should clear all the existing data at the start
of each set up call. This is a more reliable method of ensuring that your test data does not leak from one test to another.
Note that the HTTP endpoint does not have to actually be within your application - it just has to have access to the same data
store. So if you cannot add "test only" endpoints during your verification, consider making a separate app which shares
credentials to your app's datastore. It is highly recommended that you run your verifications against a locally running
provider, rather than a deployed one, as this will make it much easier to stub any downstream calls, debug issues, and it will
make your tests run as fast as possible.

*/

// how do I get the JSON to be send back?

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

$result = file_put_contents("../dashboard/index.php", $str);

echo "File write " . (!$result ? "failed" : "successful");

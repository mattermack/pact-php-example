# Pact PHP Examples
Here is a basic end-to-end example sans Broker and CI integration for [Pact-PHP](https://github.com/pact-foundation/pact-php/).  
This example is based on the [Meetup.com API](https://www.meetup.com/meetup_api/) written for the [Austin PHP Meetup](https://www.meetup.com/austinphp/).  
Here we setup a scenario with two consumers/clients and one provider/api.  

This example is targeting the Pact-PHP 3.X and above.   If you want to look at the [2.2.1](https://github.com/mattermack/example-pact-php/tree/2.2.1) tag to see the Pact-PHP 2.X implementation.

## Example One Client
1. Use the Meetup.com API to pull `categories` version 2
2. Build a mock and publish a PACT using Pact PHP 3.0 matchers to a local folder
3. Run using test/run_test.bat


## Example Two Client
1. Use the Meetup.com API to pull `cities` on version 2 
2. Use the Meetup.com API to pull `dashboards`
3. Build a mock and publish a PACT with both interactions to a local folder
4. Run using test/run_test.bat


## Example API
1. Under the src folder, pretend we are Meetup.com and we want to test against our clients.  
2. Pull the Pacts 
3. Configure an API end point to setup state for the Example Two Client dashboards end point.  This is under the src/state section.
4. Run using test/run_test.bat
5. The unit tests kill the server after three minutes

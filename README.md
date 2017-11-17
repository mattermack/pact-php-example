# Pact PHP Examples

Examples for [Pact-PHP](https://github.com/pact-foundation/pact-php/) for Austin PHP Meetup

### Example One 
Assume we use the Meetup.com API to pull `categories` version 2.   Build a mock and publish a PACT.   This uses Pact PHP 2.0 matchers

### Example Two 
Assume we use the Meetup.com API to pull `cities` on version 2 and `dashboards`.   Build a mock and publish a PACT


### Example API
Pretend we are Meetup.com and we want to test against our clients.  Pull the Pacts and setup appropriate state to test
The unit tests kill the server after two minutes

### Other 
Under API\tests run publish-pact and pull-pact-via-broker

### Example Guzzle
This was added later and not yet wired up to the API to verify against the Provider.   The change is that instead of the client using Windwalker, it uses Guzzle.   To make the interface with Guzzle work, I had to modify the MockClient to build the Pacts.
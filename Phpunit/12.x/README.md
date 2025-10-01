# PHPUnit

PHPUnit is used to unit test PHP and Laravel code.

See `phpunit.xml` for an example of how to configure a Laravel project.

Note that our standard PHPUnit configuration never hits external services. 

> Review your `.env` and add a "do-not-use" for every single value that enables communication with an external service

External tests can be launched with a call to the external phpunit-external.xml file.  This will exercise external calls.

> Make sure your local .env has the correct values for running external tests

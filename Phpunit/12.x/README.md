


### Testing

`phpunit.xml` - normal config for local and CI tests
* We pre-generate an APP_KEY
* We set DB_DATABASE and DB_HOST for mysql-test config in docker-compose.yml
* Review your `.env` and add a "do-not-use" for every single value that enables communication with an external service

`phpunit-external.xml` - meant to be run separately against real external services
* Comment out the normal external service overrides from `phpunit.xml`
* Make sure your local .env has the correct values for running external tests

In many cases, you can just copy the whole `tests` folder into your project, but it would be a good idea to do a diff of the changes,
just to make sure something wasn't changed in a newer version of Laravel, or any other desired settings in an existing project aren't reverted.




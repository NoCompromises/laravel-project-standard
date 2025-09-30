# External Tests

Our normal test suite is set up to force mocking any external services. But it's useful to do a real call to an external
service to verify it's working as expected. We separate these tests out into an `external` test suite, so we can run them
only as-needed.

The configuration is managed by the `phpunit-external.xml` file and tests are executed by running `docker/bin/composer test-external`.

Usually each external service will have one corresponding test file in this folder.

For every external service, make sure your local `.env` has proper credentials setup for a test environment. Add an
explicit row in `phpunit-external.xml` for each environment variable, and comment it out, to make it clear this needs
to be setup.

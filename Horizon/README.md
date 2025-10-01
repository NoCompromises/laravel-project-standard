# Laravel Horizon

The horizon container can be found in the Docker configuration directory.  These instructions are for usage of the container after it is running.

## Running Horizon

The `.env.example` file sets up queues to run with the `redis` configuration, and we use Horizon to manage the queue workers.

By default `docker compose up` will start a Horizon worker in a separate container. If, for some reason you want to stop
Horizon, you can stop that container with `docker compose stop horizon`.

> Be aware, if you're changing code and also interacting with the queues, you will need to restart horizon in order to
> have the new code loaded: `docker compose restart horizon`

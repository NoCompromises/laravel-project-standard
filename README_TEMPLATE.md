# Project/Site Name

## Overview

A brief description about what this project is and how it is used.

## Integrations

For each service you integrate with (for example, Stripe) create a section here.

### Service Name

Explain what the service is used for.

Document how to create a test account for the service or how to gain access to a
pre-existing test account for this project. Explain where production credentials for this service can be obtained.

Document exactly which `.env` keys need to be set. If any manual setup within the account is necessary (for example, 
specific products or webhooks for Stripe), document it step-by-step.

## First Time Set-up for Local Development

To get started with local development, follow these steps. Make sure you run all commands from the top-level of your project.

### DNS resolution

> Decide on a local domain to use for this project. Substitute that any place you see `my-project.local` or `my-project` below.

By default, this project will run on the host `my-project.local`.
OrbStack (see below) is already configured to serve on this top-level domain.

If you're not using OrbStack, you will need some sort of local DNS resolution for that hostname to your localhost IP address.
One easy way to do this for the entire `.local` top-level domain, is to run a lightweight tool called `dnsmasq`.
You can install it via Homebrew on a Mac with: `brew install dnsmasq`.

> If you've ever setup Valet, it already installed dnsmasq for you. You can verify if it's already installed by running
> `brew services` and see if `dnsmasq` is listed.

If you don't want to run `dnsmasq`, you can also add a manual DNS entry to your `/etc/hosts` file in the form:
`127.0.0.1 my-project.local`

### Setting up an SSL certificate

Orbstack provides automatic TLS certificates for `.local` domains, but we will also need to create one that Vite can use.

To do this, we'll use `mkcert`, a simple tool for making locally-trusted development certificates.

To install on Mac with Homebrew, you can run:

`brew install mkcert nss`

For other platforms or configurations, you can refer to the [mkcert README](https://github.com/FiloSottile/mkcert)

Once `mkcert` is installed, we need to generate our local development root certificate authority:

> If you've used `mkcert` before, you can skip this step
> This command will likely prompt you for administrator access on macOS

`mkcert -install`

Then, generate the certificates for this project and put them into a location accessible to your docker setup:

`mkcert -cert-file docker/vite/ssl.pem -key-file docker/vite/key.pem my-project.test`

We're using the `.test` top-level domain for the Vite server.

### Node environment
The best option to ensure you're using the correct versions of Node and npm with this project is to install [Volta](https://volta.sh).
Volta will read the pinned versions of Node and npm from the `package.json` so you can be sure you're using the correct versions.

### Get the project running in Docker

Docker is used for local development. It's self-contained, easy to set up, and matches the exact versions of key services
running in production. We use [OrbStack](https://orbstack.dev) as our Docker engine, since it handles domain resolution and port mapping.
This config also works with [Docker Desktop](https://www.docker.com/products/docker-desktop/), but you may need to add explicit port mappings.

**Setup the environment**

Open the `.env.example` file and update the `COMPOSE_PROJECT_NAME` and `DOCKER_SERVER_NAME` settings to match your project.

Make a copy of the example env file: `cp .env.example .env`

**Get Docker running**

Most of our Docker configuration is managed with Docker Compose. You can view the `docker-compose.yml` file to see how it
is configured.

To build and bring up the Docker containers, run `docker compose up -d`. If this is your first time running the command, it
may take a few minutes to pull down images and build the containers. Subsequent runs will be much quicker.

You can verify that your containers are in a running state with `docker compose ps`.

**Composer licensing**

> If this project uses a paid Composer package, like Nova, document it here

This project uses a paid Composer package `package-name`, and in order to do a `composer install`, you need a valid license key.

To set that up, create an `auth.json` file from the example:
`cp auth.json.example auth.json`

And then open `auth.json` and fill out the username and password values.

**Normal project setup**

With the certificates, our environment, and Docker setup, the rest of these steps will be typical steps for any Laravel
project. The one key difference is that instead of running tools like composer and artisan directly, we need to run
them from inside the container. This is very important. If we run the tools from our host environment, all the guarantees
about versions of tooling will no longer apply.

To make it easier to run tools via Docker, a collection of simple shell scripts exists in the project's `docker/bin` directory.

Run these commands to finish the local development setup
* `npm install`
* `npm run dev`
* `docker/bin/composer install`
* `docker/bin/composer run post-root-package-install`
* `docker/bin/composer run post-create-project-cmd`
* `docker/bin/artisan horizon:install`
* `docker/bin/artisan migrate --seed`

You're good to go - surf to https://my-project.local

You can also use any normal database management tools and connect to the database using the port specified in `.env`.

## Normal Developer Workflow

Generally speaking, you don't want your Docker containers running unless you're actively using them. So each time you're
ready to start development, you would start your Docker environment:

`docker compose up -d`

> The `-d` means "detach" and it runs the containers in the background, so you can continue to use your terminal. If you run
> without `-d`, the terminal would remain bound to the containers, and you'd see a stream of container log output in your
> terminal. This can be useful when debugging a Docker issue, but for normal development, running in the background is best.

Then, when you're done for the day, you can stop the Docker environment:

`docker compose stop`

> There is also a `down` command, and it might seem more logical as the opposite action of `up`. This command not only stops
> the containers, but removes them along with the Docker network. This doesn't harm anything, and no data will be lost if you
> run `down` instead, but there's no need to constantly remove and recreate the containers, so `stop` is a better choice.

## Running Horizon

The `.env.example` file sets up queues to run with the `redis` configuration, and we use Horizon to manage the queue workers.

By default `docker compose up` will start a Horizon worker in a separate container. If, for some reason you want to stop
Horizon, you can stop that container with `docker compose stop horizon`.

> Be aware, if you're changing code and also interacting with the queues, you will need to restart horizon in order to
> have the new code loaded: `docker compose restart horizon`

## Docker upgrades

One of the goals of Docker is to match your staging/production environments precisely. If you are planning an upgrade of
PHP, nginx, or MySQL in those environments, you should first upgrade your Docker environment, and validate everything
works as expected.

This section contains some guidelines on how to upgrade your Docker configuration.

### MySQL

> If you use Postgres instead, this is basically the same. Substitute in postgres for mysql as needed. See the
> `docker-compose.yml` file for a commented-out Postgres configuration you could use.

In the `docker-compose.yml` file, update the image property for both the `mysql` and `mysql-test` services. You can
find a specific image version on [Docker Hub](https://hub.docker.com). Make sure to stick with the alpine images. These
will all have the `-alpine` suffix.

> If you want to change any of the parameters about MySQL, like the user and password, you'll also need to delete
> the volumes before bringing up the new containers:
>
> `docker volume rm my-project_mysql-data my-project_mysql-test-data`
>
> If you don't, db initialization will be skipped, and it will still be running with the old parameters.

After updating the file, follow these steps:

1. Bring down the current containers: `docker compose stop mysql mysql-test`
2. Remove the containers: `docker compose rm` (It should ask if you want to remove the two containers you just stopped)
3. Bring up the new containers: `docker compose up -d`. You should see it pull the new images before starting.

To verify the correct version is now running, you can open the container in Docker Desktop, and you should see the new
MySQL version mentioned in the log output.

### nginx

If you want to change the version of nginx, edit the first line in `docker/nginx/Dockerfile` to reflect the desired version
number. Make sure to pick the alpine version of any image.

If you want to make a configuration change, you can do this in `docker/nginx/nginx.conf`.

For either type of change, you'll need to rebuild the images:

1. Bring down the current containers: `docker compose stop nginx`
2. Remove the containers: `docker compose rm` (It should ask if you want to remove the container you just stopped)
3. Rebuild the containers: `docker compose build --no-cache nginx` (Bypassing the cache isn't always necessary, but it's a safe default)
4. Bring up the new containers: `docker compose up -d`. You should see it pull the new images before starting.

To verify the correct version is now running, you can open the container in Docker Desktop, and you should see the new
nginx version mentioned in the log output. If it doesn't show in the logs, you can click the CLI button for the container
and run `nginx -v` from the terminal that launches.

### PHP

If you want to change the version of PHP, edit the first line in `docker/php-fpm/Dockerfile` to reflect the desired version
number. Make sure to pick the alpine version of any image, and make sure it's the `fpm` image or else nginx won't work with it.

If you want to add or change any extensions, you can do that by modifying the `RUN docker-php-ext-install` command. Some
extensions will also require OS dependencies, which you can add in the `RUN apk add` command.

If you want to update Composer, change the version of composer in the first `COPY` command.

You can also modify any `.ini` files or add entirely new ones by creating the file and adding a corresponding `COPY` command.

For all types of change, you'll need to rebuild the images:

1. Bring down the current containers: `docker compose stop php-fpm php-fpm-debug`
2. Remove the containers: `docker compose rm` (It should ask if you want to remove the two containers you just stopped)
3. Rebuild the containers: `docker compose build --no-cache php-fpm php-fpm-debug` (Bypassing the cache isn't always necessary, but it's a safe default)
4. Bring up the new containers: `docker compose up -d`. You should see it pull the new images before starting.

To verify the correct version is now running, you can open the container in Docker Desktop, click the CLI button for the
container and run `php -v` from the terminal that launches.

### Node/npm

If you want to change the version of `node`, run `volta pin node@XYZ` where `XYZ` is the desired version. The same works for `npm` with `volta pin npm@XYZ`

This will update the corresponding sections of the `volta` object in `package.json`.

To verify the correct version is now running, you can run `node -v` or `npm -v`.

## Deployment / CI Process

Continuous Integration is run on every branch, using Github Actions. The workflow exists at `.github/workflows/ci.yml`

List each environment in use, like staging and production. For each environment, document where it is hosted and the basic
infrastructure in use.

Document how new code makes it into each environment. Does a particular branch correspond to an environment?
If the deployment process is automated, document what the triggers are. If it's a manual process, provide step-by-step
instructions on how to deploy.

## Artifacts

If this project produces code artifacts to be used by someone else (for example, a Vue component), document that here and
provide detailed instructions on how to use the artifact. These should have enough context, that they could be copied and
pasted into an email to some other dev not on this project, and they would understand how to make use of it.

## Manual processes

Ideally all typical developer tasks would be automated, but sometimes a manual process is necessary. If so, describe it
here in precise detail: what is the process, when would you need to do it, what are the exact steps?

## History

If there are any relevant bits of architectural history, include them here. For example, is this a major rewrite of some
previous codebase? Mention it here. Include anything that you would want to know if you were inheriting the project.

## Laravel Project Standard

If you'd like, include a link to the laravel-project-standard repo and what version this project is based on.

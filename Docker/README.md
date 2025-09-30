# Docker

Preferred runtime for Docker is [OrbStack](https://orbstack.dev).









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

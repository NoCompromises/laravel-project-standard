# Laravel Project Standard

## Purpose

This is a baseline of Laravel project standards that we use at No Compromises for all projects.

It is not meant to be a tool for generating new projects, but instead something to be compared against a new or existing
Laravel project.

## Versioning

Over time, we adopt new standards or change our preferred way of doing something. Each time a change is made, a new version
of this standard will be tagged. That version can be included in each project that follows these standards. Then, when a
project is reviewed, changes introduced in a new version can be easily compared against what version of standards the 
project is currently using.

## Contents

### Documentation

`README_TEMPLATE.md` is a starter README to be included in all projects. It provides a template for
what sort of information projects should have, along with some re-usable content about how to use the local Docker
development environment. Rename it to `README.md` in your project.

Other README files can be used as needed. For example, an OpenAPI spec might be accompanied by a dedicated README which
explains how to generate a browser-based version of the spec from the YAML file.

The other files provided in this repo are heavily documented internally. For example, the `docker-compose.yml` file
contains lots of comments explaining why things are done a certain way, or other alternate configurations that may be
needed on a project-by-project basis.

### Docker

* `docker-compose.yml`
* `docker` folder
  * nginx/Dockerfile - update project name for cert files
  * nginx/nginx.conf - update project name for cert files
* Additions and changes to `.env.example` and `.env`
  * APP_URL - set to be https and include the Docker host port mapping
  * COMPOSE_PROJECT_NAME
  * DOCKER_MYSQL_LOCAL_PORT
  * DOCKER_NGINX_LOCAL_PORT
  * DOCKER_SERVER_NAME
  * DB_HOST - set to use Docker mysql service
  * DB_DATABASE, DB_USERNAME, DB_PASSWORD - set to use Docker mysql service defaults

### Git

The `.gitignore` file is the Laravel default, with these additions:
* `docker/nginx/*.pem` - ignores the generated certificate files for Docker
* `tests/html-coverage` - ignore test coverage output

We use two long-running branches for development: `develop` and `main`.
* `develop` corresponds to the staging environment
* `main` corresponds to production

New work is done in feature branches based off `develop`. When work is completed, it is merged to `develop` and verified
in the staging environment. Once it's ready to go live in production, it is merged to `master`.

### Composer

Packages we use in every project:

Non-dev dependencies
* `bugsnag/bugsnag-laravel`
* `roave/security-advisories`
* `spatie/laravel-permission`
* `owen-it/laravel-auditing`

Dev dependencies
* `barryvdh/laravel-ide-helper`
* `doctrine/dbal`
* `laravel/telescope`
* `nunomaduro/larastan`
* `slevomat/coding-standard`
* `squizlabs/php_codesniffer`

We also move the `laravel/tinker` package into the dev requirements, so it's not installed in production.

Within the `scripts` section of `composer.json`, we make the following changes:
* Add `ide-helper` generation to the `post-update-cmd`
* Add `test` and `test-coverage` scripts
* Add a dedicated `ide-helper-update` script to regenerate everything for that package
* Add `phpcs` for detecting code standard violation
* Add `phpcbf` for automatically fixing code standard violations - only used locally, mainly when adding a new rule
* Add `larastan` for static analysis

The `config` block has code sniffer plugins pre-allowed.

Anytime you add a private package, make sure to add a sanitized config to `auth.example.json`

### Front end

New Laravel installs default to Vite, but we're still using Webpack on our projects.

Follow the Docker instructions in the README to make sure all npm commands are run through Docker containers.

### Code Standards

Configured with `phpcs.xml`

PHP Code Sniffer is used, not `php-cs-fixer` or `pint`.

### Static Analysis

Configured with `phpstan.neon`

Currently, we run all projects at PHPStan level 1. This will be increased gradually.

Both applications AND tests are covered with static analysis.

### Testing

phpunit.xml and what to override, base classes and purpose, different test runners including coverage, seeders, factories

### Continuous Integration

Github Action file

### Production

Forge + Envoyer, ChecklyHQ for uptime monitoring

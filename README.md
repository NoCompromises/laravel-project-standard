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

## Quickstart

If you want to use this project standard, here is a list of files you need to copy into your project:

* `docker-compose.yml`
* `docker` folder
* `.gitgnore`
* `.github` folder
* `.php-cs-fixer.php`
* `phpstan.neon`
* `phpunit.xml` and `phpunit-external.xml`
* `resources/js/app.js`

You can also remove:

* `resource/js/bootstrap.js`

Modifications are needed to the following files already in a default Laravel install:

* `.env.example` and `.env`
  * copy from `APP_URL`, `COMPOSER_PROJECT_NAME`, `DOCKER_MYSQL_LOCAL_PORT`, `DOCKER_NGINX_LOCAL_PORT`, and `DOCKER_SERVER_NAME`
  * copy `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`

Update your Composer packages and scripts:

* Install non-dev packages: `docker/bin/composer require roave/security-advisories sentry/sentry-laravel spatie/laravel-permission owen-it/laravel-auditing`
* Install dev packages: `docker/bin/composer require --dev barryvdh/laravel-ide-helper doctrine/dbal larastan/larastan laravel/telescope nocompromises/php-cs-fixer-config phpstan/phpstan-mockery`
* Move tinker to dev: `docker/bin/composer require --dev laravel/tinker` (answer YES if you are asked if you want to move)
* Add the following commands to the `post-update-cmd` script:
  * `@php artisan ide-helper:generate`
  * `@php artisan ide-helper:meta`
* Copy additional sections from `scripts`:
    * `test`, `test-coverage`, and `test-external`
    * `ide-helper-update`
    * `phpcs` and `phpcs-fix`
    * `larastan`
    * `ci` and `laravel-cache`

Normalize your test setup:

In many cases, you can just copy the whole `tests` folder into your project, but it would be a good idea to do a diff of the changes,
just to make sure something wasn't changed in a newer version of Laravel, or any other desired settings in an existing project aren't reverted.

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

Read through `docker-compose.yml` and all files in the `docker` folder for more information. These files are heavily commented.

### Git

We mainly stick with the default `.gitignore` file, but we remove Homestead and Yarn and add the following items:
* `docker/nginx/*.pem` - ignores the generated certificate files for Docker
* `tests/html-coverage` - ignore test coverage output

We use two long-running branches for development: `develop` and `main`.
* `develop` corresponds to the staging environment
* `main` corresponds to production

New work is done in feature branches based off `develop`. When work is completed, it is merged to `develop` and verified
in the staging environment. Once it's ready to go live in production, it is merged to `main`.

### Composer

Update the `name` property in `composer.json`.

Packages we use in every project:

Non-dev dependencies
* `roave/security-advisories`
* `sentry/sentry-laravel`
* `spatie/laravel-permission`
* `owen-it/laravel-auditing`

Dev dependencies
* `barryvdh/laravel-ide-helper`
* `doctrine/dbal`
* `larastan/larastan`
* `laravel/telescope`
* `nocompromises/php-cs-fixer-config`
* `phpstan/phpstan-mockery`

We also move the `laravel/tinker` package into the dev requirements, so it's not installed in production.

Remove unused packages: `docker/bin/composer remove --dev laravel/pint laravel/sail`

Within the `scripts` section of `composer.json`, we make the following changes:
* Add `ide-helper` generation to the `post-update-cmd`
* Add `test`, `test-coverage`, and `test-external` scripts
* Add a dedicated `ide-helper-update` script to regenerate everything for that package
* Add `phpcs` for detecting code standard violation
* Add `phpcs-fix` for automatically fixing code standard violations - only used locally, mainly when adding a new rule
* Add `larastan` for static analysis
* Add `ci` and `laravel-cache` for CI

Some scripts use a short command, like `phpcs`, but others use the `@php` alias, like `larastan`. The difference is subtle,
but using `@php` tells composer to use the same php process composer itself is already using. This is especially important
if you want composer's memory limit config to apply.

Anytime you add a private package, make sure to add a sanitized config to `auth.example.json`

### Front end

New Laravel installs default to Vite.

Follow the instructions in the README to setup Volta to make sure all node/npm commands are run with the correct version.

Instead of using a separate bootstrap file, we load any necessary code directly in `app.js`

### Code Standards

Configured with `.php-cs-fixer.php`

PHP Coding Standards Fixer is used, not PHP_CodeSniffer or Laravel Pint.

### Static Analysis

Configured with `phpstan.neon`

Currently, we run all projects at PHPStan level 5.

Both applications AND tests are covered with static analysis.

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

### Continuous Integration

Copy the `.github` folder. Update the `PROJECT_NAME` env variable right at the top to match your actual project/site name used in `docker-compose.yml`

### Production

* Forge for server provisioning, generally on AWS
* Envoyer for deployment, triggered from GitHub CI on success for `develop` and `main`
* Sentry for exception reporting and APM

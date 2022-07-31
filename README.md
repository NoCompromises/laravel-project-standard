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

docker-compose.yml, use of .env, contents of docker folder

### Git

.gitignore, branch strategy for features/develop/main

### Composer

packages we use on every project, scripts, scripts-descriptions, dev vs non-dev, use of auth.json for private packages

### Front end

npm scripts

### Code Standards

php cs config

### Static Analysis

phpstan level 1

### Testing

phpunit.xml and what to override, base classes and purpose, different test runners including coverage, seeders, factories

### Continuous Integration

Github Action file

### Production

Forge + Envoyer, ChecklyHQ for uptime monitoring
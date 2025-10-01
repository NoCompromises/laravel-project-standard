# Composer

This is the general Composer configuration documentation.  You may find specific configuration examples in the documentation folders of the tooling.

## Running Other Scripts

Some scripts use a short command, like `phpcs`, but others use the `@php` alias, like `larastan`. The difference is subtle,
but using `@php` tells composer to use the same php process composer itself is already using. This is especially important
if you want composer's memory limit config to apply.

## Licenses

If this project uses a paid Composer package, like Nova, authorize the license with the `auth.json` file.

To set that up, create an `auth.json` file from the example:

`cp auth.json.example auth.json`

And then open `auth.json` and fill out the username and password values.

Finally, add `auth.json` to your `.gitignore` file.

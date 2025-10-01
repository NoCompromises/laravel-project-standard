<?php

declare(strict_types=1);

/**
 * Sentry Laravel SDK configuration file.
 *
 * NOTE: The default Sentry config delegates to environment variables (like most configs do), but we do not need
 *       to have different Sentry configs per environment, so we've removed the env settings and hard code instead.
 *
 *       The one exception is for sampling rates. We may want to tune those in production without requiring a code change.
 *
 * @see https://docs.sentry.io/platforms/php/guides/laravel/configuration/options/
 */
return [
    // @see https://docs.sentry.io/product/sentry-basics/dsn-explainer/
    'dsn' => env('SENTRY_LARAVEL_DSN', env('SENTRY_DSN')),

    // @see https://spotlightjs.com/
    // 'spotlight' => env('SENTRY_SPOTLIGHT', false),

    // @see: https://docs.sentry.io/platforms/php/guides/laravel/configuration/options/#logger
    // 'logger' => Sentry\Logger\DebugFileLogger::class, // By default this will log to `storage_path('logs/sentry.log')`

    // The release version of your application
    // Example with dynamic git hash: trim(exec('git --git-dir ' . base_path('.git') . ' log --pretty="%h" -n1 HEAD'))
    'release' => env('SENTRY_RELEASE'),

    // When left empty or `null` the Laravel environment will be used (usually discovered from `APP_ENV` in your `.env`)
    'environment' => env('SENTRY_ENVIRONMENT'),

    // @see: https://docs.sentry.io/platforms/php/guides/laravel/configuration/options/#sample_rate
    'sample_rate' => env('SENTRY_SAMPLE_RATE') === null ? 1.0 : (float) env('SENTRY_SAMPLE_RATE'),

    // @see: https://docs.sentry.io/platforms/php/guides/laravel/configuration/options/#traces_sample_rate
    'traces_sample_rate' => env('SENTRY_TRACES_SAMPLE_RATE') === null ? null : (float) env('SENTRY_TRACES_SAMPLE_RATE'),

    // @see: https://docs.sentry.io/platforms/php/guides/laravel/configuration/options/#profiles-sample-rate
    'profiles_sample_rate' => env('SENTRY_PROFILES_SAMPLE_RATE') === null ? null : (float) env('SENTRY_PROFILES_SAMPLE_RATE'),

    // @see: https://docs.sentry.io/platforms/php/guides/laravel/configuration/options/#enable_logs
    'enable_logs' => true,

    // @see: https://docs.sentry.io/platforms/php/guides/laravel/configuration/options/#send_default_pii
    'send_default_pii' => true,

    // @see: https://docs.sentry.io/platforms/php/guides/laravel/configuration/options/#ignore_exceptions
    // 'ignore_exceptions' => [],

    // @see: https://docs.sentry.io/platforms/php/guides/laravel/configuration/options/#ignore_transactions
    'ignore_transactions' => [
        // Ignore Laravel's default health URL
        '/up',
    ],

    // Breadcrumb specific configuration
    'breadcrumbs' => [
        // Capture Laravel logs as breadcrumbs
        'logs' => true,

        // Capture Laravel cache events (hits, writes etc.) as breadcrumbs
        'cache' => true,

        // Capture Livewire components like routes as breadcrumbs
        'livewire' => true,

        // Capture SQL queries as breadcrumbs
        'sql_queries' => true,

        // Capture SQL query bindings (parameters) in SQL query breadcrumbs
        'sql_bindings' => true, // overrode default

        // Capture queue job information as breadcrumbs
        'queue_info' => true,

        // Capture command information as breadcrumbs
        'command_info' => true,

        // Capture HTTP client request information as breadcrumbs
        'http_client_requests' => true,

        // Capture send notifications as breadcrumbs
        'notifications' => true,
    ],

    // Performance monitoring specific configuration
    'tracing' => [
        // Trace queue jobs as their own transactions (this enables tracing for queue jobs)
        'queue_job_transactions' => true,

        // Capture queue jobs as spans when executed on the sync driver
        'queue_jobs' => true,

        // Capture SQL queries as spans
        'sql_queries' => true,

        // Capture SQL query bindings (parameters) in SQL query spans
        'sql_bindings' => false,

        // Capture where the SQL query originated from on the SQL query spans
        'sql_origin' => true,

        // Define a threshold in milliseconds for SQL queries to resolve their origin
        'sql_origin_threshold_ms' => env('SENTRY_TRACE_SQL_ORIGIN_THRESHOLD_MS', 100),

        // Capture views rendered as spans
        'views' => true,

        // Capture Livewire components as spans
        'livewire' => true,

        // Capture HTTP client requests as spans
        'http_client_requests' => true,

        // Capture Laravel cache events (hits, writes etc.) as spans
        'cache' => true,

        // Capture Redis operations as spans (this enables Redis events in Laravel)
        'redis_commands' => false,

        // Capture where the Redis command originated from on the Redis command spans
        'redis_origin' => true,

        // Capture send notifications as spans
        'notifications' => true,

        // Enable tracing for requests without a matching route (404's)
        'missing_routes' => true, // overrode default

        // Configures if the performance trace should continue after the response has been sent to the user until the application terminates
        // This is required to capture any spans that are created after the response has been sent like queue jobs dispatched using `dispatch(...)->afterResponse()` for example
        'continue_after_response' => true,

        // Enable the tracing integrations supplied by Sentry (recommended)
        'default_integrations' => true,
    ],
];

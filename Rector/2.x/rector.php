<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\Config\RectorConfig;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    ->withCache(
        cacheDirectory: '.rector-cache', // Add to .gitignore
        cacheClass: FileCacheStorage::class,
    )
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->withPhpSets(php84: true)
    ->withSets([
        LaravelSetList::LARAVEL_120,
    ])
    ->withSkip([
        \Rector\Php81\Rector\Array_\FirstClassCallableRector::class => [
            __DIR__ . '/routes/api.php',
            __DIR__ . '/routes/web.php',
        ],
        \Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector::class,
        \Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector::class => [
            __DIR__ . '/tests', // we like unused variables in tests for clear naming
        ],
    ])
    ->withRules([
        // will add these as the project matures
    ])
    ->withTypeCoverageLevel(5) // max level is 36
    ->withDeadCodeLevel(46); // max level is 50

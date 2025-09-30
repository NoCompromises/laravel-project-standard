<?php

declare(strict_types=1);

return (NoCompromises\PhpCsFixer\Config\Factory::create(__DIR__))
    ->setParallelConfig(\PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect());

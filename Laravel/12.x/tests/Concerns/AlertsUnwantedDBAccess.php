<?php

/**
 * This trait adds a listener to the DB connection that lets us know when we've accessed the DB accidentally
 */

declare(strict_types=1);

namespace Tests\Concerns;

use Illuminate\Support\Facades\DB;
use Tests\Exceptions\DatabaseAccessException;

trait AlertsUnwantedDBAccess
{
    /**
     * Registers the database listener to throw an exception
     */
    protected function alertUnwantedDBAccess(): void
    {
        DB::listen(function ($query) {
            throw new DatabaseAccessException($query->sql);
        });
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\Concerns\AlertsUnwantedDBAccess;
use Tests\Concerns\HasTodo;
use Tests\TestCase;

abstract class UnitTestCase extends TestCase
{
    use AlertsUnwantedDBAccess, HasTodo;

    /**
     * Set up the unwanted db access exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->alertUnwantedDBAccess();
    }
}

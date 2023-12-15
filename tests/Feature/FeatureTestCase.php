<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\Concerns\CreatesActingAs;
use Tests\Integration\IntegrationTestCase;

class FeatureTestCase extends IntegrationTestCase
{
    use CreatesActingAs;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }
}

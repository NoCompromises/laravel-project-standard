<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\Concerns\CreatingActingAs;
use Tests\Integration\IntegrationTestCase;

/**
 * Class FeatureTestCase
 */
class FeatureTestCase extends IntegrationTestCase
{
    use CreatingActingAs;
}

<?php

declare(strict_types=1);

namespace Tests\Integration;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\HasTodo;
use Tests\TestCase;

/**
 * Class IntegrationTestCase
 * @package Tests\Integration
 */
abstract class IntegrationTestCase extends TestCase
{
    use RefreshDatabase, HasTodo;

    /**
     * @var bool tells it to seed (basically executes `migrate:fresh --seed`)
     */
    protected $seed = true;
}

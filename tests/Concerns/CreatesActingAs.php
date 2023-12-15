<?php

/**
 * Use a user model to create the acting as user
 */

declare(strict_types=1);

namespace Tests\Concerns;

use App\Models\User;

trait CreatesActingAs
{
    protected User $actingAs;

    /**
     * Create an acting as user, save it, and return it
     *
     * Note that this uses the config option, but it can be overridden by the other option
     */
    protected function createActingAs(array $properties = []): User
    {
        $this->actingAs = User::factory()->create($properties);
        $this->actingAs($this->actingAs);
        return $this->actingAs;
    }
}

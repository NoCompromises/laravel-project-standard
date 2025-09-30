<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Example;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Example>
 */
class ExampleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }

    // state example
    public function withoutPassword(): static
    {
        return $this->state(['password' => null]);
    }

    // callback example
    public function programmer(): static
    {
        return $this->afterCreating(fn(User $user) => $user->assignRole(Role::PROGRAMMER));
    }
}

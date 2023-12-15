<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Overriding this so we can enforce the gate check, even in the local environment
     */
    protected function authorization(): void
    {
        $this->gate();

        Horizon::auth(function ($request) {
            return Gate::check('viewHorizon', [$request->user()]);
        });
    }

    protected function gate(): void
    {
        Gate::define('viewHorizon', function (User $user) {
            return false; // usually something like $user->hasRole(Role::Programmer->value)
        });
    }
}

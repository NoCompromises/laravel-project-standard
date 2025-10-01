<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerGlobalFunctions(); // this is an example of how to load global functions that don't require function_exists()
    }

    protected function registerGlobalFunctions(): void
    {
        require_once app_path('/global_functions.php');
    }
}

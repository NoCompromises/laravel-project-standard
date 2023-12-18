<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (App::environment(['local', 'staging'])) {
            $this->call(DevDataSeeder::class);
        }
    }
}

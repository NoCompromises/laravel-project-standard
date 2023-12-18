<?php

declare(strict_types=1);

namespace Tests\Feature;

class ExampleTest extends FeatureTestCase
{
    public function testHomeSuccess(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature;

class ExampleTest extends FeatureTestCase
{
    /**
     * A basic test example.
     */
    public function testHomeSuccess()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_public_navigation_pages_return_successful_responses(): void
    {
        foreach (['/tentang', '/layanan', '/psikolog', '/event'] as $path) {
            $this->get($path)->assertStatus(200);
        }
    }
}

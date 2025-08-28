<?php

namespace Tests\Feature;

use Tests\TestCase;

class ShortURLTest extends TestCase
{
    public function test_shorturl_index_returns_a_successful_response(): void
    {
        $this->withoutMiddleware();

        $response = $this->get('/api/short-url');
        $response->assertStatus(200);
    }
}

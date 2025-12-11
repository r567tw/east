<?php

namespace Tests\Feature;

use App\Models\ShortUrl;
use Tests\TestCase;

class ShortURLTest extends TestCase
{
    public function test_shorturl_index_returns_a_successful_response(): void
    {
        $this->withoutMiddleware();

        $response = $this->get('/api/short-url');
        $response->assertStatus(200);
    }

    public function test_shorturl_success_redirect_response(): void
    {
        ShortUrl::factory()->create([
            'short' => 'abc123',
            'url' => 'https://example.com',
        ]);

        $response = $this->get('/s/abc123');
        $response->assertStatus(302);
        $response->assertRedirect('https://example.com');
    }

    public function test_shorturl_error_redirect_expired_response(): void
    {
        $result = ShortUrl::factory()->create([
            'url' => 'https://example.com',
            'expires_at' => now()->subDays(1),
        ]);

        $response = $this->get('/s/' . $result->short);
        $response->assertStatus(410);
    }

    public function test_shorturl_error_redirect_not_found_response(): void
    {
        $response = $this->get('/s/nonexistent');
        $response->assertStatus(404);
    }
}

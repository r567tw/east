<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ShortUrlApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_short_url_index_unauthorized()
    {
        $response = $this->getJson('/api/short-url');
        $response->assertStatus(401);
    }

    public function test_short_url_index_authorized()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeader('Authorization', "Bearer $token")->getJson('/api/short-url');
        $response->assertStatus(200);
    }

    public function test_short_url_store_unauthorized()
    {
        $response = $this->postJson('/api/short-url', [
            'url' => 'https://example.com',
        ]);
        $response->assertStatus(401);
    }
}

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

    public function test_short_url_store_authorized()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeader('Authorization', "Bearer $token")->postJson('/api/short-url', [
            'url' => 'https://example.com',
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('short_urls', [
            'url' => 'https://example.com'
        ]);
    }

    public function test_short_url_store_hasExpiresAt_authorized()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeader('Authorization', "Bearer $token")->postJson('/api/short-url', [
            'url' => 'https://example.com',
            'expires_at' => now()->addDays(7)->toDateTimeString(),
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('short_urls', [
            'url' => 'https://example.com'
        ]);
    }

    public function test_short_url_store_hasCustomCode_authorized()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeader('Authorization', "Bearer $token")->postJson('/api/short-url', [
            'url' => 'https://example.com',
            'code' => 'custom123',
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('short_urls', [
            'url' => 'https://example.com'
        ]);
        $response->assertJson([
            'data' => ['short' => 'custom123']
        ]);
    }

    public function test_short_url_store_CodeRegenerate_authorized()
    {
        // 1. 先建立一筆已存在的 short code
        \App\Models\ShortUrl::factory()->create([
            'short' => 'ABC123',
            'expires_at' => now()->addDay(),
        ]);

        // 2. Mock Str::random 讓第一次回傳已存在的 code，第二次回傳新 code
        $serviceMock = \Mockery::mock(\App\Services\ShortUrlService::class);
        $serviceMock->shouldReceive('generateCode')->andReturn('ABC123', 'ZZZZZZ');
        $this->app->instance(\App\Services\ShortUrlService::class, $serviceMock);


        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeader('Authorization', "Bearer $token")->postJson('/api/short-url', [
            'url' => 'https://example.com',
        ]);
        $response->assertStatus(201);
        $this->assertEquals('ZZZZZZ', $response->json('data.short'));
    }
}

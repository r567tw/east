<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LocationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_our_location_success()
    {
        // 模擬外部 API 回傳
        Http::fake([
            '*' => Http::response([
                'address' => [
                    'city' => '台北市',
                ],
            ], 200),
        ]);

        $response = $this->postJson('/api/get-our-location', [
            'lat' => 25.033,
            'lng' => 121.5654,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'location' => '台北市',
            ]);
    }

    public function test_get_our_location_fail_validation()
    {
        $response = $this->postJson('/api/get-our-location', [
            'lat' => 'abc',
            'lng' => 'xyz',
        ]);
        $response->assertStatus(422);
    }

    // set-our-location 需 JWT 驗證，這裡僅測試未授權
    public function test_set_our_location_unauthorized()
    {
        $response = $this->postJson('/api/set-our-location', [
            'lat' => 25.033,
            'lng' => 121.5654,
        ]);
        $response->assertStatus(401);
    }

    public function test_get_our_location_error()
    {
        // 模擬外部 API 回傳
        Http::fake([
            '*' => Http::response([
                'error' => 'Invalid request',
            ], 500),
        ]);

        $response = $this->postJson('/api/get-our-location', [
            'lat' => 25.033,
            'lng' => 121.5654,
        ]);
        $response->assertStatus(404);
        $response->assertJson([
            'error' => 'Unable to fetch location data'
        ]);
    }

    public function test_set_our_location_fail_validation()
    {
        $user = \App\Models\User::factory()->create();
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('/api/get-our-location', [
            'lat' => 'abc',
            'lng' => 'xyz',
        ]);
        $response->assertStatus(422);
    }

    public function test_set_our_location_error()
    {
        // 模擬外部 API 回傳
        Http::fake([
            '*' => Http::response([
                'error' => 'Invalid request',
            ], 500),
        ]);

        $user = \App\Models\User::factory()->create();
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('/api/set-our-location', [
            'lat' => 25.033,
            'lng' => 121.5654,
        ]);
        $response->assertStatus(500);
        $response->assertJson([
            'error' => 'Unable to fetch location data'
        ]);
    }

    public function test_set_our_location_success()
    {
        // 模擬外部 API 回傳
        Http::fake([
            '*' => Http::response([
                'address' => [
                    'city' => '台北市',
                ],
            ], 200),
        ]);

        $user = \App\Models\User::factory()->create();
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('/api/set-our-location', [
            'lat' => 25.033,
            'lng' => 121.5654,
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Location updated successfully',
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'location' => '台北市',
        ]);
    }
}

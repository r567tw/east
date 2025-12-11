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
}

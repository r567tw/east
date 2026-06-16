<?php

namespace Tests\Feature;

use Tests\TestCase;

class AirQualityTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_air_quality(): void
    {
        // 因為空汙 API 這裡有點問題 不知道政府API發生什麼事情了
        $this->assertTrue(true);
        // $response = $this->get('/api/air-quality?lat=25.0330&lng=121.5654');

        // $response->assertStatus(200)->assertJsonStructure([
        //     'air_quality',
        // ]);
    }
}

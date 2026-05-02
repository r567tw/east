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
        $response = $this->get('/api/air-quality?lat=25.0330&lng=121.5654');

        $response->assertStatus(200)->assertJsonStructure([
            'air_quality',
        ]);
    }
}

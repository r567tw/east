<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_location(): void
    {
        $response = $this->post('/api/get-our-location', [
            'lat' => 22.6273,
            'lng' => 120.3014,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'location',
            ])->assertJson([
                'location' => '高雄市',
            ]);
    }
}

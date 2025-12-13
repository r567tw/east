<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AstroTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_astro_response(): void
    {
        $this->withoutMiddleware();

        Cache::shouldReceive('get')
            ->with('astro_8')
            ->andReturn("射手座\r\n整體運勢普通，建議多注意健康狀況。\r\n愛情運勢平穩，適合與伴侶共度時光。\r\n\r\n事業運勢有挑戰，需保持專注與耐心。\r\n財運尚可，避免大額投資。");

        $response = $this->get('/api/astro/'.urlencode('射手座'));
        $response->assertStatus(200);
    }

    public function test_astro_response_not_invalid(): void
    {
        $this->withoutMiddleware();

        $response = $this->get('/api/astro/'.urlencode('未知座'));
        $response->assertStatus(400);
        $response->assertJson([
            'error' => 'Invalid',
        ]);
    }

    public function test_astro_response_not_found(): void
    {
        $this->withoutMiddleware();

        $response = $this->get('/api/astro/'.urlencode('射手座'));
        $response->assertStatus(404);
        $response->assertJson([
            'error' => 'No data found',
        ]);
    }
}

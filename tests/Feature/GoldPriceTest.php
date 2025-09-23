<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GoldPriceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_api_get_gold_price(): void
    {
        $response = $this->get('/api/gold-price');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'currency',
                'gold_buy_price',
                'gold_sell_price',
            ]);
    }
}

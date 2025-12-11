<?php

namespace Tests\Feature;

use Tests\TestCase;

class ConvertToRomanTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_response_is_success(): void
    {
        $response = $this->get('/api/convert-to-roman?number=9');
        $response->assertHeader('Content-Type', 'application/json')->assertStatus(200)->assertJson([
            'roman' => 'IX',
        ]);
    }
}

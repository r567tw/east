<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConvertToRomanTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     */
    public function test_response_is_success(): void
    {
        $response = $this->get('/api/convert-to-roman?number=9');
        $response->assertHeader('Content-Type', 'application/json')->assertStatus(200)->assertJson([
            'roman' => 'IX',
        ]);
    }

    public function test_response_is_error(): void
    {
        $response = $this->get('/api/convert-to-roman?number=44');
        $response->assertHeader('Content-Type', 'application/json')->assertStatus(422)->assertJson([
            'error' => "Missing or invalid 'number' parameter."
        ]);
    }
}

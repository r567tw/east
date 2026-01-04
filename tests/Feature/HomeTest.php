<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    public function test_home_page_loads_successfully()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    public function test_present_page_loads_successfully()
    {
        $response = $this->get('/present');

        $response->assertStatus(200);
        $response->assertViewIs('present');
    }

    public function test_swagger_page_loads_successfully()
    {
        $response = $this->get('/swagger');

        $response->assertStatus(200);
        $response->assertViewIs('swagger');
    }

    public function test_changelog_page_loads_successfully()
    {
        $response = $this->get('/changelog');

        $response->assertStatus(200);
        $response->assertViewIs('changelog');
    }
}

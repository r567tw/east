<?php

namespace Tests\Feature;

use Tests\TestCase;

class PollPageTest extends TestCase
{
    /**
     * Test the poll page returns a successful response.
     */
    public function test_the_poll_page_returns_a_successful_response(): void
    {
        $response = $this->get('/poll');

        $response->assertStatus(200);
    }
}

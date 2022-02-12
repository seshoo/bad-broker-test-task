<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function index_is_working()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

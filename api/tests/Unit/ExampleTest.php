<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_basic()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}

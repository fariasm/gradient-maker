<?php

namespace Tests\Feature;

use App\Enums\DirectionEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DirectionTest extends TestCase
{
    public function test_valid_directions()
    {
        $this->json('get', 'api/directions')
            ->assertStatus(200)
            ->assertJson(DirectionEnum::values());
    }
}

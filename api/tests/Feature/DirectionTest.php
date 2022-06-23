<?php

namespace Tests\Feature;

use App\Enums\GradientDirection;
use Tests\TestCase;

class DirectionTest extends TestCase
{
    public function test_valid_directions()
    {
        $this->json('get', 'api/v1/directions')
            ->assertStatus(200)
            ->assertJson(GradientDirection::asArray());
    }
}

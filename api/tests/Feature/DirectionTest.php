<?php

namespace Tests\Feature;

use App\Enums\DirectionEnum;
use App\Enums\GradientDirection;
use App\Enums\GradientStyle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

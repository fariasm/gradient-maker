<?php

namespace Tests\Feature;

use App\Enums\GradientStyle;
use Tests\TestCase;

class StyleTest extends TestCase
{
    public function test_valid_styles()
    {
        $this->json('get', 'api/v1/styles')
            ->assertStatus(200)
            ->assertJson(GradientStyle::asArray());
    }
}

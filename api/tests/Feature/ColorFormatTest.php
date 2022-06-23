<?php

namespace Tests\Feature;

use App\Enums\ColorFormat;
use Tests\TestCase;

class ColorFormatTest extends TestCase
{
    public function test_valid_color_formats()
    {
        $this->json('get', 'api/v1/color-formats')
            ->assertStatus(200)
            ->assertJson(ColorFormat::asArray());
    }
}

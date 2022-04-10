<?php

namespace Tests\Feature;

use App\Enums\ColorFormat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ColorFormatTest extends TestCase
{
    public function test_valid_color_formats()
    {
        $this->json('get', 'api/color-formats')
            ->assertStatus(200)
            ->assertJson(ColorFormat::asArray());
    }
}

<?php

namespace Tests\Feature;

use App\Enums\ColorFormat;
use App\Enums\GradientDirection;
use App\Enums\GradientStyle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TemplateTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_required_data()
    {
        $this->json('post', 'api/templates')
            ->assertStatus(400)
            ->assertJson([ "error" => [
                    "name" => [
                        "The name field is required."
                    ],
                    "style" => [
                        "The style field is required."
                    ],
                    "direction" => [
                        "The direction field is required."
                    ],
                    "color_from" => [
                        "The color from field is required."
                    ],
                    "color_to" => [
                        "The color to field is required."
                    ],
                    "color_format" => [
                        "The color format field is required."
                    ]
                ]
            ]);
    }

    public function test_too_short_name()
    {
        $data = $this->getValidHexData();
        $data['name'] = 'a';
        $this->json('post', 'api/templates', $data)
            ->assertStatus(400)
            ->assertJson([ "error" => [
                    "name" => [
                        "The name must be at least 6 characters."
                    ]
                ]
            ]);
    }

    public function test_too_long_name()
    {
        $data = $this->getValidHexData();
        $data['name'] = str_repeat('a', 51);
        $this->json('post', 'api/templates', $data)
            ->assertStatus(400)
            ->assertJson([ "error" => [
                    "name" => [
                        "The name must not be greater than 50 characters."
                    ]
                ]
            ]);
    }
    
    public function test_invalid_style()
    {
        $data = $this->getValidHexData();
        $data['style'] = 'invalid style';
        $this->json('post', 'api/templates', $data)
            ->assertStatus(400)
            ->assertJson([ "error" => [
                    "style" => [
                        "The selected style is invalid."
                    ]
                ]
            ]);
    }

    public function test_invalid_direction()
    {
        $data = $this->getValidHexData();
        $data['direction'] = 'invalid direction';
        $this->json('post', 'api/templates', $data)
            ->assertStatus(400)
            ->assertJson([ "error" => [
                    "direction" => [
                        "The selected direction is invalid."
                    ]
                ]
            ]);
    }

    public function test_invalid_color_format()
    {
        $data = $this->getValidHexData();
        $data['color_format'] = 'invalid color_format';
        $this->json('post', 'api/templates', $data)
            ->assertStatus(400)
            ->assertJson([ "error" => [
                    "color_format" => [
                        "The selected color format is invalid."
                    ]
                ]
            ]);
    }

    public function test_invalid_hex_color()
    {
        $data = $this->getValidHexData();
        $data['color_from'] = 'invalid color';
        $data['color_to'] = 'invalid color';
        $this->json('post', 'api/templates', $data)
            ->assertStatus(400)
            ->assertJson([ "error" => [
                    "color_from" => [
                        "The color from is invalid."
                    ],
                    "color_to" => [
                        "The color to is invalid."
                    ]
                ]
            ]);
    }

    public function test_invalid_rgb_color()
    {
        $data = $this->getValidRgbData();
        $data['color_from'] = 'invalid color';
        $data['color_to'] = 'invalid color';
        $this->json('post', 'api/templates', $data)
            ->assertStatus(400)
            ->assertJson([ "error" => [
                    "color_from" => [
                        "The color from is invalid."
                    ],
                    "color_to" => [
                        "The color to is invalid."
                    ]
                ]
            ]);
    }

    public function test_not_unique_name()
    {
        $data = $this->getValidRgbData();
        $data['name'] = 'template 1';
        $this->json('post', 'api/templates', $data);

        $this->json('post', 'api/templates', $data)
            ->assertStatus(400)
            ->assertJson([ "error" => [
                    "name" => [
                        "The name has already been taken."
                    ]
                ]
            ]);
    }

    public function test_valid_hex_template()
    {
        $data = $this->getValidHexData();
        $this->json('post', 'api/templates', $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'style',
                'direction',
                'color_from',
                'color_to'
            ]);
    }

    public function test_valid_rgb_template()
    {
        $data = $this->getValidRgbData();
        $this->json('post', 'api/templates', $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'style',
                'direction',
                'color_from',
                'color_to'
            ]);
    }

    public function test_get_all_templates()
    {
        $this->json('post', 'api/templates', $this->getValidHexData());
        $this->json('post', 'api/templates', $this->getValidHexData());
        $this->json('post', 'api/templates', $this->getValidRgbData());
        $this->json('post', 'api/templates', $this->getValidRgbData());
        $this->json('get', 'api/templates')
            ->assertStatus(200)
            ->assertJsonCount(4);
    }

    public function test_filter_templates_by_name()
    {
        $this->json('post', 'api/templates', $this->getValidHexData());
        $this->json('post', 'api/templates', $this->getValidHexData());
        $this->json('post', 'api/templates', $this->getValidRgbData());
        $this->json('post', 'api/templates', $this->getValidRgbData());
        $template1 = $this->getValidHexData();
        $template1['name'] = 'search this template1';
        $this->json('post', 'api/templates', $template1);
        $template2 = $this->getValidRgbData();
        $template2['name'] = 'search this template2';
        $this->json('post', 'api/templates', $template2);

        $this->json('get', 'api/templates?name=search')
            ->assertStatus(200)
            ->assertJsonCount(2);
    }

    private function getValidHexData()
    {
        return [
            'name' => 'Template '.rand(0, 99999999999999),
            'style' => GradientStyle::Linear(),
            'direction' => GradientDirection::Bottom(),
            'color_from' => '#118822',
            'color_to' => '#091929',
            'color_format' => ColorFormat::Hex()
        ];
    }

    private function getValidRgbData()
    {
        return [
            'name' => 'Template '.rand(0, 99999999999999),
            'style' => GradientStyle::Linear(),
            'direction' => GradientDirection::Bottom(),
            'color_from' => 'rgb(255, 153, 51)',
            'color_to' => 'rgb(51, 255, 51)',
            'color_format' => ColorFormat::Rgb()
        ];
    }
}

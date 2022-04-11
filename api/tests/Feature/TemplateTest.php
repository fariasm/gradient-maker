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

    private $templatesUrl = 'api/v1/templates';
    
    public function test_required_data()
    {
        $this->json('post', $this->templatesUrl)
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
        $this->json('post', $this->templatesUrl, $data)
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
        $this->json('post', $this->templatesUrl, $data)
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
        $this->json('post', $this->templatesUrl, $data)
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
        $this->json('post', $this->templatesUrl, $data)
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
        $this->json('post', $this->templatesUrl, $data)
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
        $this->json('post', $this->templatesUrl, $data)
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
        $this->json('post', $this->templatesUrl, $data)
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
        $this->json('post', $this->templatesUrl, $data);

        $this->json('post', $this->templatesUrl, $data)
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
        $this->json('post', $this->templatesUrl, $data)
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
        $this->json('post', $this->templatesUrl, $data)
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
        $this->json('post', $this->templatesUrl, $this->getValidHexData());
        $this->json('post', $this->templatesUrl, $this->getValidHexData());
        $this->json('post', $this->templatesUrl, $this->getValidRgbData());
        $this->json('post', $this->templatesUrl, $this->getValidRgbData());

        $response = $this->json('get', $this->templatesUrl);
        $response->assertStatus(200)
            ->assertJsonStructure($this->getPaginationStructure());
        $this->assertTrue(count($response['data']) == 4);
    }

    public function test_filter_templates_by_name()
    {
        $this->json('post', $this->templatesUrl, $this->getValidHexData());
        $this->json('post', $this->templatesUrl, $this->getValidHexData());
        $this->json('post', $this->templatesUrl, $this->getValidRgbData());
        $this->json('post', $this->templatesUrl, $this->getValidRgbData());

        $template1 = $this->getValidHexData();
        $template1['name'] = 'search this template1';
        $this->json('post', $this->templatesUrl, $template1);

        $template2 = $this->getValidRgbData();
        $template2['name'] = 'search this template2';
        $this->json('post', $this->templatesUrl, $template2);

        $response = $this->json('get', $this->templatesUrl.'?name=search');
        $response->assertStatus(200)
            ->assertJsonStructure($this->getPaginationStructure());
        $this->assertTrue(count($response['data']) == 2);
    }

    public function test_filter_templates_by_style()
    {
        $linearKey = GradientStyle::getKey(GradientStyle::Linear);
        $radialKey = GradientStyle::getKey(GradientStyle::Radial);

        $template1 = $this->getValidHexData();
        $template1['style'] = $linearKey;
        $this->json('post', $this->templatesUrl, $template1);

        $template2 = $this->getValidHexData();
        $template2['style'] = $linearKey;
        $this->json('post', $this->templatesUrl, $template2);

        $template3 = $this->getValidHexData();
        $template3['style'] = $radialKey;
        $this->json('post', $this->templatesUrl, $template3);
        
        $response = $this->json('get', $this->templatesUrl.'?style='.$linearKey);
        $response->assertStatus(200)
            ->assertJsonStructure($this->getPaginationStructure());
        $this->assertTrue(count($response['data']) == 2);
    }

    public function test_filter_templates_by_direction()
    {
        $topGradientKey = GradientDirection::getKey(GradientDirection::TopLeft);
        $bottomLeftGradientKey = GradientDirection::getKey(GradientDirection::Top);

        $template1 = $this->getValidHexData();
        $template1['direction'] = $topGradientKey;
        $this->json('post', $this->templatesUrl, $template1)->assertStatus(200);

        $template2 = $this->getValidHexData();
        $template2['direction'] = $topGradientKey;
        $this->json('post', $this->templatesUrl, $template2)->assertStatus(200);

        $template3 = $this->getValidHexData();
        $template3['direction'] = $bottomLeftGradientKey;
        $this->json('post', $this->templatesUrl, $template3)->assertStatus(200);
        
        $response = $this->json('get', $this->templatesUrl.'?direction='.$bottomLeftGradientKey);
        $response->assertStatus(200)
            ->assertJsonStructure($this->getPaginationStructure());
        $this->assertTrue(count($response['data']) == 1);
    }

    public function test_get_paginated_templates_with_page_size()
    {
        $this->json('post', $this->templatesUrl, $this->getValidHexData());
        $this->json('post', $this->templatesUrl, $this->getValidHexData());
        $this->json('post', $this->templatesUrl, $this->getValidRgbData());
        $this->json('post', $this->templatesUrl, $this->getValidRgbData());

        $response = $this->json('get', $this->templatesUrl.'?page=2&page_size=3');
        $response->assertStatus(200)
            ->assertJsonStructure($this->getPaginationStructure());
        $this->assertTrue(count($response['data']) == 1);
    }

    public function test_template_not_found()
    {
        $this->json('get', $this->templatesUrl.'/exists/templatename')
            ->assertStatus(404);
    }

    public function test_exists_template_name()
    {
        $template = $this->getValidHexData();
        $template['name'] = 'templatename';
        $this->json('post', $this->templatesUrl, $template);
        $this->json('get', $this->templatesUrl.'/exists/templatename')
            ->assertStatus(200);
    }

    private function getValidHexData()
    {
        return [
            'name' => 'Template '.rand(0, 99999999999999),
            'style' => GradientStyle::getKey(GradientStyle::Linear),
            'direction' => GradientDirection::getKey(GradientDirection::TopLeft),
            'color_from' => '#118822',
            'color_to' => '#091929',
            'color_format' => ColorFormat::getKey(ColorFormat::Hex)
        ];
    }

    private function getValidRgbData()
    {
        return [
            'name' => 'Template '.rand(0, 99999999999999),
            'style' => GradientStyle::getKey(GradientStyle::Linear),
            'direction' => GradientDirection::getKey(GradientDirection::TopLeft),
            'color_from' => 'rgb(255, 153, 51)',
            'color_to' => 'rgb(51, 255, 51)',
            'color_format' => ColorFormat::getKey(ColorFormat::Rgb)
        ];
    }

    private function getPaginationStructure()
    {
        return [
            'current_page',
            'data',
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total'
        ];
    }
}

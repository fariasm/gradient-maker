<?php

namespace App\Http\Controllers\Api;

use App\Enums\ColorFormat;
use App\Enums\GradientDirection;
use App\Enums\GradientStyle;
use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Rules\ColorFormatRule;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TemplateController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $templateQuery = Template::orderBy('name');
        if($request->has('name'))
        {
            $templateQuery = $templateQuery->where('name', 'like', '%'.$request->name.'%');
        }
        $templates = $templateQuery->get();
        return $this->successResponse($templates);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only('name', 'style', 'direction', 'color_from', 'color_to', 'color_format');
        $colorFormat = array_key_exists('color_format', $data)?$data['color_format']:null;
        $validator = Validator::make($data, [
            'name' => 'required|min:6|max:50|unique:templates',
            'style' => [
                'required',
                Rule::in(GradientStyle::getKeys())
            ],
            'direction' => [
                'required',
                Rule::in(GradientDirection::getKeys())
            ],
            'color_from' => [
                'required',
                new ColorFormatRule($colorFormat)
            ],
            'color_to' => [
                'required',
                new ColorFormatRule($colorFormat)
            ],
            'color_format' => [
                'required',
                Rule::in(ColorFormat::getKeys())
            ],
        ]);

        if($validator->fails())
        {
            return $this->errorResponse($validator->messages(), 400);
        }

        $template = Template::create([
            'name' => $request->name,
            'style' => $request->style,
            'direction' => $request->direction,
            'color_from' => $request->color_from,
            'color_to' => $request->color_to
        ]);

        return $this->successResponse($template->toArray());
    }
}

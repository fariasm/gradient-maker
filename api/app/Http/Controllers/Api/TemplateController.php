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

    private $pageSizeLimit = 200;
    private $defaultPageSize = 50;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/templates",
     *      operationId="getTemplates",
     *      tags={"Templates"},
     *      description="Returns list of templates",
     *      @OA\Parameter(
     *          name="name",
     *          in="path",
     *          description="Template name"
     *      ),
     *      @OA\Parameter(
     *          name="style",
     *          description="Template style",
     *          in="path",
     *          @OA\Schema(
     *              type="GradientStyle"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="direction",
     *          description="Template direction",
     *          in="path",
     *          @OA\Schema(
     *              type="GradientDirection"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          description="Pagination page number",
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="page_size",
     *          description="Pagination page size",
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="current_page", type="integer"),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="integer"),
     *                      @OA\Property(property="name", type="string"),
     *                      @OA\Property(property="style", type="GradientStyle"),
     *                      @OA\Property(property="direction", type="GradientDirection"),
     *                      @OA\Property(property="color_from", type="string"),
     *                      @OA\Property(property="color_to", type="string")
     *                  ),
     *              ),
     *              @OA\Property(property="first_page_url", type="string"),
     *              @OA\Property(property="from", type="integer"),
     *              @OA\Property(property="last_page", type="integer"),
     *              @OA\Property(property="last_page_url", type="string"),
     *              @OA\Property(property="links", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="url", type="string"),
     *                      @OA\Property(property="label", type="string"),
     *                      @OA\Property(property="active", type="bool")
     *                  ),
     *              ),
     *              @OA\Property(property="next_page_url", type="string"),
     *              @OA\Property(property="path", type="string"),
     *              @OA\Property(property="per_page", type="integer"),
     *              @OA\Property(property="prev_page_url", type="string"),
     *              @OA\Property(property="to", type="integer"),
     *              @OA\Property(property="total", type="integer"),
     *          )
     *       )
     *     )
     */
    public function index(Request $request)
    {
        $templateQuery = Template::orderBy('name');
        if($request->has('name'))
        {
            $templateQuery = $templateQuery->where('name', 'like', '%'.$request->name.'%');
        }
        if($request->has('style'))
        {
            $templateQuery = $templateQuery->where('style', $request->style);
        }
        if($request->has('direction'))
        {
            $templateQuery = $templateQuery->where('direction', $request->direction);
        }
        $templates = $templateQuery->paginate($this->getPageSize($request));
        return $this->successResponse($templates);
    }

    private function getPageSize($request)
    {
        $pageSize = $this->defaultPageSize;
        if($request->has('page_size'))
        {
            $pageSize = $request->page_size<$this->pageSizeLimit?$request->page_size:$this->pageSizeLimit;
        }
        return $pageSize;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *      path="/templates",
     *      operationId="createTemplates",
     *      tags={"Templates"},
     *      description="Creates new template",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass user credentials",
     *          @OA\JsonContent(
     *              required={"name","style","direction","color_from","color_to","color_format"},
     *              @OA\Property(property="name", type="string", example="Template 1"),
     *              @OA\Property(property="style", type="GradientStyle", example="Linear"),
     *              @OA\Property(property="direction", type="GradientDirection", example="Top"),
     *              @OA\Property(property="color_from", type="string"),
     *              @OA\Property(property="color_to", type="string"),
     *              @OA\Property(property="color_format", type="ColorFormat", example="Rgb")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data."
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="style", type="GradientStyle"),
     *              @OA\Property(property="direction", type="GradientDirection"),
     *              @OA\Property(property="color_from", type="string"),
     *              @OA\Property(property="color_to", type="string"),
     *          )
     *       )
     *     )
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

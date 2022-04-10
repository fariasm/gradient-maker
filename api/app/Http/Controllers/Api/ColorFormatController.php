<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Enums\ColorFormat;
use App\Traits\ApiResponser;

class ColorFormatController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/color-formats",
     *      operationId="getColors",
     *      tags={"Color formats"},
     *      description="Returns list of projects",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function index()
    {
        return $this->successResponse(ColorFormat::asArray());
    }
}

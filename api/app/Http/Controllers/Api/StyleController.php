<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Enums\GradientStyle;
use App\Traits\ApiResponser;

class StyleController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/styles",
     *      operationId="getGradientStyles",
     *      tags={"Gradient styles"},
     *      description="Returns list of gradient styles",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function index()
    {
        return $this->successResponse(GradientStyle::asArray());
    }
}

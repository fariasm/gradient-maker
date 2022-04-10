<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Enums\GradientDirection;
use App\Traits\ApiResponser;

class DirectionController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/directions",
     *      operationId="getGradientDirections",
     *      tags={"Gradient directions"},
     *      description="Returns list of gradient directions",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function index()
    {
        return $this->successResponse(GradientDirection::asArray());
    }
}

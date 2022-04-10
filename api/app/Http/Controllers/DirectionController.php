<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        return $this->successResponse(GradientDirection::asArray());
    }
}

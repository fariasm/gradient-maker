<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        return $this->successResponse(GradientStyle::asArray());
    }
}

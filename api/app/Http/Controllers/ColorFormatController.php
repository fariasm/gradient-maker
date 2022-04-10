<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        return $this->successResponse(ColorFormat::asArray());
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\DirectionEnum;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

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
        //
        return $this->successResponse(DirectionEnum::values());
    }
}

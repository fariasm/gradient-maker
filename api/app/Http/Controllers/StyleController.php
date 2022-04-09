<?php

namespace App\Http\Controllers;

use App\Enums\StyleEnum;
use App\Models\Style;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

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
        //
        return $this->successResponse(StyleEnum::values());
    }
}

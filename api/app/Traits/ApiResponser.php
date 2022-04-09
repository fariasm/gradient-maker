<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponser
{
    public function successResponse($data = [], $code = Response::HTTP_OK)
    {
        if(!is_array($data)) {
            $data = array('message' => $data);
        }
        return response($data, $code)->header('Content-Type', 'application/json');
    }

    public function errorResponse($error, $code)
    {
        return response()->json(['error' => $error, 'code' => $code], $code);
    }

    public function errorMessage($message, $code)
    {
        return response($message, $code)->header('Content-Type', 'application/json');
    }
}
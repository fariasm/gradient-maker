<?php

use App\Http\Controllers\Api\ColorFormatController;
use App\Http\Controllers\Api\DirectionController;
use App\Http\Controllers\Api\StyleController;
use App\Http\Controllers\Api\TemplateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('styles', [StyleController::class, 'index']);
Route::get('directions', [DirectionController::class, 'index']);
Route::get('color-formats', [ColorFormatController::class, 'index']);
Route::post('templates', [TemplateController::class, 'store']);
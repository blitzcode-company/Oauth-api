<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
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

Route::prefix('v1')->group(function ()
{
    Route::post('/user',[UserController::class,"register"]);
    Route::get('/validate',[UserController::class,"validarToken"])->middleware('auth:api');
    Route::get('/logout',[UserController::class,"logout"])->middleware('auth:api');


});
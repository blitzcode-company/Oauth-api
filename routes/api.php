<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('v1')->group(function ()
{
    Route::post('/user',[UserController::class,"register"]);
    Route::get('/validate',[UserController::class,"validarToken"])->middleware('auth:api');
    Route::get('/logout',[UserController::class,"logout"])->middleware('auth:api');


    
});
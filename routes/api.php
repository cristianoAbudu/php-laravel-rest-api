<?php

use App\Http\Controllers\API\ColaboradorAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PostAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::resource('posts', 'API\PostAPIController');
Route::resource('posts',  PostAPIController::class);
Route::resource('colaborador',  ColaboradorAPIController::class);
Route::post('colaborador/associaChefe', 'App\Http\Controllers\API\ColaboradorAPIController@associaChefe');



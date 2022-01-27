<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JwTCntroller;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware'=>'api'],function($router){
    Route::post('/register',[JwTCntroller::class,'register']);
    Route::post('/login',[JwTCntroller::class,'login']);
    Route::post('/logout',[JwTCntroller::class,'logout']);
    Route::post('/refresh',[JwTCntroller::class,'refresh']);
    Route::post('/profile/{id}',[JwTCntroller::class,'profile']);
});
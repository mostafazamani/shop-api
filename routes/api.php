<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group(['prefix' => 'v1'], function (){
    Route::post('/register', [\App\Http\Controllers\Api\v1\AuthController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\Api\v1\AuthController::class, 'login']);
    Route::middleware('auth:api')->get('/logout', [\App\Http\Controllers\Api\v1\AuthController::class, 'logout']);
    Route::middleware('auth:api')->get('/tokenexp', [\App\Http\Controllers\Api\v1\AuthController::class, 'gettokenexpires']);
    Route::middleware('auth:api')->get('/userid', [\App\Http\Controllers\Api\v1\AuthController::class, 'getuserid']);
    Route::middleware('auth:api')->get('/getuser', [\App\Http\Controllers\Api\v1\AuthController::class, 'getuser']);
    Route::middleware('auth:api')->post('/updateuser', [\App\Http\Controllers\Api\v1\AuthController::class, 'updateuser']);

    Route::post('/resetcode', [\App\Http\Controllers\Api\v1\ResetCodeController::class, 'sendResetCode']);
    Route::post('/checkcode', [\App\Http\Controllers\Api\v1\ResetCodeController::class, 'checkResetCode']);
    Route::post('/resetpass', [\App\Http\Controllers\Api\v1\ResetCodeController::class, 'resetPassword']);

    Route::middleware('auth:api')->get('/pcategory/{param}', [\App\Http\Controllers\Api\v1\ProductController::class, 'productwitcategor']);
    Route::middleware('auth:api')->get('/pid/{param}', [\App\Http\Controllers\Api\v1\ProductController::class, 'productwitid']);
    Route::middleware('auth:api')->get('/getallproduct', [\App\Http\Controllers\Api\v1\ProductController::class, 'getallproduct']);

    Route::middleware('auth:api')->get('/getallcategory', [\App\Http\Controllers\Api\v1\CategoryController::class, 'getallcategory']);
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StateController;
use App\Services\Api;
use Illuminate\Support\Facades\Http;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::resource('products', ProductController::class);
    Route::put('products/{id}/increments', [ ProductController::class, 'increments' ]);
    
    Route::get('states', [ StateController::class, 'index']);

    Route::prefix('test')->group(function () {
        Route::get('success', function () {
            return Api::getRequest();
        });

        Route::get('states', function () {
            return Api::getStates();
        });
    
        Route::get('error', function () {
            return Api::getErrorRequest();
        });
    });
});



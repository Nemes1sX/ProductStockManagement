<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('product')->name('product.api.')->group(function () {
    Route::get( '/index', [\App\Http\Controllers\Api\ProductsApiController::class, 'index'])
        ->name('index');
    Route::get('/import/{id}', [\App\Http\Controllers\Api\ProductsApiController::class, 'updateStock'])
        ->name('update.stock');
});

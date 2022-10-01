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
Route::get( '/product/index', [\App\Http\Controllers\Api\ProductsApiController::class, 'index'])
    ->name('product.api.index');
Route::get('/product/import', [\App\Http\Controllers\Api\ProductsApiController::class, 'import'])
    ->name('product.api.import');

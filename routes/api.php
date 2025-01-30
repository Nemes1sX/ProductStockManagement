<?php

use App\Http\Controllers\Api\ProductsApiController;
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

Route::prefix('product')->controller(ProductsApiController::class)->name('product.api.')->group(function () {
    Route::get('/index', 'index')->name('index');
    Route::get('/update-stock/{id}', 'updateStock')->name('update.stock');
});

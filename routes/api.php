<?php

use App\Http\Controllers\v1\ActivityHistoryController;
use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\ProductController;
use App\Http\Controllers\v1\ProductVariantController;
use App\Http\Controllers\v1\StoreController;
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

Route::get('ping', function () {
    return api_success('okok');
});

Route::get('/', function () {
    return api_success('welcome to om healing app');
});

Route::prefix('v1')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
    });
    Route::middleware('auth:api')->group(function () {
        Route::apiResource('stores', StoreController::class, [
            'names' => [
                'index' => 'stores.index',
                'store' => 'stores.store',
                'show' => 'stores.show',
                'update' => 'stores.update',
                'destroy' => 'stores.destroy',
            ]
        ]);
        Route::apiResource('products', ProductController::class);
        Route::apiResource('product_variants', ProductVariantController::class);
        Route::get('activities', [ActivityHistoryController::class, 'index']);
    });
});

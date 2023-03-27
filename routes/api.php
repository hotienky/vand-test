<?php

use App\Http\Controllers\v1\ActivityHistoryController;
use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\ProductController;
use App\Http\Controllers\v1\ProductVariantController;
use App\Http\Controllers\v1\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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

Route::prefix('/public/employee_otp/')->group(function ($route) {
    Route::post('resend', function (Request $request) {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required'
        ], [
            'required' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "code" => 400,
                "name" => "Bad Request",
                "description" => "<p>Cannot find user from phone number.</p>"
            ]);
        }
        return response()->json([
            "code" => 200,
            "status" =>  true,
            "data" => $request->all()
        ]);
    });
    Route::post('auth', function (Request $request) {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
            'otp_code' => 'required|digits:6'
        ], [
            'required' => 'The :attribute field is required.',
            'digits' => ':attribute must have 6 digits'
        ]);
        if ($validator->fails() || $request->get('otp') !== '111111') {
            return response()->json([
                "code" => 400,
                "name" => "Bad Request",
                "description" => "Error"
            ]);
        }
        return response()->json([
            "code" => 200,
            "status" =>  true,
            "data" => $validator
        ]);
    });
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

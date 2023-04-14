<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
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

Route::prefix('auth')->group(function () {
   Route::post('/', [AuthController::class, 'login']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard']);
    });
   Route::prefix('menus')->group(function () {
       Route::get('/', [MenuController::class, 'getMenu']);
   });
   Route::prefix('orders')->group(function () {
       Route::get('/not-process', [OrderController::class, 'getOrderNotProcess']);
       Route::post('/', [OrderController::class, 'createOrder']);
       Route::put('/{code}', [OrderController::class, 'setStatusDone']);
       Route::get('/', [OrderController::class, 'getOrders']);
       Route::get('/total-today', [OrderController::class, 'getTotalOrder']);
   });
   Route::prefix('categories')->group(function () {
       Route::get('/', [CategoryController::class, 'findAll']);
   });
});

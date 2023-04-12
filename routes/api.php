<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CategoryController;
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
   Route::prefix('menus')->group(function () {
       Route::get('/', [MenuController::class, 'getMenu']);
   });
   Route::prefix('orders')->group(function () {
       Route::get('/', [OrderController::class, 'getOrder']);
       Route::post('/', [OrderController::class, 'createOrder']);
   });
   Route::prefix('categories')->group(function () {
       Route::get('/', [CategoryController::class, 'findAll']);
   });
});

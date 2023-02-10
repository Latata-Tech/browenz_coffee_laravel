<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\CategoryController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->name('index');
Route::prefix('auth')->group(function(){
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
Route::prefix('employees')->group(function () {
   Route::get('/', [EmployeeController::class, 'index'])->name('employees');
   Route::get('/create', [EmployeeController::class, 'create'])->name('createEmployee');
   Route::get('/create-account/{employee}', [EmployeeController::class, 'createAccount'])->name('createAccount');
   Route::get('/update-account/{employee}', [EmployeeController::class, 'updateAccount'])->name('updateAccount');
   Route::post('/create-account/{employee}', [EmployeeController::class, 'storeAccount'])->name('storeAccount');
   Route::put('/update-account/{employee}', [EmployeeController::class, 'storeUpdateAccount'])->name('storeUpdateAccount');
   Route::get('/update/{employee}', [EmployeeController::class, 'edit'])->name('editEmployee');
   Route::get('/detail/{employee}', [EmployeeController::class, 'detail'])->name('detailEmployee');
   Route::post('/', [EmployeeController::class, 'store'])->name('storeEmployee');
   Route::put('/update/{employee}', [EmployeeController::class, 'update'])->name('updateEmployee');
   Route::delete('/delete/{employee}', [EmployeeController::class, 'delete'])->name('deleteEmployee');
});
Route::prefix('ingredients')->group(function () {
    Route::get('/', [IngredientController::class, 'index'])->name('ingredients');
    Route::get('/create', [IngredientController::class, 'create'])->name('createIngredient');
    Route::get('/update/{ingredient}', [IngredientController::class, 'edit'])->name('editIngredient');
    Route::get('/detail/{ingredient}', [IngredientController::class, 'detail'])->name('detailIngredient');
    Route::post('/', [IngredientController::class, 'store'])->name('storeIngredient');
    Route::put('/update/{ingredient}', [IngredientController::class, 'update'])->name('updateIngredient');
    Route::delete('/delete/{ingredient}', [IngredientController::class, 'delete'])->name('deleteIngredient');
});
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'findAll'])->name('categories');
    Route::get('/create', [CategoryController::class, 'create'])->name('createCategory');
    Route::get('/update/{category}', [CategoryController::class, 'edit'])->name('editCategory');
    Route::get('/detail/{id}', [CategoryController::class, 'findById'])->name('detailCategory');
    Route::post('/', [CategoryController::class, 'save'])->name('storeCategory');
    Route::put('/update/{category}', [CategoryController::class, 'update'])->name('updateCategory');
    Route::delete('/delete/{category}', [CategoryController::class, 'delete'])->name('deleteCategory');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

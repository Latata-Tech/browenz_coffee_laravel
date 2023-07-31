<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SellingController;
use App\Http\Controllers\ReportController;
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
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
    Route::post('/forgot-password', [AuthController::class, 'storeForgotPassword'])->name('storeForgotPassword');
    Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');
    Route::put('/reset-password', [AuthController::class, 'storeResetPassword'])->name('storeResetPassword');
    Route::get('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');
    Route::put('/change-password', [AuthController::class, 'storeChangePassword'])->name('storeChangePassword');
});
Route::middleware('auth')->group(function () {
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
        Route::get('detail-json/{id}', [IngredientController::class, 'detailIngredientJson']);
        Route::get('/ingredient-except', [IngredientController::class, 'getIngredients']);
    });
    Route::prefix('menus')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('menus');
        Route::get('/create', [MenuController::class, 'create'])->name('createMenu');
        Route::get('/update/{menu}', [MenuController::class, 'edit'])->name('editMenu');
        Route::get('/detail/{menu}', [MenuController::class, 'detail'])->name('detailMenu');
        Route::post('/create', [MenuController::class, 'store'])->name('storeMenu');
        Route::put('/update/{menu}', [MenuController::class, 'update'])->name('updateMenu');
        Route::delete('/delete/{menu}', [MenuController::class, 'delete'])->name('deleteMenu');
        Route::get('/get-menu/{menu}', [MenuController::class, 'getMenuById'])->name('getMenuById');
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
    Route::prefix('promos')->group(function () {
        Route::get('/', [PromoController::class, 'index'])->name('promos');
        Route::get('/create', [PromoController::class, 'create'])->name('createPromo');
        Route::get('/update/{promo}', [PromoController::class, 'edit'])->name('editPromo');
        Route::get('/detail/{promo}', [PromoController::class, 'detail'])->name('detailPromo');
        Route::post('/', [PromoController::class, 'store'])->name('storePromo');
        Route::put('/update/{promo}', [PromoController::class, 'update'])->name('updatePromo');
        Route::delete('/delete/{promo}', [PromoController::class, 'delete'])->name('deletePromo');
    });
    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('transactions');
        Route::get('/create', [TransactionController::class, 'create'])->name('createTransaction');
        Route::get('/update/{id}', [TransactionController::class, 'edit'])->name('editTransaction');
        Route::get('/detail/{transaction}', [TransactionController::class, 'detail'])->name('detailTransaction');
        Route::post('/', [TransactionController::class, 'store'])->name('storeTransaction');
        Route::put('/update/{transaction}', [TransactionController::class, 'update'])->name('updateTransaction');
        Route::delete('/delete/{transaction}', [TransactionController::class, 'delete'])->name('deleteTransaction');
    });
    Route::prefix('sellings')->group(function () {
        Route::get('/', [SellingController::class, 'index'])->name('sellings');
        Route::get('/detail/{id}', [SellingController::class, 'detail'])->name('detailSelling');
    });
    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports');
        Route::get('/income', [ReportController::class, 'staffIncome'])->name('staffIncome');
        Route::get('/selling-report', [ReportController::class, 'export'])->name('sellingExport');
        Route::get('/ingredient-report', [ReportController::class, 'ingredientExport'])->name('ingredientExport');
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


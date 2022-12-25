<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
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

Route::get('/', [AuthController::class, 'index']);
Route::prefix('auth')->group(function(){
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
Route::prefix('employees')->group(function () {
   Route::get('/', [EmployeeController::class, 'index'])->name('employees');
   Route::get('/create', [EmployeeController::class, 'create'])->name('createEmployee');
   Route::get('/update/{employee}', [EmployeeController::class, 'edit'])->name('editEmployee');
   Route::post('/', [EmployeeController::class, 'store'])->name('storeEmployee');
   Route::put('/update/{employee}', [EmployeeController::class, 'update'])->name('updateEmployee');
   Route::delete('/delete/{employee}', [EmployeeController::class, 'delete'])->name('deleteEmployee');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
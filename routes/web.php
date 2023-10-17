<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TechnicianExpenditureController;
use App\Models\TechnicianExpenditure;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('items', ItemController::class);
Route::resource('customers', CustomerController::class);
Route::resource('transactions', TransactionController::class);
Route::resource('settings', SettingController::class);
Route::resource('technician_expenditures', TechnicianExpenditureController::class);
Route::resource('employee_expenditures', EmployeeExpenditureController::class);
Route::resource('operational_expenditures', OperationalExpenditureController::class);
Route::resource('material_expenditures', MaterialExpenditureController::class);

// API
Route::prefix('/api/v1')->group(function() {
    Route::get('items', [ItemController::class, 'getItems'])->name('api.getItems');
    Route::get('item/{item}', [ItemController::class, 'getItem'])->name('api.getItem');
});
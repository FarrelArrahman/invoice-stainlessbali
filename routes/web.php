<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransactionController;
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
Route::resource('transactions', TransactionController::class);

// API
Route::prefix('/api/v1')->group(function() {
    Route::get('items', [ItemController::class, 'getItems'])->name('api.getItems');
    Route::get('item/{item}', [ItemController::class, 'getItem'])->name('api.getItem');
});
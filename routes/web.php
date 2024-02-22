<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeExpenditureController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MaterialExpenditureController;
use App\Http\Controllers\OperationalExpenditureController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\TechnicianExpenditureController;
use App\Http\Controllers\UserController;
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

// Testing
Route::get('test', function() {
    $data = App\Models\Technician::where('status', \App\Enums\StatusEnum::Active)->get()->toArray();
    return fake()->randomElement($data);
})->name('test');

// DataTables
Route::prefix('/datatables')->group(function() {
    Route::get('expenditures', [ExpenditureController::class, 'getExpenditures'])->name('datatables.expenditures');
    Route::get('incomes', [IncomeController::class, 'getIncomes'])->name('datatables.incomes');
    Route::get('transactions', [TransactionController::class, 'getTransactions'])->name('datatables.transactions');
});

// API
Route::prefix('/api/v1')->group(function() {
    Route::get('items', [ItemController::class, 'getItems'])->name('api.getItems');
    Route::get('item/{item}', [ItemController::class, 'getItem'])->name('api.getItem');

    Route::get('companies', [CompanyController::class, 'getCompanies'])->name('api.getCompanies');
    Route::get('company/{company}', [CompanyController::class, 'getCompany'])->name('api.getCompany');
    Route::get('company/{company}/customers', [CompanyController::class, 'getCompanyCustomers'])->name('api.getCompanyCustomers');
    
    Route::get('customers', [CustomerController::class, 'getCustomers'])->name('api.getCustomers');
    Route::get('customer/{customer}', [CustomerController::class, 'getCustomer'])->name('api.getCustomer');
});

Route::prefix('/statistics')->group(function() {
    Route::get('expenditure', [ExpenditureController::class, 'getExpenditureReport'])->name('statistic.expenditure');
    Route::get('expenditure_comparison', [ExpenditureController::class, 'getExpenditureComparisonReport'])->name('statistic.expenditure_comparison');
    Route::get('income', [IncomeController::class, 'getIncomeReport'])->name('statistic.income');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::resource('items', ItemController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('transactions', TransactionController::class);
    Route::get('transactions/{transaction}/pdf', [TransactionController::class, 'pdf'])->name('transactions.pdf');

    Route::resource('settings', SettingController::class);
    Route::resource('technician_expenditures', TechnicianExpenditureController::class);
    Route::resource('employee_expenditures', EmployeeExpenditureController::class);
    Route::resource('operational_expenditures', OperationalExpenditureController::class);
    Route::resource('material_expenditures', MaterialExpenditureController::class);
    Route::resource('expenditures', ExpenditureController::class);
    Route::resource('incomes', IncomeController::class);

    // Master Data
    Route::resource('companies', CompanyController::class);
    Route::resource('technicians', TechnicianController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('users', UserController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudentFinanceController;

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

Route::get('/index', function () {
    return view('admin.dashboard');
});

Auth::routes();
//category route
Route::middleware('auth')->group(function () {
    Route::resource('category', 'App\Http\Controllers\CategoryController');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
    Route::delete('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/categories/{category}/edit', [App\Http\Controllers\CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'update'])->name('categories.update');

    //EXPENSES
    Route::get('{userId}/expenses', [App\Http\Controllers\ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/create', [App\Http\Controllers\ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses', [App\Http\Controllers\ExpenseController::class, 'store'])->name('expenses.store');
    Route::put('/expenses/{expense}', [App\Http\Controllers\ExpenseController::class, 'update'])->name('expenses.update');

    //EXPENSE CATEGORIES
    Route::get('/expense-categories/create', [App\Http\Controllers\ExpenseCategoryController::class, 'create'])->name('expense-categories.create');
    Route::post('/expense-categories', [App\Http\Controllers\ExpenseCategoryController::class, 'store'])->name('expense-categories.store');
    Route::delete('/expenses/{id}', [App\Http\Controllers\ExpenseController::class, 'destroy'])->name('expenses.destroy');
    Route::resource('expenses', App\Http\Controllers\ExpenseController::class);

    //DEBTS
    Route::get('/debts', [App\Http\Controllers\DebtController::class, 'index'])->name('debts.index');
    Route::post('/debts', [App\Http\Controllers\DebtController::class, 'store'])->name('debts.store');
    Route::delete('/debts/{debt}', [App\Http\Controllers\DebtController::class, 'destroy'])->name('debts.destroy');
    Route::post('/debts/pay', [App\Http\Controllers\DebtController::class, 'payDebt'])->name('debts.pay');
    Route::post('/payments/store', [App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store');

    //Debits
    Route::get('{userId}/debits', [App\Http\Controllers\DebitController::class, 'index'])->name('debits.index');
    Route::resource('debits', App\Http\Controllers\DebitController::class);

    Route::get('/monthly-expenses', [App\Http\Controllers\LineChartController::class, 'monthlyExpenses'])->name('monthly-expenses');
    Route::get('/monthly-expenses-by-category', [App\Http\Controllers\LineChartController::class, 'monthlyExpensesByCategory'])->name('monthly-expenses-by-category');
    Route::get('/weekly-expenses-by-category', [App\Http\Controllers\LineChartController::class, 'weeklyExpensesByCategory'])->name('weekly-expenses-by-category');
    Route::get('/upcoming-direct-debits', [App\Http\Controllers\LineChartController::class, 'upcomingDirectDebits'])->name('upcoming-direct-debits');
    Route::get('/debts-within-month', [App\Http\Controllers\LineChartController::class, 'debtsWithinMonth'])->name('debts-within-month');

    Route::get('/monthly-expenses-total', [App\Http\Controllers\LineChartController::class, 'monthlyExpensesTotal'])->name('monthly-expenses-total');
    Route::get('/monthly-expenses-summary', [App\Http\Controllers\LineChartController::class, 'monthlyExpensesSummary'])->name('monthly-expenses-summary');
    Route::get('/last-month-expenses', [App\Http\Controllers\LineChartController::class, 'lastMonthExpenses'])->name('last-month-expenses');

    // Student Finance
    Route::resource('finances', App\Http\Controllers\FinanceController::class);
    Route::get('/get-finances', [App\Http\Controllers\CategoryController::class, 'getFinances'])->name('get-finances');

    // profiles
    Route::get('/profile/{userId}', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update-picture', [App\Http\Controllers\ProfileController::class, 'updatePicture'])->name('profile.update-picture');
    Route::delete('/profile/delete-picture', [App\Http\Controllers\ProfileController::class, 'deletePicture'])->name('profile.delete-picture');
    Route::put('/profile/update-details', [App\Http\Controllers\ProfileController::class, 'updateDetails'])->name('profile.update-details');
    Route::get('/expense-categories-for-doughnut-chart', [App\Http\Controllers\LineChartController::class, 'expenseCategoriesForDoughnutChart'])->name('expense-categories-for-doughnut-chart');
});



<?php

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


// Requires Authentication
Route::group(['middleware' => 'auth'], function() {

    # DISPLAY Dashboard Page
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    # CREATE New Transaction
    Route::post('/transaction', 'ActivityController@storeTransaction');

    # DISPLAY Budget Table
    Route::get('/budget', 'BudgetController@index');

    # DISPLAY New User Budget Table
    Route::get('/budget/setup', 'BudgetController@newBudgetSetup');
    Route::post('/budget/setup/new', 'BudgetController@budgetSetup')->name('setup');

    # UPDATE Planned Budget Value
    Route::post('/budget/planned/update', 'BudgetController@updatePlanned');

    # CREATE New Budget Category
    Route::post('/budget/category/new', 'BudgetController@createCategory');

    # UPDATE Transaction Category
    Route::post('/transaction/category/update', 'ActivityController@updateCategory');

    # DELETE Transaction
    Route::get('/transaction/{id}/delete', 'ActivityController@deleteTransaction');
    Route::delete('/transaction/{id}/destroy', 'ActivityController@destroyTransaction');

    # CREATE New Income
    Route::get('/income/new', 'IncomeController@newIncome');
    Route::post('/income', 'IncomeController@storeIncome');

    # GET Account Settings
    Route::get('/account', 'UserController@displayAccount');
});

// Authentication Routes
Auth::routes();

Route::view('/', 'landing')->name('landing');

// Redirect Any Traffic Away From Splash To Login Page
// Route::redirect('/', '/login');

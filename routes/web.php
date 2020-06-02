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
    Route::get('/budget', 'BudgetController@index')->name('budget');

    # DISPLAY New User Budget Table
    Route::get('/budget/setup', 'BudgetController@newBudgetSetup');
    Route::post('/budget/setup/new', 'BudgetController@budgetSetup')->name('setup');

    # UPDATE Planned Budget Value
    Route::post('/budget/planned/update', 'BudgetController@updatePlanned');

    # CREATE New Budget Category
    Route::post('/budget/category/new', 'BudgetController@createCategory')->name('category');

    # UPDATE Budget Icon
    Route::post('/budget/icon/update', 'BudgetController@updateIcon');

    # UPDATE Transaction Category
    Route::post('/transaction/category/update', 'ActivityController@updateCategory');

    # DELETE Transaction
    Route::get('/transaction/{id}/delete', 'ActivityController@deleteTransaction');
    Route::delete('/transaction/{id}/destroy', 'ActivityController@destroyTransaction');

    # GET User's Transactions
    Route::get('/transactions', 'ActivityController@getTransactions');

    # CREATE New Income
    Route::get('/income/new', 'IncomeController@newIncome');
    Route::post('/income', 'IncomeController@storeIncome');

    # GET Account Settings
    Route::get('/account', 'UserController@displayAccount');

    # GET Database Snapshot
    Route::get('/snapshot', 'AdminController@backupTables');

    # GET Read Database Snapshot
    Route::get('/readSnapshot', 'AdminController@readBackupTables');
});

// Authentication Routes
Auth::routes();

// Landing Page
Route::view('/', 'landing')->name('landing');

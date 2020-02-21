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
    Route::get('/dashboard', 'DashboardController@index');

    # CREATE New Transaction
    Route::post('/transaction/new', 'ActivityController@saveTransaction');

    Route::get('/budget', 'BudgetController@index');

    Route::post('/budget/planned/update', 'BudgetController@updatePlanned');

    # CREATE New Budget Category
    Route::post('/budget/category/new', 'BudgetController@createCategory');

    # UPDATE Transaction Category
    Route::post('/transaction/category/update', 'ActivityController@updateCategory');

    # CREATE New Income
    Route::get('/income/new', 'IncomeController@newIncome');
    Route::post('/income', 'IncomeController@storeIncome');

    # GET Account Settings
    Route::get('/account', 'UserController@displayAccount');
});

// Authentication Routes
Auth::routes();

// Redirect Any Traffic Away From Splash To Login Page
Route::redirect('/', '/login');
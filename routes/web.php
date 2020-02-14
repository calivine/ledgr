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

// Main Splash Page
Route::get('/', function () {
    return view('landing');
});

// Requires Authentication
Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard', 'DashboardController@index');

    Route::post('/transaction/new', 'DashboardController@saveTransaction');

    Route::get('/budget', 'BudgetController@index');

    Route::post('/budget/planned/update', 'BudgetController@updatePlanned');

    Route::post('/budget/category/new', 'BudgetController@createCategory');

    Route::post('/category/update', 'ActivityController@updateCategory');
});

// Authentication Routes
Auth::routes();

// Redirect Any Traffic Away From /register To Splash Page
Route::redirect('/register', '/');
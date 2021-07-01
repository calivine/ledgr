<?php
use Illuminate\Http\Request;
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

    # CREATE Mass Transactions
    Route::post('/transaction/save/all', 'ActivityController@storeTransactions')->name('saveAllTransactions');

    # UPDATE Transaction Category
    Route::post('/transaction/category/update', 'ActivityController@updateCategory');

    # DELETE Transaction
    Route::get('/transaction/{id}/delete', 'ActivityController@deleteTransaction');
    Route::delete('/transaction/{id}/destroy', 'ActivityController@destroyTransaction');

    # GET User's Transactions
    Route::get('/transactions', 'ActivityController@getTransactions')->name('transactions');

    # CREATE New Income
    Route::get('/income/new', 'IncomeController@newIncome');
    Route::post('/income', 'IncomeController@storeIncome');

    # GET Account Settings
    Route::get('/account', 'UserController@displayAccount')->name('account');
    Route::get('/api/refresh', 'ApiController@refresh')->name('account.refresh');

    # UPDATE Site theme
    Route::put('/account/theme/update', 'UserController@updateTheme')->name('changeTheme');

    # POST Upload CSV File
    Route::post('/upload/csv', 'FileController@uploadCSV')->name('uploadCSV');
});

// Authentication Routes
Auth::routes();

Route::post('/get_user_tz', function(Request $request) {
    $tz = $request->input('timezone');
    $tz_name = timezone_name_from_abbr("", $tz*60, false);
    date_default_timezone_set($tz_name);
    Illuminate\Support\Facades\Log::info($tz_name);
});

Route::permanentRedirect('/register', '/');

// Landing Page
Route::view('/', 'landing')->name('landing');

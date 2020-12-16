<?php

use Illuminate\Http\Request;

use App\Activity;
use App\Http\Resources\ActivityCollection;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

# POST Authenticate a user
Route::post('/authenticate', 'ApiAuthController@authenticate');

Route::group(['middleware' => 'auth:api'], function() {

    # GET User.
    Route::get('/user', 'ApiController@user');

    # Activities Route Group
    Route::prefix('activity')->group(function () {
        # GET All Transactions for the Period.
        Route::get('transactions/{start}/{stop}', 'ApiController@getTransactionsByDate');

        # GET Get Total Spent for Period.
        Route::get('transactions/{start}/{stop}/total', 'ApiController@total');

        # GET
        Route::get('transactions', 'ApiController@getAllTransactions');

        # POST Save new transaction item.
        Route::post('transactions', 'ApiController@store');

        # DELETE Transaction
        Route::delete('transactions', 'ApiController@destroyTransaction');
    });

    # Budget Route Group
    Route::prefix('budget')->group(function () {
        # GET Category budget items.
        Route::get('categories/{name?}', 'ApiController@getBudgetCategories');

        # POST Create New Category
        Route::post('categories', 'ApiController@storeCategory');

    });
});

/**
 * Authenticated API routes require: ledgr.site/api/params?api_token=TOKEN
 * Get user by API key: http://ledgr.loc/api/user?api_token=TOKEN
 */
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
/*
Route::get('/activity/transactions', function () {
    return new ActivityCollection(Activity::all());
});

Route::middleware('auth:api')->get('/activity/transactions/{start}/{stop}/', function ($start, $stop) {
    return new ActivityCollection(Activity::whereBetween('date', [$start, $stop])->get());
});
*/
// Route::middleware('auth:api')->get('/activity/transactions/{start}/{stop}/', 'ApiController@getTransactionsByDate');

// Route::middleware('auth:api')->post('/activity/transaction/create', 'ApiController@store');

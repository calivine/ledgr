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

/**
 * Authenticated API routes require: ledgr.site/api/params?api_token=TOKEN
 * Get user by API key: http://ledgr.loc/api/user?api_token=TOKEN
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/*
Route::get('/activity/transactions', function () {
    return new ActivityCollection(Activity::all());
});

Route::middleware('auth:api')->get('/activity/transactions/{start}/{stop}/', function ($start, $stop) {
    return new ActivityCollection(Activity::whereBetween('date', [$start, $stop])->get());
});
*/
Route::middleware('auth:api')->get('/activity/transactions/{start}/{stop}/', 'ApiController@getTransactionsByDate');

Route::post('/transaction/store', 'ApiController@store');

Route::middleware('auth:api')->get('/user/test/get', 'ApiController@get');

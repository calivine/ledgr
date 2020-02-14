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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/activity/transactions', function () {
    return new ActivityCollection(Activity::all());
});

Route::get('/activity/transactions/{start}/{stop}', function ($start, $stop) {
    return new ActivityCollection(Activity::whereBetween('date', [$start, $stop])->get());
});
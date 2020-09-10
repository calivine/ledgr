<?php

Route::group(['middleware' => 'auth'], function() {

    Route::prefix('bill')->group(function () {
        Route::get('new', 'BillsController@storeBill');

    });

});

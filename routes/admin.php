<?php

Route::group(['middleware' => 'auth'], function() {

    Route::prefix('admin')->group(function () {
        # GET Database Snapshot
        Route::get('/archive', 'AdminController@backupTables');

        # GET Read Database Snapshot
        Route::get('/readArchive', 'AdminController@readBackupTables');

        # GET Budget Column Format
        Route::get('/formatBudget', 'AdminController@formatPeriodColumn');

    });

});

<?php

Route::group(['middleware' => ['auth', 'admin']], function() {

    Route::prefix('admin')->group(function () {
        # GET Database Snapshot
        Route::get('/archive', 'AdminController@backupTables')->name('archive');

        # GET Read Database Snapshot
        Route::get('/readArchive', 'AdminController@readBackupTables')->name('readArchive');

        # GET Budget Column Format
        Route::get('/formatBudget', 'AdminController@formatPeriodColumn');

        # GET Admin Panel
        Route::get('/', 'AdminController@index')->name('panel');

    });

});

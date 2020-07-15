<?php

Route::group(['middleware' => 'auth'], function() {



    # DISPLAY New User Budget Table
    Route::get('/budget/setup', 'BudgetController@newBudgetSetup');
    Route::post('/budget/setup/new', 'BudgetController@budgetSetup')->name('setup');

    # UPDATE Planned Budget Value
    Route::post('/budget/planned/update', 'BudgetController@updatePlanned');

    # CREATE New Budget Category
    Route::post('/budget/category/new', 'BudgetController@createCategory')->name('category');

    # UPDATE Budget Icon
    Route::post('/budget/icon/update', 'BudgetController@updateIcon');

    # DELETE Budget Category
    Route::get('/budget/{id}/delete', 'BudgetController@deleteBudget');
    Route::delete('/budget/{id}/destroy', 'BudgetController@destroyBudget');

    # DISPLAY Budget Table
    Route::get('/budget', 'BudgetController@index')->name('budget');


});

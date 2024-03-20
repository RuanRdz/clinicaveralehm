<?php

Route::group(array('before' => 'auth', 'prefix' => 'testeforcatratamentos'), function(){

    Route::get('index/{id}', array(

        'uses' => 'TesteforcatratamentosController@index',
        'as' => 'testeforcatratamentosIndex'
    ));

    Route::get('create/{id}', array(

        'uses' => 'TesteforcatratamentosController@create',
        'as' => 'testeforcatratamentosCreate'
    ));

    Route::get('edit/{id}', array(

        'uses' => 'TesteforcatratamentosController@edit',
        'as' => 'testeforcatratamentosEdit'
    ));

    Route::get('destroy/{id}', array(

        'uses' => 'TesteforcatratamentosController@destroy',
        'as' => 'testeforcatratamentosDestroy'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('store', array(

            'uses' => 'TesteforcatratamentosController@store',
            'as' => 'testeforcatratamentosStore'
        ));

        Route::post('update/{id}', array(

            'uses' => 'TesteforcatratamentosController@update',
            'as' => 'testeforcatratamentosUpdate'
        ));
    });
});

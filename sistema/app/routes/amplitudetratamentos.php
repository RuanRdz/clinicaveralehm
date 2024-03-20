<?php

Route::group(array('before' => 'auth', 'prefix' => 'amplitudetratamentos'), function(){

    Route::get('index/{id}', array(

        'uses' => 'AmplitudetratamentosController@index',
        'as' => 'amplitudetratamentosIndex'
    ));

    Route::get('create/{id}', array(

        'uses' => 'AmplitudetratamentosController@create',
        'as' => 'amplitudetratamentosCreate'
    ));

    Route::get('edit/{id}', array(

        'uses' => 'AmplitudetratamentosController@edit',
        'as' => 'amplitudetratamentosEdit'
    ));

    Route::get('destroy/{id}', array(

        'uses' => 'AmplitudetratamentosController@destroy',
        'as' => 'amplitudetratamentosDestroy'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('store', array(

            'uses' => 'AmplitudetratamentosController@store',
            'as' => 'amplitudetratamentosStore'
        ));

        Route::post('update/{id}', array(

            'uses' => 'AmplitudetratamentosController@update',
            'as' => 'amplitudetratamentosUpdate'
        ));
    });
});

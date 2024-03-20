<?php

Route::group(array('before' => 'auth', 'prefix' => 'testeforca'), function(){

    Route::get('/create', array(

        'uses' => 'TesteforcaController@create',
        'as' => 'testeforcaCreate'
    ));

    Route::get('/edit/{id}', array(

        'uses' => 'TesteforcaController@edit',
        'as' => 'testeforcaEdit'
    ));

    Route::get('/destroy/{id}', array(

        'uses' => 'TesteforcaController@destroy',
        'as' => 'testeforcaDestroy'
    ));

    Route::get('/restore/{id}', array(

        'uses' => 'TesteforcaController@restore',
        'as' => 'testeforcaRestore'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('/store', array(

            'uses' => 'TesteforcaController@store',
            'as' => 'testeforcaStore'
        ));

        Route::post('/update/{id}', array(

            'uses' => 'TesteforcaController@update',
            'as' => 'testeforcaUpdate'
        ));
    });
});


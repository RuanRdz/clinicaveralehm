<?php

Route::group(array('before' => 'auth', 'prefix' => 'amplitudes'), function(){

    Route::get('/create', array(

        'uses' => 'AmplitudesController@create',
        'as' => 'amplitudesCreate'
    ));

    Route::get('/edit/{id}', array(

        'uses' => 'AmplitudesController@edit',
        'as' => 'amplitudesEdit'
    ));

    Route::get('/destroy/{id}', array(

        'uses' => 'AmplitudesController@destroy',
        'as' => 'amplitudesDestroy'
    ));

    Route::get('/restore/{id}', array(

        'uses' => 'AmplitudesController@restore',
        'as' => 'amplitudesRestore'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('/store', array(

            'uses' => 'AmplitudesController@store',
            'as' => 'amplitudesStore'
        ));

        Route::post('/update/{id}', array(

            'uses' => 'AmplitudesController@update',
            'as' => 'amplitudesUpdate'
        ));
    });
});


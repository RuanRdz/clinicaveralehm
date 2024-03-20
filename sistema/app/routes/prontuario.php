<?php

Route::group(array('before' => 'auth', 'prefix' => 'prontuario'), function(){

    Route::get('/index/{paciente_id}', array(

        'uses' => 'ProntuarioController@index',
        'as' => 'prontuarioIndex'
    ));

    Route::get('/show/{id}', array(

        'uses' => 'ProntuarioController@show',
        'as' => 'prontuarioShow'
    ));

    Route::get('/html/{id}', array(

        'uses' => 'ProntuarioController@html',
        'as' => 'prontuarioHtml'
    ));

    Route::get('/create/{paciente_id}/{tratamento_id}', array(

        'uses' => 'ProntuarioController@create',
        'as' => 'prontuarioCreate'
    ));

    Route::get('/edit/{id}', array(

        'uses' => 'ProntuarioController@edit',
        'as' => 'prontuarioEdit'
    ));

    Route::get('/destroy/{id}', array(

        'uses' => 'ProntuarioController@destroy',
        'as' => 'prontuarioDestroy'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('/store', array(

            'uses' => 'ProntuarioController@store',
            'as' => 'prontuarioStore'
        ));

        Route::post('/update/{id}', array(

            'uses' => 'ProntuarioController@update',
            'as' => 'prontuarioUpdate'
        ));
    });
});


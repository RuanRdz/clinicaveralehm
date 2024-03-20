<?php

Route::group(array('before' => 'auth', 'prefix' => 'atividades_config'), function(){

    Route::get('/', array(

        'uses' => 'AtividadesconfigController@index',
        'as' => 'atividadesconfig'
    ));

    Route::get('/show/{bloco}', array(

        'uses' => 'AtividadesconfigController@show',
        'as' => 'atividadesconfigShow'
    ));

    Route::get('/create/{letra}', array(

        'uses' => 'AtividadesconfigController@create',
        'as' => 'atividadesconfigCreate'
    ));

    Route::get('/edit/{id}', array(

        'uses' => 'AtividadesconfigController@edit',
        'as' => 'atividadesconfigEdit'
    ));

    Route::get('/destroy/{id}', array(

        'uses' => 'AtividadesconfigController@destroy',
        'as' => 'atividadesconfigDestroy'
    ));

    Route::get('/restore/{id}', array(

        'uses' => 'AtividadesconfigController@restore',
        'as' => 'atividadesconfigRestore'
    ));

    Route::post('/ordenar', array(

        'uses' => 'AtividadesconfigController@ordenar',
        'as' => 'atividadesconfigOrdenar'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('/store', array(

            'uses' => 'AtividadesconfigController@store',
            'as' => 'atividadesconfigStore'
        ));

        Route::post('/update/{id}', array(

            'uses' => 'AtividadesconfigController@update',
            'as' => 'atividadesconfigUpdate'
        ));
    });
});


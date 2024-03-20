<?php

Route::group(array('before' => 'auth', 'prefix' => 'tratamentonotificacoes'), function(){

    Route::get('/{id}', array(

        'uses' => 'TratamentonotificacoesController@index',
        'as' => 'tratamentonotificacoes'
    ));

    Route::get('/alterar-estado/{id}', array(

        'uses' => 'TratamentonotificacoesController@alterarEstado',
        'as' => 'tratamentonotificacoesAlterarEstado'
    ));


    Route::get('/create/{id?}', array(

        'uses' => 'TratamentonotificacoesController@create',
        'as' => 'tratamentonotificacoesCreate'
    ));

    Route::get('/show/{id}/{layout}', array(

        'uses' => 'TratamentonotificacoesController@show',
        'as' => 'tratamentonotificacoesShow'
    ));

    Route::get('/edit/{id}', array(

        'uses' => 'TratamentonotificacoesController@edit',
        'as' => 'tratamentonotificacoesEdit'
    ));

    Route::get('/destroy/{id}', array(

        'uses' => 'TratamentonotificacoesController@destroy',
        'as' => 'tratamentonotificacoesDestroy'
    ));

    Route::get('/restore/{id}', array(

        'uses' => 'TratamentonotificacoesController@restore',
        'as' => 'tratamentonotificacoesRestore'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('/store', array(

            'uses' => 'TratamentonotificacoesController@store',
            'as' => 'tratamentonotificacoesStore'
        ));

        Route::post('/update/{id}', array(

            'uses' => 'TratamentonotificacoesController@update',
            'as' => 'tratamentonotificacoesUpdate'
        ));
    });
});

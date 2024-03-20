<?php

Route::group(array('before' => 'auth', 'prefix' => 'financeiro'), function(){

    Route::match(array('GET', 'POST'), '/pacientes', array(

        'uses' => 'EntradaspacienteController@index',
        'as' => 'financeiroReceber'
    ));

    Route::get('/pacientes-excel', array(

        'uses' => 'EntradaspacienteController@excel',
        'as' => 'financeiroReceberExcel'
    ));

    /*
    // DESATIVADO
    Route::get('/create-receber-automatico/{id}', array(

        'uses' => 'EntradaspacienteController@createAutomatico',
        'as' => 'financeiroCreateReceberAutomatico'
    ));
    */

    Route::get('/create-receber/{id}', array(

        'uses' => 'EntradaspacienteController@create',
        'as' => 'financeiroCreateReceber'
    ));

    Route::get('/edit-receber/{id}', array(

        'uses' => 'EntradaspacienteController@edit',
        'as' => 'financeiroEditReceber'
    ));


    Route::get('/create-receber-parcelado/{id}', array(

        'uses' => 'EntradaspacienteController@createParcelado',
        'as' => 'financeiroCreateReceberParcelado'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('/store-receber', array(

            'uses' => 'EntradaspacienteController@store',
            'as' => 'financeiroStoreReceber'
        ));
        Route::post('/store-receber-parcelado', array(

            'uses' => 'EntradaspacienteController@storeParcelado',
            'as' => 'financeiroStoreReceberParcelado'
        ));
        Route::post('/update-receber/{id}', array(

            'uses' => 'EntradaspacienteController@update',
            'as' => 'financeiroUpdateReceber'
        ));

        Route::post('/gerar-entrada', array(

            'uses' => 'EntradaspacienteController@gerarEntrada',
            'as' => 'financeiroGerarEntrada'
        ));
    });
});

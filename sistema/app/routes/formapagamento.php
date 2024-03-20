<?php

Route::group(array('before' => 'auth', 'prefix' => 'formapagamento'), function(){

    Route::get('/', array(

        'uses' => 'FormapagamentoController@index',
        'as' => 'formapagamento'
    ));

    Route::get('/create', array(
        
        'uses' => 'FormapagamentoController@create',
        'as' => 'formapagamentoCreate'
    ));

    Route::get('/show/{id}', array(
        
        'uses' => 'FormapagamentoController@show',
        'as' => 'formapagamentoShow'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'FormapagamentoController@edit',
        'as' => 'formapagamentoEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'FormapagamentoController@destroy',
        'as' => 'formapagamentoDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'FormapagamentoController@store',
            'as' => 'formapagamentoStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'FormapagamentoController@update',
            'as' => 'formapagamentoUpdate'
        ));
    });
});


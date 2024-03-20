<?php

Route::group(array('before' => 'auth', 'prefix' => 'contas'), function(){

    Route::get('/', array(

        'uses' => 'ContasController@index',
        'as' => 'contas'
    ));

    Route::get('/create', array(
        
        'uses' => 'ContasController@create',
        'as' => 'contasCreate'
    ));

    Route::get('/show/{id}', array(
        
        'uses' => 'ContasController@show',
        'as' => 'contasShow'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'ContasController@edit',
        'as' => 'contasEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'ContasController@destroy',
        'as' => 'contasDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'ContasController@store',
            'as' => 'contasStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'ContasController@update',
            'as' => 'contasUpdate'
        ));
    });
});


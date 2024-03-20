<?php

Route::group(array('before' => 'auth', 'prefix' => 'agendasituacoes'), function(){

    Route::get('/', array(

        'uses' => 'AgendasituacoesController@index',
        'as' => 'agendasituacoes'
    ));

    Route::get('/create', array(
        
        'uses' => 'AgendasituacoesController@create',
        'as' => 'agendasituacoesCreate'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'AgendasituacoesController@edit',
        'as' => 'agendasituacoesEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'AgendasituacoesController@destroy',
        'as' => 'agendasituacoesDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'AgendasituacoesController@store',
            'as' => 'agendasituacoesStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'AgendasituacoesController@update',
            'as' => 'agendasituacoesUpdate'
        ));
    });
});

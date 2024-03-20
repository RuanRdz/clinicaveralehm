<?php

Route::group(array('before' => 'auth', 'prefix' => 'fornecedores'), function(){

    Route::get('/', array(

        'uses' => 'FornecedoresController@index',
        'as' => 'fornecedores'
    ));

    Route::get('/create', array(
        
        'uses' => 'FornecedoresController@create',
        'as' => 'fornecedoresCreate'
    ));

    Route::get('/show/{id}', array(
        
        'uses' => 'FornecedoresController@show',
        'as' => 'fornecedoresShow'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'FornecedoresController@edit',
        'as' => 'fornecedoresEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'FornecedoresController@destroy',
        'as' => 'fornecedoresDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'FornecedoresController@store',
            'as' => 'fornecedoresStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'FornecedoresController@update',
            'as' => 'fornecedoresUpdate'
        ));
    });
});


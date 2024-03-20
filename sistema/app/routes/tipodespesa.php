<?php

Route::group(array('before' => 'auth', 'prefix' => 'tipodespesa'), function(){

    Route::get('/', array(

        'uses' => 'TipodespesaController@index',
        'as' => 'tipodespesa'
    ));

    Route::get('/create', array(
        
        'uses' => 'TipodespesaController@create',
        'as' => 'tipodespesaCreate'
    ));

    Route::get('/show/{id}', array(
        
        'uses' => 'TipodespesaController@show',
        'as' => 'tipodespesaShow'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'TipodespesaController@edit',
        'as' => 'tipodespesaEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'TipodespesaController@destroy',
        'as' => 'tipodespesaDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'TipodespesaController@store',
            'as' => 'tipodespesaStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'TipodespesaController@update',
            'as' => 'tipodespesaUpdate'
        ));
    });
});


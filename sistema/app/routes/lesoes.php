<?php

Route::group(array('before' => 'auth', 'prefix' => 'lesoes'), function(){

    Route::get('/', array(

        'uses' => 'LesoesController@index',
        'as' => 'lesoes'
    ));

    Route::get('/create', array(
        
        'uses' => 'LesoesController@create',
        'as' => 'lesoesCreate'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'LesoesController@edit',
        'as' => 'lesoesEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'LesoesController@destroy',
        'as' => 'lesoesDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'LesoesController@store',
            'as' => 'lesoesStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'LesoesController@update',
            'as' => 'lesoesUpdate'
        ));
    });
});


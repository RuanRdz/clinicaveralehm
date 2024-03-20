<?php

Route::group(array('before' => 'auth', 'prefix' => 'textosprontuario'), function(){

    Route::get('/', array(

        'uses' => 'TextosprontuarioController@index',
        'as' => 'textosprontuario'
    ));

    Route::get('/json', array(

        'uses' => 'TextosprontuarioController@indexJson',
        'as' => 'textosprontuariojson'
    ));

    Route::get('/create', array(
        
        'uses' => 'TextosprontuarioController@create',
        'as' => 'textosprontuarioCreate'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'TextosprontuarioController@edit',
        'as' => 'textosprontuarioEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'TextosprontuarioController@destroy',
        'as' => 'textosprontuarioDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'TextosprontuarioController@store',
            'as' => 'textosprontuarioStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'TextosprontuarioController@update',
            'as' => 'textosprontuarioUpdate'
        ));
    });
});


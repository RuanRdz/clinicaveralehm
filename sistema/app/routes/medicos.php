<?php

Route::group(array('before' => 'auth', 'prefix' => 'medicos'), function(){

    Route::get('/', array(

        'uses' => 'MedicosController@index',
        'as' => 'medicos'
    ));

    Route::get('/create', array(
        
        'uses' => 'MedicosController@create',
        'as' => 'medicosCreate'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'MedicosController@edit',
        'as' => 'medicosEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'MedicosController@destroy',
        'as' => 'medicosDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'MedicosController@store',
            'as' => 'medicosStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'MedicosController@update',
            'as' => 'medicosUpdate'
        ));
    });
});


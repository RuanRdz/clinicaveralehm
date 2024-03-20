<?php 

Route::group(array('before' => 'auth', 'prefix' => 'cidades'), function() {

    Route::get('/', array(

        'uses' => 'CidadesController@index',
        'as' => 'cidade'
    ));

    Route::get('/create', array(
        
        'uses' => 'CidadesController@create',
        'as' => 'cidadesCreate'
    ));

    Route::get('/show/{id}', array(
        
        'uses' => 'CidadesController@show',
        'as' => 'cidadesShow'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'CidadesController@edit',
        'as' => 'cidadesEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'CidadesController@destroy',
        'as' => 'cidadesDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'CidadesController@store',
            'as' => 'cidadesStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'CidadesController@update',
            'as' => 'cidadesUpdate'
        ));
    });
});

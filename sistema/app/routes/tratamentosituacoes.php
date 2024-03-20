<?php

Route::group(array('before' => 'auth', 'prefix' => 'tratamentosituacoes'), function(){

    Route::get('/', array(

        'uses' => 'TratamentosituacoesController@index',
        'as' => 'tratamentosituacoes'
    ));

    Route::get('/create', array(
        
        'uses' => 'TratamentosituacoesController@create',
        'as' => 'tratamentosituacoesCreate'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'TratamentosituacoesController@edit',
        'as' => 'tratamentosituacoesEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'TratamentosituacoesController@destroy',
        'as' => 'tratamentosituacoesDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'TratamentosituacoesController@store',
            'as' => 'tratamentosituacoesStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'TratamentosituacoesController@update',
            'as' => 'tratamentosituacoesUpdate'
        ));
    });
});

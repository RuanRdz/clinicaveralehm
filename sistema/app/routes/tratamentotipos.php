<?php

Route::group(array('before' => 'auth', 'prefix' => 'tratamentotipos'), function(){

    Route::get('/', array(

        'uses' => 'TratamentotiposController@index',
        'as' => 'tratamentotipos'
    ));

    Route::get('/create', array(
        
        'uses' => 'TratamentotiposController@create',
        'as' => 'tratamentotiposCreate'
    ));
    
    Route::get('/edit/{id}', array(
        
        'uses' => 'TratamentotiposController@edit',
        'as' => 'tratamentotiposEdit'
    ));
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'TratamentotiposController@destroy',
        'as' => 'tratamentotiposDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'TratamentotiposController@store',
            'as' => 'tratamentotiposStore'
        ));
        
        Route::post('/update/{id}', array(

            'uses' => 'TratamentotiposController@update',
            'as' => 'tratamentotiposUpdate'
        ));
    });
});

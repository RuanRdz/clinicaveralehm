<?php

Route::group(array('before' => 'auth', 'prefix' => 'complexidadepacientes'), function(){
    
    Route::get('/destroy/{id}', array(
        
        'uses' => 'ComplexidadepacientesController@destroy',
        'as' => 'complexidadepacientesDestroy'
    ));
    
    Route::group(array('before' => 'csrf'), function(){
        
        Route::post('/store', array(
            
            'uses' => 'ComplexidadepacientesController@store',
            'as' => 'complexidadepacientesStore'
        ));
    });
});

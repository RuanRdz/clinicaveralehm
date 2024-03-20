<?php

Route::group(array('before' => 'auth', 'prefix' => 'terminologiauniforme'), function(){

    Route::get('/edit/{id}', array(

        'uses' => 'TerminologiaUniformeController@edit',
        'as' => 'terminologiauniformeEdit'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('/update/{id}', array(

            'uses' => 'TerminologiaUniformeController@update',
            'as' => 'terminologiauniformeUpdate'
        ));
    });
});

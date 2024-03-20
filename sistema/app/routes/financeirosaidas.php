<?php

Route::group(array('before' => 'auth', 'prefix' => 'financeiro'), function(){

    Route::get('/create-pagar', array(

        'uses' => 'SaidasController@create',
        'as' => 'financeiroCreatePagar'
    ));
    Route::get('/edit-pagar/{id}', array(

        'uses' => 'SaidasController@edit',
        'as' => 'financeiroEditPagar'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('/store-pagar', array(

            'uses' => 'SaidasController@store',
            'as' => 'financeiroStorePagar'
        ));
        Route::post('/update-pagar/{id}', array(

            'uses' => 'SaidasController@update',
            'as' => 'financeiroUpdatePagar'
        ));
    });
});

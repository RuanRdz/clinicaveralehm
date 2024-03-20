<?php

Route::group(array('before' => 'auth', 'prefix' => 'financeiro'), function(){

    Route::get('/create-receber-adm', array(

        'uses' => 'EntradasController@create',
        'as' => 'financeiroCreateReceberAdm'
    ));

    Route::get('/edit-receber-adm/{id}', array(

        'uses' => 'EntradasController@edit',
        'as' => 'financeiroEditReceberAdm'
    ));

    Route::group(array('before' => 'csrf'), function(){

        Route::post('/store-receber-adm', array(

            'uses' => 'EntradasController@store',
            'as' => 'financeiroStoreReceberAdm'
        ));
        Route::post('/update-receber-adm/{id}', array(

            'uses' => 'EntradasController@update',
            'as' => 'financeiroUpdateReceberAdm'
        ));
    });
});

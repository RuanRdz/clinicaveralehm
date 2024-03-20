<?php

Route::group(array('before' => 'auth', 'prefix' => 'pacientes'), function(){

    // Route::get('/foto/{filename?}', ['as' => 'foto', function($filename = null) {
    //     $lifetime = 129600; // 90 dias
    //     $img = Image::cache(function($image) use ($filename) {
    //         if ($filename) {
    //             if (file_exists('img/fotos/'.$filename)) {
    //                 return $image->make(asset('img/fotos/'.$filename));
    //             }
    //         }
    //         return $image->make(asset('img/foto.png'));
    //     }, $lifetime, false);
    //     return Response::make($img, 200, ['Content-Type' => 'image']);
    // }]);

    Route::match(array('GET', 'POST'), '/', array(

        'uses' => 'PacientesController@index',
        'as' => 'pacientes'
    ));

    // Route::get('/tratamentos/{id}/{id2?}', array(

    //     'uses' => 'PacientesController@tratamentos',
    //     'as' => 'pacientesTratamentos'
    // ));

    Route::get('/create', array(

        'uses' => 'PacientesController@create',
        'as' => 'pacientesCreate'
    ));

    Route::get('/show/{id}', array(

        'uses' => 'PacientesController@show',
        'as' => 'pacientesShow'
    ));

    Route::get('/edit/{id}', array(

        'uses' => 'PacientesController@edit',
        'as' => 'pacientesEdit'
    ));

    Route::get('/destroy/{id}', array(

        'uses' => 'PacientesController@destroy',
        'as' => 'pacientesDestroy'
    ));

    Route::post('/search', array(

        'uses' => 'PacientesController@search',
        'as' => 'pacientesSearch'
    ));


    Route::get('/arquivo/{id}', array(

        'uses' => 'PacientesController@arquivo',
        'as' => 'pacientesArquivo'
    ));
    Route::get('/arquivodownload/{id}', array(

            'uses' => 'PacientesController@arquivodownload',
            'as' => 'PacientesArquivoDownload'
        )
    );
    Route::get('/arquivodelete/{id}', array(

            'uses' => 'PacientesController@arquivodelete',
            'as' => 'PacientesArquivoDelete'
        )
    );

    Route::group(array('before' => 'csrf'), function(){

        Route::post('/store', array(

            'uses' => 'PacientesController@store',
            'as' => 'pacientesStore'
        ));

        Route::post('/update/{id}', array(

            'uses' => 'PacientesController@update',
            'as' => 'pacientesUpdate'
        ));


        Route::post('/arquivostore', array(

            'uses' => 'PacientesController@arquivoStore',
            'as' => 'pacientesArquivoStore'
        ));
    });

    Route::post('/update-anamnese/{id}', array(
        'uses' => 'PacientesController@updateAnamnese',
        'as' => 'pacientesUpdateAnamnese'
    ));

    Route::post('/update-celular/{id}', array(
        'uses' => 'PacientesController@updateCelular',
        'as' => 'pacientesUpdateCelular'
    ));
});

<?php

// route to show the login form
Route::get('/login', array(
    
    'before' => 'guest',
    'uses' => 'LoginController@index',
    'as' => 'login'
));

// route to process the form
Route::post('/login', array(

    'before' => 'csrf',
    'uses' => 'LoginController@entrar',
    'as' => 'entrar'
));

Route::get('/logout', array(

    'uses' => 'LoginController@sair',
    'as' => 'sair'
));

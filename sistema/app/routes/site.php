<?php

// Página inicial do site
// Remover 'guest' quando fizer o site
Route::get('/', array(
    
    'before' => 'guest',
    'uses' => 'SiteController@index',
    'as' => 'index'
));


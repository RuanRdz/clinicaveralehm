<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	// app_path().'/controllers/Protocols',
	// app_path().'/controllers/Protocols/Tests',
	app_path().'/controllers/Protocolosv1',
	app_path().'/controllers/Protocolosv1/Cadastros',
	app_path().'/controllers/Clinica',
	app_path().'/controllers/Tratamentos',
	app_path().'/controllers/Financeiro',
	app_path().'/controllers/Financeiro/Cadastros',
	app_path().'/models',
	app_path().'/models/Clinica',
	app_path().'/models/Tratamento',
	// app_path().'/models/Protocols',
	// app_path().'/models/Protocols/Tests',
	app_path().'/models/Protocolosv1',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
    $pathInfo = Request::getPathInfo();
    $message = $exception->getMessage() ?: 'Exception';
    // Log::error("$code - $message @ $pathInfo\r\n$exception");

    if (Config::get('app.debug')) {
        Log::error($exception);
        return;
    }

    switch ($code)
    {
        case 403:
            return Response::view('error/403', compact('message'), 403);
        case 404:
            return Response::view('error/404', compact('message'), 404);
        case 500:
            return Response::view('error/500', compact('message'), 500);
        default:
            Log::error($exception);
            break;
    }
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Sistema em manutenção. Voltaremos em breve.", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';


/**
 * Custom Helpers
 */
require app_path().'/helpers.php';

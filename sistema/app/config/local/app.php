<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| When your application is in debug mode, detailed error messages with
	| stack traces will be shown on every error that occurs within your
	| application. If disabled, a simple generic error page is shown.
	|
	*/

	'debug' => true,

	'url' => 'https://veralehm.local',
	'paciente_uploads_path' => '/home/everton/Documents/code/veralehm.local/uploads/',
    'paciente_uploads_older_path' => '/home/everton/Documents/code/veralehm.local/uploads_older/',

	'timezone' => 'America/Sao_Paulo',

	'locale' => 'pt_BR',

    	/*
	|--------------------------------------------------------------------------
	| Encryption Key
    |--------------------------------------------------------------------------
    */
	'key' => 'wfm4n4Na19Def51BTb5TKKf9wkqBuZyQ',
	'cipher' => 'AES-256-CBC',
	// 'cipher' => MCRYPT_RIJNDAEL_128,

	'providers' => array(

		'Illuminate\Foundation\Providers\ArtisanServiceProvider',
		'Illuminate\Auth\AuthServiceProvider',
		'Illuminate\Cache\CacheServiceProvider',
		'Illuminate\Session\CommandsServiceProvider',
		'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider',
		'Illuminate\Routing\ControllerServiceProvider',
		'Illuminate\Cookie\CookieServiceProvider',
		'Illuminate\Database\DatabaseServiceProvider',
		'Illuminate\Encryption\EncryptionServiceProvider',
		'Illuminate\Filesystem\FilesystemServiceProvider',
		'Illuminate\Hashing\HashServiceProvider',
		'Illuminate\Html\HtmlServiceProvider',
		'Illuminate\Log\LogServiceProvider',
		'Illuminate\Mail\MailServiceProvider',
		'Illuminate\Database\MigrationServiceProvider',
		'Illuminate\Pagination\PaginationServiceProvider',
		'Illuminate\Queue\QueueServiceProvider',
		'Illuminate\Redis\RedisServiceProvider',
		'Illuminate\Remote\RemoteServiceProvider',
		'Illuminate\Auth\Reminders\ReminderServiceProvider',
		'Illuminate\Database\SeedServiceProvider',
		'Illuminate\Session\SessionServiceProvider',
		'Illuminate\Translation\TranslationServiceProvider',
		'Illuminate\Validation\ValidationServiceProvider',
		'Illuminate\View\ViewServiceProvider',
		'Illuminate\Workbench\WorkbenchServiceProvider',
		'Way\Generators\GeneratorsServiceProvider',
		'Former\FormerServiceProvider',
        'Intervention\Image\ImageServiceProvider',
        'Tomgrohl\Laravel\Encryption\EncryptionServiceProvider',
	),
);

<!doctype html>
<html 
    class="no-js" 
    lang="pt" 
>
    <head>
        @section('head')
            <meta charset="utf-8" />
            <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
            <meta http-equiv="PRAGMA" content="NO-CACHE">
            <meta http-equiv="EXPIRES" content="0">
            <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="author" content="ezp127@gmail.com"/>
            <meta name="robots" content="noindex, nofollow"/>
            {{ HTML::style('css/vendor.css?'.Config::get('cache.resources_version')) }}
            {{ HTML::style('css/app.css?'.Config::get('cache.resources_version')) }}
        @show
    </head>
    <body class="bg-white">
        <div class="container-fluid">
            @yield('content')
        </div>
    </body>
</html>

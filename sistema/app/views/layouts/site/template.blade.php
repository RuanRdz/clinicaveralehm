<!doctype html>
<html class="no-js" lang="pt">
<head>
    @section('head')
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        <meta name="author" content="ezpabon@gmail.com"/>
        {{ HTML::style('css/vendor.css?'.Config::get('cache.resources_version')) }}
        {{ HTML::style('css/app.css?'.Config::get('cache.resources_version')) }}
    @show
</head>

<body class="font-sans">
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
            {{ Session::get('success') }}
            <!--<a href="#" class="close">&times;</a>-->
        </div>
    @elseif(Session::has('fail'))
        <div class="alert alert-warning" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
            {{ Session::get('fail') }}
            <!--<a href="#" class="close">&times;</a>-->
        </div>
    @endif

    <div class="container">
        @yield('content')
    </div>

    <script src="{{ URL::asset('js/vendor.js?'.Config::get('cache.resources_version')) }}"></script>
</body>
</html>

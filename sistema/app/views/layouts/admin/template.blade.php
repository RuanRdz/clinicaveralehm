<!doctype html>
<html class="no-js" lang="pt" ng-app="baseApp" ng-strict-di>
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
    <body>

        @include('layouts.admin.alerts')
        @include('layouts.admin.modals')
        @include('layouts.admin.header')

        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-16">
                    <div class="no-print">
                        @section('main-panel-heading')
                        @show
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-16">
                    @yield('content')
                </div>
            </div>
            <div class="row">
                <div class="col-xs-16">
                    <div class="no-print" style="margin-top: 300px;">
                        <hr />
                        <p style="text-align: center; color: #707070;">
                        {{ Sistema::parametros()['telefone'] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ URL::asset('js/vendor.js?'.Config::get('cache.resources_version')) }}"></script>
        <script src="{{ URL::asset('js/app.js?'.Config::get('cache.resources_version')) }}"></script>
        <script src="{{ URL::asset('js/app_angular.js?'.Config::get('cache.resources_version')) }}"></script>
    </body>
</html>

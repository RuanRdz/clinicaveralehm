/**
 * Bootstrap the Base App
 */
angular.module('baseApp', ['ngSanitize', 'ui.tinymce'], [
    '$httpProvider',
    function ($httpProvider) {
        // $httpProvider.defaults.headers.post['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
    }
]);

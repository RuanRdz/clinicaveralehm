angular.module('baseApp').controller('ProntuarioFormEditController', [
    "$scope",
    "$sce",
    "$http",
    "$timeout",
    function(
        $scope,
        $sce,
        $http,
        $timeout
    ) {
        $scope.tinymceHtml = '';

        // $scope.updateHtml = function() {
        //     $scope.tinymceHtml = $sce.trustAsHtml($scope.tinymce);
        // };

        $scope.tinymceOptions = {
            theme: "modern",
            menubar: false,
            plugins: '',
            toolbar: 'bold italic | alignleft aligncenter alignright alignjustify',
            height: 400
        };

        var conteudo;
        conteudo = $('#data_conteudo').html();
        $timeout(function() {
            $('#data_conteudo').hide();
            $scope.tinymceHtml = conteudo;
        }, 500);
    }
]);

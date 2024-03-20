angular.module('baseApp').controller('TextosProntuarioFormController', [
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
        var conteudo;

        // $scope.updateHtml = function() {
        //     $scope.tinymceHtml = $sce.trustAsHtml($scope.tinymce);
        // };

        $scope.tinymceHtml = '';

        $scope.tinymceOptions = {
            theme: "modern",
            menubar: false,
            toolbar: 'bold italic | alignleft aligncenter alignright alignjustify',
            height: 400
        };

        $timeout(function() {
            conteudo = $('#data_conteudo').html();
            console.log(conteudo);
            $('#data_conteudo').hide();
            $scope.tinymceHtml = conteudo;
        }, 500);
    }
]);

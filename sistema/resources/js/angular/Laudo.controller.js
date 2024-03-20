angular.module('baseApp').controller('LaudoController', [
    "$scope",
    function(
        $scope
    ) {

        $scope.display = {
            rg: true,
            //
            tratamento: true,
            iniciotratamento: true,
            tipo: true,
            medico: true,
            profissional: true,
            datalesao: true,
            datacirurgia: true,
            lesao: true,
            membro: true,
            //
            usoinformacoes: true,
        };
    }
]);

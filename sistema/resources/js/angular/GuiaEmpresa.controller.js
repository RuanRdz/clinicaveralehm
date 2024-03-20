angular.module('baseApp').controller('GuiaEmpresaController', [
    "$scope",
    function(
        $scope
    ) {

        $scope.display = {
            cabecalho: true,
            rg: true,
            telefones: true,
            //
            tratamento: true,
            iniciotratamento: true,
            tipo: true,
            profissional: true,
            lesao: true,
            numerosessoes: true,
            //
            agenda: true,
            sessoes: true,
            datasessao: true,
            horasessao: true,
            situacao: true,
            assinatura: true,
            //
            declaracao: false,
        };
    }
]);

angular.module('baseApp').controller('GuiaPacienteController', [
    "$scope",
    "$http",
    "$timeout",
    function(
        $scope,
        $http,
        $timeout
    ) {

        $scope.message_sending = '';
        $scope.message_sending_success = '';
        $scope.message_sending_fail = '';

        $scope.display = {
            cabecalho: true,
            rg: true,
            cpf: true,
            endereco: true,
            cidade: true,
            telefones: true,
            datanascimento: true,
            carteirinha: true,
            //
            tratamento: true,
            iniciotratamento: true,
            tipo: true,
            medico: true,
            profissional: true,
            convenio: true,
            datalesao: true,
            datacirurgia: true,
            lesao: true,
            membro: true,
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

        $timeout(function() {
            $('#enable_alert_container').removeClass('hidden');
        }, 1000);

        $scope.sendEmailGuiaPaciente = function(url) {
            $scope.message_sending = '';
            $scope.message_sending_success = '';
            $scope.message_sending_fail = '';
            if ($scope.display.declaracao) {
                $scope.message_sending_fail = 'O envio de Declarações por e-mail não está disponível. Desmarque a opção "Declaração" para enviar a guia.';
                return;
            }
            $scope.message_sending = 'Enviando e-mail, por favor aguarde...';
            $http({
				method: "POST",
				url: url,
				data: "display="+angular.toJson($scope.display),
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).then(function(response) {
                $scope.message_sending = '';
                $scope.message_sending_success = response.data.message;
			}, function(error) {
                $scope.message_sending = '';
                $scope.message_sending_fail = response.data.message;
            });
        };
    }
]);

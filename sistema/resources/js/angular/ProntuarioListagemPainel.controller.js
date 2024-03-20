angular.module('baseApp').controller('ProntuarioListagemPainelController', [
    "$rootScope",
    "$scope",
    "$http",
    function(
        $rootScope,
        $scope,
        $http
    ) {
       
        $scope.carregarHtmlEvolucao = function(route) {
            $http({
				method: "GET",
				url: route,
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).then(function(response) {
                $rootScope.$broadcast('copiouProntuario', response.data);
			}, function(error) {
                console.log(error.data);
            });
        };

        // Limpa o 'cache' senão não funciona
        $('body').on('hidden.bs.modal', '#modal_prontuario', function () {
            $(this).removeData('bs.modal');
        });

        $('.listagem_prontuario, .listagem_complexidade')
            .animate(
                { scrollTop: $('.listagem_prontuario').prop("scrollHeight") }, 
                400
            );

    }
]);

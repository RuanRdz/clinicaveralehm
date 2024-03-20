angular.module('baseApp').controller('ProntuarioFormCreateController', [
    "$scope",
    "$sce",
    "$http",
    function(
        $scope,
        $sce,
        $http
    ) {
        $scope.editando = false;
        $scope.tinymceHtml = '';
        $scope.route_store = '';
        $scope.route_gabaritos = '';
        $scope.index_gabarito_selecionado = '';
        $scope.lista_gabaritos = [];

        $scope.$on('copiouProntuario', function(event, data) {
            if ($scope.editando) {
                $scope.tinymceHtml = data;
            } else {
                alert('Clique em "Escrever" antes de selecionar a evolução');
            }
        });

        // $scope.updateHtml = function() {
        //     $scope.tinymceHtml = $sce.trustAsHtml($scope.tinymce);
        // };

        $scope.escrever = function(route_store, route_gabaritos) {
            $scope.route_store = route_store;
            $scope.route_gabaritos = route_gabaritos;
            $scope.carregarGabaritos();
        };

        $scope.carregarGabaritos = function() {
            $http({
				method: "GET",
				url: $scope.route_gabaritos,
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).then(function(response) {
                var lista = [];
                angular.forEach(response.data, function(value, key) {
                    value = angular.fromJson(value);
                    lista.push(value);
                });
                $scope.lista_gabaritos = lista;
                $scope.editando = true;
                $('.painel-form-prontuario').find('.datepicker').datepicker();
                $('.painel-form-prontuario').find('.panel-heading').css('background', '#E8F7D0');
                $('.painel-form-prontuario').find('.panel-body').css('background', '#E8F7D0');
                $('#escrevendo_prontuario').removeClass('hidden');
			}, function(error) {
                console.log(error.data);
            });
        };

        $scope.aplicarGabarito = function() {
            var item;
            item = $scope.lista_gabaritos[$scope.index_gabarito_selecionado];
            $scope.tinymceHtml = item.conteudo;
        };

        // $scope.getContent = function() {
        //     console.log('Editor content:', $scope.tinymceHtml);
        // };

        // $scope.setContent = function() {
        //     $scope.tinymceHtml = 'Time: ' + (new Date());
        // };

        $scope.tinymceOptions = {
            theme: "modern",
            menubar: false,
            toolbar: 'bold italic | alignleft aligncenter alignright alignjustify',
            height: 400
        };
    }
]);

angular.module('baseApp').controller('FinanceiroPacienteController', [
    "$scope",
    "$http",
    "$httpParamSerializer",
    function(
        $scope,
        $http,
        $httpParamSerializer
    ) {

        $scope.REAL = value => currency(value, { symbol: '', decimal: ',', separator: '.' });
        $scope.ids_lancamentos = [];
        $scope.total = 0;
        $scope.total_desconto_taxa = 0;
        $scope.total_juros_multa = 0;
        $scope.total_pago = 0;
        $scope.show_totais = false;

        $scope.gerarEntrada = function() {
            $scope.ids_lancamentos = [];
            $scope.total = 0;
            $scope.total_desconto_taxa = 0;
            $scope.total_juros_multa = 0;
            $scope.total_pago = 0;
            var checkboxes = $('.checkboxContainerArea input:checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Marque ao menos um lançamento para prosseguir.');
            } else {
                $('#modal_gerar_entrada').modal('show');
                $(checkboxes).each(function (i, item) {
                    $scope.ids_lancamentos.push(item.dataset.id);
                    $scope.total = $scope.total + $scope.REAL(item.dataset.valor).value;
                    $scope.total_desconto_taxa = $scope.total_desconto_taxa + $scope.REAL(item.dataset.desconto_taxa).value;
                    $scope.total_juros_multa = $scope.total_juros_multa + $scope.REAL(item.dataset.juros_multa).value;
                    $scope.total_pago = $scope.total_pago + $scope.REAL(item.dataset.valor_pago).value;
                });
                $scope.total_pago = ($scope.total + $scope.total_juros_multa) - $scope.total_desconto_taxa;
                $scope.total = $scope.REAL($scope.total).format();
                $scope.total_desconto_taxa = $scope.REAL($scope.total_desconto_taxa).format();
                $scope.total_juros_multa = $scope.REAL($scope.total_juros_multa).format();
                $scope.total_pago = $scope.REAL($scope.total_pago).format();
                $scope.tipo_lancamento = 'lote';
            }
        };

        $('body').on('change', '#entradaCheckboxAll', function () {
            $(".checkboxContainerArea input:checkbox").prop('checked', $(this).prop("checked"));
        });

        $('body').on('submit', '#formFinanceiroGerarEntrada', function (e) {
            e.preventDefault();
            var itens;
            $('#lote_valor').val($scope.total);
            $('#lote_desconto_taxa').val($scope.total_desconto_taxa);
            $('#lote_juros_multa').val($scope.total_juros_multa);
            $('#lote_valor_pago').val($scope.total_pago);
            itens = $httpParamSerializer({ "ids_lancamentos[]": $scope.ids_lancamentos });
            $.ajax({
                url: $(this).prop('action'),
                type: 'POST',
                data: $('#formFinanceiroGerarEntrada').serialize()+'&'+itens,
                success: function (response) {
                    // console.log(response);
                    location.reload();
                }
            });
        });

        $scope.fecharCaixa = function() {
            confirm('O caixa do dia será fechado. Deseja confirmar?');
        };

        $scope.toggleTotais = function() {
            $scope.show_totais = !$scope.show_totais;
            console.log($scope.show_totais);
        };
    }
]);

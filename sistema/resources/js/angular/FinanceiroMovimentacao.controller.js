angular.module('baseApp').controller('FinanceiroMovimentacaoController', [
    "$scope",
    "$http",
    "$timeout",
    "$httpParamSerializer",
    function(
        $scope,
        $http,
        $timeout,
        $httpParamSerializer
    ) {

        $scope.movimento = {
            dados: [],
            total: { debito: '', credito: '', saldo: '' }
        };
        $scope.filtro_options = [];
        $scope.filtro = {};
        $scope.carregando_dados = true;
        $scope.show_totais = false;

        $scope.init = function(dados) {
            dados = JSON.parse(dados);
            $scope.route_financeiro_movimentacao_json = dados.route_financeiro_movimentacao_json;
            $scope.filtro_options = dados.filtro_options;
            $scope.filtro = dados.filtro;
            if ($scope.filtro.periodo_selecionado == '') {
                $scope.selecionaPeriodo('hoje');
            }
            $scope.carregaDadosMovimentacao();
        };

        $scope.pagamentoMultiplo = function(route) {
            var checkboxes = $('.checkboxContainerArea input:checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Marque ao menos um lançamento para prosseguir.');
            } else {
                $.ajax({
                    url: route,
                    dataType: "html",
                    success: function (view) {
                        $('#modal_geral').modal('show');
                        $('#modal_geral').find('.modal-body').html(view);
                        $('.datepicker').datepicker();
                    }
                });
            }
        };

        $scope.buttonListarItensLote = function(route) {
            $.ajax({
                url: route,
                dataType: "html",
                success: function (view) {
                    $('#modal_full').modal('show');
                    $('#modal_full').find('.modal-body').html(view);
                }
            });
        };

        $('body').on('change', '#pagamentoCheckboxAll', function () {
            $(".checkboxContainerArea input:checkbox").prop('checked', $(this).prop("checked"));
        });

        $('body').on('submit', '#formUpdatePagamento', function (e) {
            e.preventDefault();
            var checkboxes = $('.checkboxContainerArea input:checkbox:checked');
            var itens = [];
            $(checkboxes).each(function (i, item) {
                itens[i] = item.value;
            });
            $.ajax({
                url: $(this).prop('action'),
                type: 'POST',
                data: {
                    pagamento: $('input[name=pagamento]', this).val(),
                    itens: itens
                },
                success: function (result) {
                    location.reload();
                }
            });
        });



        // FILTRO

        $scope.carregaDadosMovimentacao = function() {
             $scope.carregando_dados = true;
            $http({
				method: "POST",
				url: $scope.route_financeiro_movimentacao_json,
                data: "filtro_json="+angular.toJson($scope.filtro),
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).then(function(response) {
                $scope.carregando_dados = false;
                $scope.movimento = response.data;
			}, function(error) {
                $scope.carregando_dados = false;
                console.log(error);
            });
        };

        $scope.selecionaPeriodo = function(opcao) {
            var f_view = 'DD/MM/YYYY';
            var f_submit = 'DD-MM-YYYY';
            $scope.filtro.periodo_selecionado = opcao;
            switch (opcao) {
                case 'hoje':
                    $scope.filtro.data_inicial = moment().format(f_submit);
                    $scope.filtro.data_final = moment().format(f_submit);
                    $scope.filtro.show_dropdown_periodo = true;
                    break;
                case 'semana':
                    $scope.filtro.data_inicial = moment().startOf('week').format(f_submit);
                    $scope.filtro.data_final = moment().endOf('week').format(f_submit);
                    $scope.filtro.show_dropdown_periodo = true;
                    break;
                case 'mes':
                    $scope.filtro.data_inicial = moment().startOf('month').format(f_submit);
                    $scope.filtro.data_final = moment().endOf('month').format(f_submit);
                    $scope.filtro.show_dropdown_periodo = true;
                    break;
                case '15dias':
                    $scope.filtro.data_inicial = moment().subtract(15, 'days').format(f_submit);
                    $scope.filtro.data_final = moment().format(f_submit);
                    $scope.filtro.show_dropdown_periodo = true;
                    break;
                case '30dias':
                    $scope.filtro.data_inicial = moment().subtract(30, 'days').format(f_submit);
                    $scope.filtro.data_final = moment().format(f_submit);
                    $scope.filtro.show_dropdown_periodo = true;
                    break;
                case 'input_periodo':
                    $scope.filtro.show_dropdown_periodo = false;
                    break;
                case 'periodo':
                   $scope.filtro.show_dropdown_periodo = true;
                    break;
                case 'todos':
                    $scope.filtro.data_inicial = '';
                    $scope.filtro.data_final = '';
                    $scope.filtro.show_dropdown_periodo = true;
                    break;
            }
            if ($scope.filtro.periodo_selecionado == 'todos') {
                $scope.filtro.texto_periodo = 'Mostrar todos';
            } else {
                if ($scope.filtro.data_inicial == '' || $scope.filtro.data_final == '') {
                    $scope.selecionaPeriodo('hoje');
                }
                $scope.filtro.texto_periodo = moment($scope.filtro.data_inicial, "DD-MM-YYYY").format(f_view)+' - '+moment($scope.filtro.data_final, "DD-MM-YYYY").format(f_view);
            }
        };

        $scope.submitFiltroMovimentacao = function() {
            $scope.filtro.fornecedor_id = $('#fornecedor_id').val();
            $scope.carregaDadosMovimentacao();
        };

        $scope.toggleTotais = function() {
            $scope.show_totais = !$scope.show_totais;
            console.log($scope.show_totais);
        };


        $('body').on('keyup', '#js-filter-lote-profissional', function() {
            // Declare variables 
            var input, filter, table, tr, td, i;
            input = document.getElementById("js-filter-lote-profissional");
            filter = input.value.toLowerCase();
            table = document.getElementById("js-filter-lote-profissional_id");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[8]; // coluna 8
                if (td) {
                    if (td.innerHTML.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        });
    }
]);

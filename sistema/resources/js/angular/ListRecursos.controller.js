angular.module('baseApp').controller('ListRecursos', [
    "$scope",
    "$http",
    "$compile",
    "$timeout",
    function(
        $scope,
        $http,
        $compile,
        $timeout
    ) {

        $scope.REAL = value => currency(value, { symbol: '', decimal: ',', separator: '.' });
        $scope.geralOpen = false;
        $scope.secundarioOpen = false;
        $scope.targetSeletor = '';

        /**
         * Para links que não abrem no modal.
         */
        $scope.linkTableRow = function(url) {
            window.location.href = url;
        };

        /**
         * Confirma a geração da cópia antes de abrir o modal.
         * Ao confirmar o modal vai abrir editando o novo registro copiado.
         */
        $scope.buttonDuplicate = function(url) {
            if (confirm('Confirma geração de cópia deste registro?')) {
                $scope.openModalForm(url);
            }
            return false;
        };

        $scope.openModalForm = function(url, targetSeletor) {
            $scope.targetSeletor = targetSeletor;
            if (!$scope.geralOpen) {
                $scope.geralOpen = true;
                $scope.modalGeral(url);
                return;
            }
            if (!$scope.secundarioOpen) {
                $scope.secundarioOpen = true;
                $scope.modalSecundario(url);
                return;
            }
        };

        $scope.modalGeral = function(url) {
            $http({
                url: url,
                method: 'GET'
            }).then(function successCallback(response) {
                $scope.form = $compile(response.data)($scope);
                $('#modal_geral').find('.modal-body').html($scope.form);
                $('#modal_geral').modal('show');
                $timeout(function() {
                    $scope.carregaDadosFinanceiro();
                }, 1000);
            }, function errorCallback(response) {
                console.log(response);
            });
        };

        $scope.modalSecundario = function(url) {
            $http({
                url: url,
                method: 'GET'
            }).then(function successCallback(response) {
                $scope.form_secundario = $compile(response.data)($scope);
                $('#modal_secundario').find('.modal-body').html($scope.form_secundario);
                $('#modal_secundario').modal('show');
            }, function errorCallback(response) {
                console.log(response);
            });
        };

        $scope.modalHelp = function(content) {
            $('#modal_help').find('.modal-body').html($compile(content)($scope));
            $('#modal_help').modal('show');
        };

        $scope.submitForm = function(action) {
            let data;
            if ($scope.secundarioOpen) {
                data = $scope.form_secundario.serialize();
            } else {
                data = $scope.form.serialize();
            }
            $http({
                url: action,
                method: 'POST',
                data: data,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(response) {
                if (!response.data.model) {
                    window.location.reload();
                }
                if ($scope.targetSeletor) {
                    if ($($scope.targetSeletor).is('select')) {
                        // Padrão fk selectbox
                        $($scope.targetSeletor).append($('<option>', {value: response.data.model.id, text: response.data.model.nome}));
                        $($scope.targetSeletor).find('option:last').attr("selected", "selected");
                    } else {
                        // Tratamento para autocompletes
                        switch ($scope.targetSeletor) {
                            case '#cidade_id':
                                $('#cidade_id').val(response.data.model.id);
                                $('#cidade').val(response.data.model.nome);
                                break;
                            case '#fornecedor_id':
                                $('#fornecedor_id').val(response.data.model.id);
                                $('#fornecedor').val(response.data.model.nome);
                                break;
                            case '#lesao_id':
                                $('#lesao_id').val(response.data.model.id);
                                $('#lesao').val(response.data.model.nome);
                                break;
                            case '#membro_id':
                                $('#membro_id').val(response.data.model.id);
                                $('#membro').val(response.data.model.nome);
                                break;
                            case '#medico_id':
                                $('#medico_id').val(response.data.model.id);
                                $('#medico').val(response.data.model.nome);
                                break;
                            case '#convenio_id':
                                $('#convenio_id').val(response.data.model.id);
                                $('#convenio').val(response.data.model.nome);
                                if($('#convenio').hasClass('trigger_dados_convenio')) {
                                    // Se alterar algo aqui, altere também em admin.js > calcularTotalSessoes()
                                    var valor_sessao, sessoes, total;
                                    $('#trt_valor_sessao').val(response.data.model.valor);
                                    valor_sessao = $scope.REAL(response.data.model.valor).value;
                                    sessoes = $scope.REAL($('#trt_sessoes').val()).value;
                                    total = (valor_sessao * sessoes);
                                    total = $scope.REAL(total).format();
                                    $('#trt_total').val(total);
                                }
                                break;
                        }
                    }
                } else {
                    window.location.reload();
                }
                if ($scope.secundarioOpen) {
                    $scope.secundarioOpen = false;
                    $('#modal_secundario').modal('hide');
                } else {
                    $scope.geralOpen = false;
                    $('#modal_geral').modal('hide');
                }
            }, function errorCallback(response) {
                alert(response.data.message);
            });
        };

        $('#modal_geral').on('hidden.bs.modal', function (e) {
            $timeout(function() {
                $scope.geralOpen = false;
            }, 1);
        });

        $('#modal_secundario').on('hidden.bs.modal', function (e) {
            $timeout(function() {
                $scope.secundarioOpen = false;
            }, 1);
        });

        // FINANCEIRO FORM LANÇAMENTO

        $scope.carregaDadosFinanceiro = function() {
            var dados;
            if ($('#dados_form_lancamento').length) {
                dados = $('#dados_form_lancamento').attr('data-values');
                dados = angular.fromJson(dados);
                if(dados.id) {
                    $scope.fin = dados;
                } else {
                    $scope.fin = {
                        pagamento: '',
                        valor: '0,00',
                        desconto_taxa: '0,00',
                        juros_multa: '0,00',
                        valor_pago: '0,00'
                    };
                }
            }
        };

        $scope.calculaValorPago = function() {
            var valor = $scope.REAL($scope.fin.valor).value;
            var desconto_taxa = $scope.REAL($scope.fin.desconto_taxa).value;
            var juros_multa = $scope.REAL($scope.fin.juros_multa).value;
            var valor_pago = 0;
            //
            if (desconto_taxa > valor) {
                desconto_taxa = 0;
                $scope.fin.desconto_taxa = '0,00';
                alert('Descontos/Taxas de ver ser menor ou igual ao Valor');
                return;
            }
            valor_pago = ((valor + juros_multa) - desconto_taxa);
            $scope.fin.valor_pago = $scope.REAL(valor_pago).format();
        };

        $scope.calculaValor = function() {
            $scope.fin.desconto_taxa = 0;
            $scope.fin.juros_multa = 0;
            var desconto_taxa = 0;
            var juros_multa = 0;
            var valor = $scope.REAL($scope.fin.valor).value;
            var valor_pago = $scope.REAL($scope.fin.valor_pago).value;
            //
            if (valor_pago > valor) {
                juros_multa = Math.abs(valor - valor_pago);
            } else {
                desconto_taxa = Math.abs(valor_pago - valor);
            }
            $scope.fin.valor = $scope.REAL(valor).format();
            $scope.fin.desconto_taxa = $scope.REAL(desconto_taxa).format();
            $scope.fin.juros_multa = $scope.REAL(juros_multa).format();
        };

        $scope.resetPagamento = function() {
            if ($('input[name="pagamento"]').val() == '') {
                $scope.fin.desconto_taxa = '0,00';
                $scope.fin.juros_multa = '0,00';
                $scope.fin.valor_pago = $scope.fin.valor;
            }
        }
    }
]);

angular.module('baseApp').controller('FinanceiroFluxoController', [
    "$scope",
    "$http",
    "$httpParamSerializer",
    function(
        $scope,
        $http,
        $httpParamSerializer
    ) {
        $scope.dados = [];

        $scope.init = function(dados) {
            var meses = {};
            $scope.dados = JSON.parse(dados);
            angular.forEach($scope.dados, function(dados, recurso) {
                meses = dados.header.meses_nome;
                angular.forEach(dados.body, function(item) {
                    var canvas_id = '#chart_'+recurso+'_'+item.id;
                    var entradas = item.entrada.valores;
                    var saidas = item.saida.valores;
                    $scope.sparklineChart(canvas_id, meses, entradas, saidas);
                });
            });
        };

        $scope.sparklineChart = function(canvas_id, meses, entradas, saidas) {
            var spark3 = {
                chart: {
                    group: 'sparklines',
                    type: 'line',
                    height: 100,
                    sparkline: {
                        enabled: true
                    },
                },
                layout: {
                    padding: {
                        top: 10,
                        bottom: 10
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 2,
                },
                fill: {
                    opacity: 1,
                },
                series: [
                    { name: 'Entradas', data: entradas },
                    { name: 'Saídas', data: saidas }
                ],
                labels: meses,
                xaxis: {
                    type: 'category',
                },
                yaxis: {
                    min: 0
                },
                colors: ['#38a169', '#e53e3e']
                // title: {
                //     text: '$135,965',
                //     offsetX: 30,
                //     style: {
                //     fontSize: '24px',
                //     cssClass: 'apexcharts-yaxis-title'
                //     }
                // },
                // subtitle: {
                //     text: 'Profits',
                //     offsetX: 30,
                //     style: {
                //     fontSize: '14px',
                //     cssClass: 'apexcharts-yaxis-title'
                //     }
                // }
            };
            new ApexCharts(document.querySelector(canvas_id), spark3).render();
        };

        // $scope.makeChart = function(canvas_id, meses, entradas, saidas) {
        //     var options = {
        //         chart: {
        //             type: 'line',
        //             width: '100%',
        //             height: 100,
        //             sparkline: { enabled: true },
        //             toolbar: { show: false }
        //         },
        //         colors: ['#4299E1', '#F56565'],
        //         stroke: {
        //             curve: 'flat', width: 2, colors: ['#transparent']
        //         },
        //         theme: {
        //             monochrome: { enabled: true }
        //         },
        //         plotOptions: {
        //             // bar: { columnWidth: '80%' }
        //         },
        //         series: [
        //             { name: 'Entradas', data: entradas },
        //             { name: 'Saídas', data: saidas }
        //         ],
        //         labels: meses,
        //         dataLabels: {
        //             enabled: true,
        //             enabledOnSeries: undefined,
        //             // formatter: function (val, opts) {
        //             //     var t = moment.duration(parseInt(val), 'seconds');
        //             //     return t.asMinutes().toFixed(1)+' Min';
        //             // },
        //             textAnchor: 'middle',
        //             offsetX: 0,
        //             offsetY: 0,
        //             style: {
        //                 fontSize: '12px', colors: ['#070707']
        //             },
        //             dropShadow: { enabled: false }
        //         },
        //         legend: { position: 'top' },
        //         xaxis: {
        //             crosshairs: { width: 1 },
        //             labels: {
        //                 style: { fontSize: '12px' }
        //             }
        //         },
        //         yaxis: {
        //             labels: { show: false },
        //         },
        //         tooltip: {
        //             fixed: { enabled: false },
        //             x: { show: true },
        //             y: {
        //                 title: {
        //                     formatter: function (seriesName) {
        //                         return seriesName
        //                     }
        //                 }
        //             },
        //             marker: { show: false },
        //             noData: {
        //                 text: 'Sem dados para exibição',
        //                 align: 'center',
        //                 verticalAlign: 'middle',
        //                 offsetX: 0,
        //                 offsetY: 0,
        //                 style: {
        //                     fontSize: '12px',
        //                 }
        //             }
        //         }   
        //     };
        //     new ApexCharts(document.querySelector(canvas_id), options).render();
        // };
    }
]);

angular.module('baseApp').controller('ResultsController', [
    "$scope",
    "$http",
    "$httpParamSerializer",
    function(
        $scope,
        $http,
        $httpParamSerializer
    ) {
        $scope.data = [];

        $scope.init = function(data) {

            $scope.data = JSON.parse(data);
            // console.log($scope.data);

            $scope.sparklineChart(
                $scope.data.title,
                $scope.data.labels,
                $scope.data.series
            );

            // var meses = {};
            // $scope.dados = JSON.parse(dados);
            // angular.forEach($scope.dados, function(dados, recurso) {
            //     meses = dados.header.meses_nome;
            //     angular.forEach(dados.body, function(item) {
            //         var canvas_id = '#chart_'+recurso+'_'+item.id;
            //         var entradas = item.entrada.valores;
            //         var saidas = item.saida.valores;
            //         $scope.sparklineChart(canvas_id, meses, entradas, saidas);
            //     });
            // });
        };

        $scope.sparklineChart = function(title, labels, series) {

            var options = {
                chart: {
                    type: 'line',
                    height: 400,
                },
                title: {
                    text: title,
                    align: 'center',
                    style: {
                        fontSize:  '16px',
                        fontWeight:  'bold',
                    },
                },
                series: [{
                    name: 'Quantidade',
                    data: series,
                }],
                xaxis: {
                    categories: labels,
                },
                layout: {
                    padding: {
                        top: 10,
                        bottom: 20,
                    }
                },
                dataLabels: {
                    enabled: true,
                    enabledOnSeries: [1],
                    style: {
                        fontSize: '14px',
                    },
                },
                legend: {
                    show: true,
                    showForSingleSeries: true,
                    position: 'bottom',
                    horizontalAlign: 'center',
                },
                stroke: {
                    curve: 'smooth',
                    width: 3,
                },
                markers: {
                    size: 5,
                },
                colors: ['#c53030']
            }

            var chart = new ApexCharts(document.querySelector("#results_chart"), options);

            chart.render();

            return;

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
                    { name: 'Quantidade', data: series }
                ],
                labels: labels,
                xaxis: {
                    type: 'category',
                },
                yaxis: {
                    min: 0,
                    labels: {
                        minWidth: 50,
                    },
                },
                colors: ['#38a169']
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

            // new ApexCharts(document.querySelector(canvas_id), spark3).render();
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

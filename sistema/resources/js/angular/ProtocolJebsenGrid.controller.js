angular.module('baseApp').controller('ProtocolJebsenGridController', [
    "$scope",
    function(
        $scope
    ) {
        $scope.init = function(testData) {
            $scope.testData = JSON.parse(testData); 
            angular.forEach($scope.testData, function(item, param_id) {
                $scope.makeChart(param_id, item);
            });
        };
        $scope.makeChart = function(param_id, item) {
            var options = {
                chart: {
                    type: 'bar',
                    width: '100%',
                    height: 220,
                    sparkline: { enabled: false },
                    toolbar: { show: false }
                },
                colors: ['#F56565', '#4299E1'],
                stroke: {
                    curve: 'flat', width: 2, colors: ['#transparent']
                },
                theme: {
                    monochrome: { enabled: true }
                },
                plotOptions: {
                    bar: { columnWidth: '80%' }
                },
                series: [
                    { name: 'Direita (Col.1)', data: item.time_right },
                    { name: 'Esquerda (Col.2)', data: item.time_left }
                ],
                labels: item.testdates,
                dataLabels: {
                    enabled: true,
                    enabledOnSeries: undefined,
                    formatter: function (val, opts) {
                        var t = moment.duration(parseInt(val), 'seconds');
                        return t.asMinutes().toFixed(1)+' Min';
                    },
                    textAnchor: 'middle',
                    offsetX: 0,
                    offsetY: 0,
                    style: {
                        fontSize: '12px', colors: ['#070707']
                    },
                    dropShadow: { enabled: false }
                },
                legend: { position: 'top' },
                xaxis: {
                    crosshairs: { width: 1 },
                    labels: {
                        style: { fontSize: '12px' }
                    }
                },
                yaxis: {
                    labels: { show: false },
                },
                tooltip: {
                    fixed: { enabled: false },
                    x: { show: true },
                    y: {
                        title: {
                            formatter: function (seriesName) {
                                return seriesName
                            }
                        }
                    },
                    marker: { show: false },
                    noData: {
                        text: 'Sem dados para exibição',
                        align: 'center',
                        verticalAlign: 'middle',
                        offsetX: 0,
                        offsetY: 0,
                        style: {
                            fontSize: '12px',
                        }
                    }
                }   
            };
            new ApexCharts(document.querySelector("#chart_jebsen_"+param_id), options).render();
        };
    }
]);

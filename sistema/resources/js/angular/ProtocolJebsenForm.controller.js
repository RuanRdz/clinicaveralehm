angular.module('baseApp').controller('ProtocolJebsenFormController', [
    "$scope",
    "$interval",
    function(
        $scope,
        $interval
    ) {
        /* Variáveis Temporizador */
        $scope.tempo_total = '00:00:00';
        $scope.counter_total = 0;
        $scope.run_clock = null;
        $('.time_jebsen').mask('99:99:99');
        $scope.clearInput = function(inputID) {
            $('#'+inputID).val('');
            $scope.stopTimer();
            $scope.resetTimerTotal();
        };
        /* TEMPORIZADOR */
        $scope.startTimer = function(inputID) {
            if($scope.run_clock == null) {
                $scope.resetTimerTotal();
                $scope.run_clock = $interval(function() {
                    var current_time = moment()
                        .hour(0)
                        .minute(0)
                        .second($scope.counter_total++)
                        .format('HH:mm:ss');
                    $('#'+inputID).val(current_time);
                }, 1000);
            } else {
                $scope.stopTimer();
            }
        };
        $scope.stopTimer = function() {
            $interval.cancel($scope.run_clock);
            $scope.run_clock = null;
        };
        $scope.resetTimerTotal = function() {
            $scope.counter_total = 0;
        };
        $('.btn_time_jebsen').on('click', function(e) {
            // e.stopPropagation();
            // e.preventDefault();
            var btn = $(this);
            if (btn.find('i.fa').hasClass('fa-play')) {
                $('.btn_time_jebsen').not(btn).attr('disabled', true);
                $('.time_jebsen').attr('disabled', true);
                $('#btn-submit-protocol').attr('disabled', true);
            } else {
                $('.btn_time_jebsen').removeAttr('disabled');
                $('.time_jebsen').removeAttr('disabled');
                $('#btn-submit-protocol').removeAttr('disabled');
            }
            btn.find('i.fa')
                .toggleClass('fa-play')
                .toggleClass('fa-stop')
                .toggleClass('text-muted')
                .toggleClass('text-primary');
        });
    }
]);

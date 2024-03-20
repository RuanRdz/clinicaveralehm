

<div 
    ng-controller="ProtocolJebsenGridController as controller"
    ng-init="init('{{htmlspecialchars(json_encode($testData['grid']), ENT_QUOTES, 'UTF-8')}}')">

    <div class="report table-responsive">
        <table class="table">
            <thead class="title">
                <tr>
                    <th class="bg-gray" colspan="3">
                        @include('protocols.tests.header-report')
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($params as $param)
                    <tr>
                        <td style="width: 250px;">
                            <strong>{{$param->task}}</strong>
                        </td>
                        <td style="min-width: 400px;">
                            <div id="chart_jebsen_{{$param->id}}"></div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

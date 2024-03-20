<div class="col-xs-16 col-sm-16 col-md-9 col-lg-9">
    <div class="panel panel-default">
        <div class="panel-heading">SESSÕES E DATAS</div>
        <div class="panel-body">
            <p>
                <strong>Campo informativo sessões e datas:</strong>
                <br />
                <small>(Deixar em branco para usar Padrão)</small>
                <input
                    type="text"
                    name="info_sessoes"
                    value="{{ $t->info_sessoes }}"
                    class="form-control"
                    style="width: 100%;"
                />
            </p>
            <p>
                <strong>Padrão</strong>: Compareceu a {{ $num_sessoes }} sessões de Terapia Ocupacional
                no período de {{ $sessao_inicial }} a {{ $sessao_final }}
            </p>
        </div>
    </div>
</div>

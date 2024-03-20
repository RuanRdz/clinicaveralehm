
<div class="listagem-ateracoes-agenda" style="display: none;">
    <h4>Registro de alterações</h4>
    <div class="bg-white shadow-md">
        <div style="height: 300px; overflow: auto;">
            <table class="table table-hover table-bordered table-condensed">
                <tr>
                    <th>Ação</th>
                    <th style="width:120px;">Alterado em</th>
                </tr>
                @if ($tratamento)
                  @foreach ($tratamento->agendalogs()->orderBy('created_at', 'desc')->get() as $row)
                      <tr>
                          <td>{{ $row->descricao }}</td>
                          <td><small>{{ $row->created_at }}</small></td>
                      </tr>
                  @endforeach
                @endif
            </table>
        </div>
    </div>
</div>

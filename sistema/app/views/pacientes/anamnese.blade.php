
<thead>
	<tr>
		<th colspan="2">
			<strong class="py-5">Anamnese</strong>
		</th>
	</tr>
</thead>

<thead>
    <tr>
        <th colspan="2">
            <strong class="py-2 text-primary">Saúde</strong>
        </th>
    </tr>
</thead>
<tbody>
	<tr>
		<td>Peso</td>
		<td>{{ $paciente->peso }}</td>
	</tr>
	<tr>
		<td>Altura</td>
		<td>{{ $paciente->altura }}</td>
	</tr>
	<tr>
		<td>Já sofreu algum trauma ou lesão no passado fora a atual? Qual?</td>
		<td>{{ $paciente->lesao_anterior }}</td>
	</tr>
	<tr>
		<td>Já fez reabilitação. (onde)</td>
		<td>{{ $paciente->reabilitacao_anterior }}</td>
	</tr>
	<tr>
		<td>Número de sessões</td>
		<td>{{ $paciente->numero_sessoes }}</td>
	</tr>
	<tr>
		<td>Problemas de saúde pessoal / familiar</td>
		<td>{{ $paciente->doencas_associadas }}</td>
	</tr>
	<tr>
		<td>Uso de medicamentos</td>
		<td>{{ $paciente->medicamentos }}</td>
	</tr>
	<tr>
		<td>Tem alguma alergia?</td>
		<td>{{ $paciente->alergia }}</td>
	</tr>
	<tr>
		<td>Fumante</td>
		<td>{{ Paciente::$SN[$paciente->fumante] }}</td>
	</tr>
	<tr>
		<td>Uso de drogas. (Quais)</td>
		<td>{{ $paciente->uso_drogas }}</td>
	</tr>
	<?php /*
	<tr>
		<td>Hobby</td>
		<td>{{ $paciente->hobby }}</td>
	</tr>
	*/ ?>
	<tr>
		<td>Possui alguma atividade esportiva de lazer (futebol, lutas, academia, etc)?</td>
		<td>{{ $paciente->atividade_esportiva }}</td>
	</tr>
	<tr>
		<td>Outros</td>
		<td>{{ $paciente->outros }}</td>
	</tr>
</tbody>

<thead>
    <tr>
        <th colspan="2">
            <strong class="py-2 text-primary">
                Informações complementares
            </strong>
        </th>
    </tr>
</thead>
<tbody>
	<tr>
		<td style="width: 60%;">Tempo de empresa</td>
		<td>{{ $paciente->tempo_empresa }}</td>
	</tr>
	<tr>
		<td>Gosta de trabalhar na empresa</td>
		<td>{{ Paciente::$SN[$paciente->gosta_trabalhar_empresa] }}</td>
	</tr>
	<tr>
		<td>Aspectos positivos da empresa</td>
		<td>{{ $paciente->aspectos_positivos_empresa }}</td>
	</tr>
	<tr>
		<td>Aspectos negativos da empresa</td>
		<td>{{ $paciente->aspectos_negativos_empresa }}</td>
	</tr>
	<tr>
		<td>Nº de empresas que já trabalhou</td>
		<td>{{ $paciente->num_empresas_trabalhou }}</td>
	</tr>
	<tr>
		<td>Faz trabalhos extras? Que tipo?</td>
		<td>{{ $paciente->trabalhos_extras }}</td>
	</tr>
	<?php /*
	<tr>
		<td>Pretende adquirir bens</td>
		<td>{{ Paciente::$SN[$paciente->adquirir_bens] }}</td>
	</tr>
	*/ ?>
	<tr>
		<td>Acidente de trabalho</td>
		<td>{{ Paciente::$SN[$paciente->acidente_trabalho] }}</td>
	</tr>
	<tr>
		<td>Já sofreu acidente de trânsito ('moto ou carro')?</td>
		<td>{{ $paciente->acidente_transito }}</td>
	</tr>
	<tr>
		<td>Utiliza motocicleta como meio de transporte?</td>
		<td>{{ Paciente::$SN[$paciente->utiliza_motocicleta] }}</td>
	</tr>
	<tr>
		<td>Tempo de afastamento</td>
		<td>{{ $paciente->tempo_afastamento }}</td>
	</tr>
	<tr>
		<td>Já pegou atestado</td>
		<td>{{ Paciente::$SN[$paciente->pegou_atestado] }}</td>
	</tr>
	<tr>
		<td>Houve afastamento anterior e em que condições ocorreu</td>
		<td>{{ $paciente->afastamento_anterior }}</td>
    </tr>
</tbody>

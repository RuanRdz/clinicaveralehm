
<thead>
	<tr>
		<th colspan="2">
			<strong class="py-5">Dados Pessoais</strong>
		</th>
	</tr>
</thead>

<tbody>
	<tr>
		<td>RG</td>
		<td>{{ $paciente->rg }}</td>
	</tr>
	<tr>
		<td>CPF</td>
		<td>{{ $paciente->cpf }}</td>
    </tr>
	<tr>
		<td>Escolaridade</td>
		<td>{{ Paciente::$escolaridade[$paciente->escolaridade] }}</td>
    </tr>
    <tr>
		<td>Profissão</td>
		<td>
            {{ $paciente->profissao }}
		</td>
    </tr>
	<tr>
		<td>Empresa</td>
		<td>
			{{ $paciente->empresa }}
		</td>
    </tr>
	<tr>
		<td>Data nascimento</td>
		<td>{{ $paciente->nascimento }} ({{ $paciente->idade }} anos)</td>
	</tr>
	<tr>
		<td>Naturalidade</td>
		<td>{{ $paciente->naturalidade }}</td>
	</tr>
	<tr>
		<td>Etnia</td>
		<td>{{ $paciente->etnia }}</td>
	</tr>
	<tr>
		<td>Sexo</td>
		<td>{{ Paciente::$sexo[$paciente->sexo] }}</td>
	</tr>
	<tr>
		<td>Orientação sexual</td>
		<td>{{ $paciente->orientacao_sexual }}</td>
	</tr>
	<tr>
		<td>Estado civil</td>
		<td>{{ $paciente->estado_civil }}</td>
	</tr>
	<tr>
		<td>Religião</td>
		<td>{{ $paciente->religiao }}</td>
    </tr>
	<tr>
		<td>Carteirinha</td>
		<td>{{ $paciente->carteirinha }}</td>
	</tr>
	<tr>
		<td>Validade carteirinha</td>
		<td>{{ $paciente->validadecarteirinha }}</td>
	</tr>
</tbody>

<thead>
    <tr>
        <th colspan="2">
            <strong class="py-2 text-primary">Contato</strong>
        </th>
    </tr>
</thead>
<tbody>
    <tr>
		<td>E-mail</td>
		<td>{{ $paciente->email }}</td>
	</tr>
	<tr>
		<td style="width: 40%;">F. Celular</td>
		<td>
			@if (!empty($paciente->fone_celular))
				{{ $paciente->fone_celular }}
				@if (!empty($paciente->operadora_celular))
					({{ $paciente->operadora_celular }})
				@endif
			@endif
		</td>
	</tr>
	<tr>
		<td>F. Residencial</td>
		<td>
			@if (!empty($paciente->fone_residencial))
				{{ $paciente->fone_residencial }}
			@endif
		</td>
	</tr>
	<tr>
		<td>F. Empresa</td>
		<td>
			@if (!empty($paciente->fone_comercial))
				{{ $paciente->fone_comercial }}
			@endif
		</td>
	</tr>
	<tr>
		<td>F. Recado</td>
		<td>
			@if (!empty($paciente->fone_recado))
				{{ $paciente->fone_recado }}
			@endif
		</td>
    </tr>
	<tr>
		<td>Endereço</td>
		<td>
			{{ $paciente->endereco }} 
			CEP: {{ $paciente->cep }} 
			@if ($paciente->cidade)
				&nbsp;-&nbsp;
				{{ $paciente->cidade->nome.' - '.$paciente->cidade->estado_uf }}
			@endif
		</td>
    </tr>
</tbody>

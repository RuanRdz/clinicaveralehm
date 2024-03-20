<?php

/**
 * Format Timestamp to Brazilian date
 * @param  [timestamp] $timestamp
 * @return string
 */
function timestampToBr($timestamp, $include_hours = false)
{
	if (!$timestamp) {
		return null;
	}

	if ($include_hours){
		return date('d-m-Y H:i:s', strtotime($timestamp));
	}

	return date('d-m-Y', strtotime($timestamp));
}

function brDateToDatabase($date)
{
	if($date){
		$date = new DateTime($date);
		return $date->format('Y').'-'.$date->format('m').'-'.$date->format('d');
	} else {
		return null;
	}
}

function diaBr($en_day)
{
	$days = array(
		'Sun' => 'Dom',
		'Mon' => 'Seg',
		'Tue' => 'Ter',
		'Wed' => 'Qua',
		'Thu' => 'Qui',
		'Fri' => 'Sex',
        'Sat' => 'Sáb',

		'Sunday' => 'Domingo',
		'Monday' => 'Segunda',
		'Tuesday' => 'Terça',
		'Wednesday' => 'Quarta',
		'Thursday' => 'Quinta',
		'Friday' => 'Sexta',
		'Saturday' => 'Sábado',
	);
	return isset($days[$en_day]) ? $days[$en_day] : $en_day;
}

/** De Float para Real */
function valorBr($decimal)
{
	($decimal)
	? $result = number_format($decimal, 2, ',', '.')
	: $result = '';
	return $result;
}

/** De Real para Float */
function valorFloat($real)
{
    if (empty($real)) {
        return '';
    }
    $source = array('.', ',');
    $replace = array('', '.');
    $real = str_replace($source, $replace, trim($real));

	return number_format($real, 2, '.', '');
}

function horarios()
{
	return [
	    '' => '',
		// AM
		'07:00:00' => '7h', '07:30:00' => '7h30',
		'08:00:00' => '8h', '08:30:00' => '8h30',
		'09:00:00' => '9h', '09:30:00' => '9h30',
		'10:00:00' => '10h','10:30:00' => '10h30',
		'11:00:00' => '11h','11:30:00' => '11h30',
		'12:00:00' => '12h',
		// PM
		'12:30:00' => '12h30',
		'13:00:00' => '13h','13:30:00' => '13h30',
		'14:00:00' => '14h','14:30:00' => '14h30',
		'15:00:00' => '15h','15:30:00' => '15h30',
		'16:00:00' => '16h','16:30:00' => '16h30',
		'17:00:00' => '17h','17:30:00' => '17h30',
		'18:00:00' => '18h','18:30:00' => '18h30',
		'19:00:00' => '19h','19:30:00' => '19h30',
		'20:00:00' => '20h','20:30:00' => '20h30',
		'21:00:00' => '21h','21:30:00' => '21h30',
		'22:00:00' => '22h',
		'23:00:00' => '23h',
	];
}

function horariosDestaque()
{
	$horarios = [];
	foreach (horarios() as $key => $value) {
		switch ($value) {
			case '7h': case '7h30': case '12h': case '12h30': case '13h': 
			case '19h': case '19h30': case '20h': case '20h30': 
			case '21h': case '21h30': case '22h': case '23h':
				$horarios[$value] = false;
				break;
			
			default:
				$horarios[$value] = true;
				break;
		}
	}
	return $horarios;
}

/**
 * Fornece uma array com os itens filtrados nos selectbox dos
 * @return array
 */
function filtro()
{
	$data_painel  = date('d-m-Y');
	$data_inicial = date('d-m-Y');

    $filtro = [
        'data_painel'           => $data_painel,
        'data_inicial'          => $data_inicial,
        'data_final'            => '',
        'terapeuta_id' 			=> '',
        'tratamentotipo_id' 	=> '',
        'tratamentosituacao_id' => '',
        'lesao_id'				=> '',
        'membro_id' 			=> '',
        'medico_id' 			=> '',
        'convenio_id' 			=> '',
        'conveniotipo_id' 	    => '',
        'agendasituacao_id' 	=> '',
        'filtro_sessao' 		=> '',
        'genero' 				=> '',
        'busca' 			    => '',
    ];

	if (Request::isMethod('post') || ! Session::get('filtro')) {

		$filtro['data_painel'] = Input::has('data_painel')
			? brDateToDatabase(Input::get('data_painel', $data_painel))
			: brDateToDatabase($data_painel);

		$filtro['data_inicial'] = Input::has('data_inicial')
			? brDateToDatabase(Input::get('data_inicial', $data_inicial))
			: brDateToDatabase($data_inicial);

		if (Input::has('data_final')) {
			$data_final = brDateToDatabase(Input::get('data_final'));
		} else {
			$date = strtotime('+5 days', strtotime($filtro ['data_inicial']));
    		$data_final = date("Y-m-d", $date);
		}
		$filtro['data_final'] = $data_final;

        $filtro['terapeuta_id']          = Input::has('terapeuta_id') ? Input::get('terapeuta_id') : null;
        $filtro['tratamentotipo_id'] 	 = Input::has('tratamentotipo_id') ? Input::get('tratamentotipo_id') : null;
        $filtro['tratamentosituacao_id'] = Input::has('tratamentosituacao_id') ? Input::get('tratamentosituacao_id') : null;
        $filtro['lesao_id']				 = Input::has('lesao_id') ? Input::get('lesao_id') : null;
        $filtro['membro_id'] 			 = Input::has('membro_id') ? Input::get('membro_id') : null;
        $filtro['medico_id'] 			 = Input::has('medico_id') ? Input::get('medico_id') : null;
        $filtro['convenio_id'] 			 = Input::has('convenio_id') ? Input::get('convenio_id') : null;
        $filtro['conveniotipo_id'] 	     = Input::has('conveniotipo_id') ? Input::get('conveniotipo_id') : null;
        $filtro['agendasituacao_id'] 	 = Input::has('agendasituacao_id') ? Input::get('agendasituacao_id') : null;
        $filtro['filtro_sessao'] 		 = Input::has('filtro_sessao') ? Input::get('filtro_sessao') : null;
        $filtro['genero'] 				 = Input::has('genero') ? Input::get('genero') : 'atendimento';
        $filtro['busca'] 			     = Input::has('busca') ? Input::get('busca') : null;

        Session::put('filtro', $filtro);
		return $filtro;
    }

    if (empty(Session::get('filtro'))) {
        return $filtro;
    }

    return Session::get('filtro');
}

function formatBytes($size, $precision = 2)
{
    if (! $size || $size == 0) {
        return 0;
    }

    $base = log($size, 1024);
    $suffixes = array('', 'K', 'M', 'G', 'T');

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}
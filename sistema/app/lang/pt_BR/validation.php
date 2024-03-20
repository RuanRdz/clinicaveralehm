<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/
	"recaptcha" 		   => 'O código reCaptcha não está correto.',
	"accepted"             => ":attribute deve ser aceito.",
	"active_url"           => ":attribute não é uma URL válida.",
	"after"                => ":attribute deve ser uma data posterior a :date.",
	"alpha"                => ":attribute deve conter apenas letras.",
	"alpha_dash"           => ":attribute may only contain letters, numbers, and dashes.",
	"alpha_num"            => ":attribute may only contain letters and numbers.",
	"array"                => ":attribute must be an array.",
	"before"               => ":attribute deve ser uma data anterior a :date.",
	"between"              => array(
		"numeric" => ":attribute must be between :min and :max.",
		"file"    => ":attribute must be between :min and :max kilobytes.",
		"string"  => ":attribute must be between :min and :max characters.",
		"array"   => ":attribute must have between :min and :max items.",
	),
	"confirmed"            => ":attribute confirmation does not match.",
	"date"                 => ":attribute não é válida.",
	"date_format"          => ":attribute does not match the format :format.",
	"different"            => ":attribute and :other deve be different.",
	"digits"               => ":attribute must be :digits digits.",
	"digits_between"       => ":attribute must be between :min and :max digits.",
	"email"                => ":attribute deve conter um endereço válido.",
	"exists"               => "The selected :attribute is invalid.",
	"image"                => ":attribute deve ser uma imagem.",
	"in"                   => "The selected :attribute is invalid.",
	"integer"              => ":attribute deve ser um número inteiro.",
	"ip"                   => ":attribute must be a valid IP address.",
	"max"                  => array(
		"numeric" => ":attribute não deve maior que :max.",
		"file"    => ":attribute não deve maior que :max kilobytes.",
		"string"  => ":attribute não deve maior que :max characters.",
		"array"   => ":attribute não deve maior que :max items.",
	),
	"mimes"                => ":attribute must be a file of type: :values.",
	"min"                  => array(
		"numeric" => ":attribute deve conter ao menos :min unidade(s).",
		"file"    => ":attribute deve conter ao menos :min kilobytes.",
		"string"  => ":attribute deve conter ao menos :min caracteres.",
		"array"   => ":attribute deve conter ao menos :min itens.",
	),
	"not_in"               => "O selected :attribute is invalid.",
	"numeric"              => ":attributedeve ser numérico.",
	"regex"                => ":attribute format is invalid.",
	"required"             => ":attribute é requerido.",
	"required_if"          => ":attribute field is required when :other is :value.",
	"required_with"        => ":attribute field is required when :values is present.",
	"required_with_all"    => ":attribute field is required when :values is present.",
	"required_without"     => ":attribute field is required when :values is not present.",
	"required_without_all" => ":attribute field is required when none of :values are present.",
	"same"                 => ":attribute and :other deve match.",
	"size"                 => array(
		"numeric" => ":attribute must be :size.",
		"file"    => ":attribute must be :size kilobytes.",
		"string"  => ":attribute must be :size characters.",
		"array"   => ":attribute must contain :size items.",
	),
	"unique"               => ":attribute já está em uso.",
	"url"                  => "Formato :attribute é inválido.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message',
		),
		'scale_id' => array(
			'required' => 'Selecione a Escala',
		),
		'type_id' => array(
			'required' => 'Selecione o Tipo',
		),
		'side_id' => array(
			'required' => 'Selecione o Lado',
		),
	),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(
        'num_sessoes' => 'Número de sessões'
    ),
);

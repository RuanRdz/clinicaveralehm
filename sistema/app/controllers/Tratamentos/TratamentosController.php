<?php

class TratamentosController extends \BaseController {

    public function __construct() {

        // User::allowedCredentials(array(10, 20, 30));
    }

    public function index(){

        $filtro      = filtro();
        $tratamentos = Tratamento::listagem($filtro);

        Session::get('workspace_id')
            ? $terapeutas = array('' => '') + Workspace::terapeutas(Session::get('workspace_id'))->lists('fullName', 'id')
            : $terapeutas = array('' => '');

        $tipos     = array('' => '') + Tratamentotipo::lists('nome', 'id');
        $situacoes = array('' => '') + Tratamentosituacao::lists('nome', 'id');
        $lesoes    = array('' => '') + Tratamento::with('lesao')
            ->select('lesao_id', 'lesoes.nome')
            ->join('lesoes', 'lesoes.id', '=', 'lesao_id')
            ->distinct()
            ->orderBy('lesoes.nome')
            ->lists('lesoes.nome', 'lesao_id');

        $membros = array('' => '') + Tratamento::with('membro')
            ->select('membro_id', 'membros.nome')
            ->join('membros', 'membros.id', '=', 'membro_id')
            ->distinct()
            ->orderBy('membros.nome')
            ->lists('membros.nome', 'membro_id');

        $medicos = array('' => '') + Tratamento::with('medico')
            ->select('medico_id', 'medicos.nome')
            ->join('medicos', 'medicos.id', '=', 'medico_id')
            ->distinct()
            ->orderBy('medicos.nome')
            ->lists('medicos.nome', 'medico_id');

        $convenios = array('' => '') + Tratamento::with('convenio')
            ->select('convenio_id', 'convenios.nome')
            ->join('convenios', 'convenios.id', '=', 'convenio_id')
            ->distinct()
            ->orderBy('convenios.nome')
            ->lists('convenios.nome', 'convenio_id');

        $dados = compact(
            'filtro',
            'tratamentos', 'tipos',
            'lesoes', 'membros', 'medicos',
            'convenios', 'situacoes',
            'workspaces', 'terapeutas'
        );
        return View::make('tratamentos.index', $dados);
    }

    public function create($id){
        User::allowedCredentials(array(10, 30));
        $paciente     = Paciente::findOrFail($id);
        $tratamento   = new Tratamento;
        $workspaces   = array('' => 'Selecione') + Workspace::visiveis()->lists('nome', 'id');
        $terapeutas   = array('' => 'Selecione') + User::terapeutas()->lists('fullName', 'id');
        $tratamentotipos = Tratamentotipo::orderby('sequencia')->lists('nome', 'id');
        $convenios = array('' => 'Selecione') + Convenio::orderby('nome')->lists('nome', 'id');
        $complexidades = Complexidade::selectBox();
        $action       = route('tratamentosStore');
        $rules        = Tratamento::$rules_create;
        $compact      = array(
            'paciente',
            'tratamento',
            'workspaces',
            'terapeutas',
            'tratamentotipos',
            'convenios',
            'complexidades',
            'action',
            'rules',
        );
        return View::make('tratamentos.form-create', compact($compact));
    }

    public function show($id, $layout){

        $t = Tratamento::with('paciente')->findOrFail($id);
        switch ($layout) {
            case 'p': $view = 'tratamentos.guia-paciente'; break;
            case 'e': $view = 'tratamentos.guia-empresa'; break;
        }
        return View::make($view, compact('t'));
    }

    public function edit($id){
        User::allowedCredentials(array(10, 30));
        $tratamento   = Tratamento::findOrFail($id);
        $action       = route('tratamentosUpdate', array('id' => $tratamento->id));
        $rules        = Tratamento::$rules_update;
        $workspaces   = array('' => 'Selecione') + Workspace::visiveis()->lists('nome', 'id');
        $terapeutas   = array('' => 'Selecione') + User::terapeutas()->lists('fullName', 'id');
        $tratamentotipos = Tratamentotipo::orderby('sequencia')->lists('nome', 'id');
        $situacoes    = Tratamentosituacao::all()->toArray('id', 'nome');
        $lesao        = $tratamento->lesao_id ? $tratamento->lesao->nome : null;
        $membro       = $tratamento->membro_id ? $tratamento->membro->nome : null;
        $medico       = $tratamento->medico_id ? $tratamento->medico->nome : null;
        $convenio     = $tratamento->convenio_id ? $tratamento->convenio->nome : null;
        $compact      = array(
            'tratamento',
            'action',
            'rules',
            'workspaces',
            'terapeutas',
            'tratamentotipos',
            'situacoes',
            'lesao',
            'membro',
            'medico',
            'convenio',
        );
        return View::make('tratamentos.form-edit', compact($compact))
            ->nest('button_fk_lesao', 'layouts.admin.add-button-fk', ['url' => route('lesoesCreate'), 'seletor' => '#lesao_id'])
            ->nest('button_fk_membro', 'layouts.admin.add-button-fk', ['url' => route('membrosCreate'), 'seletor' => '#membro_id'])
            ->nest('button_fk_medico', 'layouts.admin.add-button-fk', ['url' => route('medicosCreate'), 'seletor' => '#medico_id'])
            ->nest('button_fk_convenio', 'layouts.admin.add-button-fk', ['url' => route('conveniosCreate'), 'seletor' => '#convenio_id']);
    }

    public function store()
    {
        $data = array(
            'workspace_id' => Input::get('workspace_id'),
            'terapeuta_id' => Input::get('terapeuta_id'),
            'paciente_id' => Input::get('paciente_id'),
            'tratamentotipo_id' => Input::get('tratamentotipo_id'),
            'convenio_id' => Input::get('convenio_id'),
            'sessoes' => 1,
            'tratamentosituacao_id' => 1,
            'faturado' => 'N',
            // 'complexidade_id' => Input::get('complexidade_id'),
        );

        // Calcula o valor do tratamento
        $valores = DB::table('convenios')
            ->select(
                'valor AS valor_sessao',
                DB::raw('(limite_sessoes * valor) AS total'))
            ->where('id', Input::get('convenio_id'))
            ->first();

        $data['valor_sessao'] = valorBr($valores->valor_sessao);
        $data['total'] = valorBr($valores->total);

        $validator = Validator::make($data, Tratamento::$rules_create);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $tratamento = Tratamento::create($data);

        // Cria uma nova agenda em aberto
        // conforme número de sessões definidas
        // para o tratamento
        Agenda::novoTratamento($tratamento);

        # Adiciona a complexidade do paciente
        #### Não é mais feito pela secretária ####
        // $complexidade = new Complexidadepaciente;
        // $complexidade->complexidade_id = $data['complexidade_id'];
        // $complexidade->paciente_id = $data['paciente_id'];
        // $complexidade->save();

        $params = array('id' => $tratamento->paciente_id, 'id2' => $tratamento->id);
        return Redirect::route('painel', $params)
            ->with('success', 'Novo tratamento iniciado. Definir as datas da agenda.');
    }

    public function update($id){

        $tratamento = Tratamento::findOrFail($id);
        $data = Input::all();
        $data['paciente_id'] = $tratamento->paciente_id;

        if ($tratamento->liberado_para_edicao) {
            $validator = Validator::make($data, Tratamento::$rules_update);
            if ($validator->fails()){
                return Redirect::back()->withErrors($validator)->withInput();
            }
        }

        if ($tratamento->tratamentosituacao_id == 3) { // Tratamento cancelado...
            Agenda::cancelarAgendas($tratamento->id);
        }

        if (isset($data['duplicate_submit'])) { // Duplicar
            $data = $tratamento->toArray();
            unset($data['id']);
            unset($data['created_by']);
            unset($data['updated_by']);
            unset($data['created_at']);
            unset($data['updated_at']);
            unset($data['deleted_at']);
            unset($data['deleted_at']);
            $data['tratamentosituacao_id'] = 1;
            $data['sessoes'] = 1;
            $tratamento = Tratamento::create($data);
            Agenda::novoTratamento($tratamento);
            $msg = 'Cópia do Tratamento gerada';

        } else { // Atualizar

            if ($tratamento->liberado_para_edicao) {

                // Verifica se mudou o convênio e recalcula o valor do tratamento
                if ($tratamento->convenio_id != Input::get('convenio_id')) {
                    $valores = DB::table('convenios')
                        ->select(
                            'valor AS valor_sessao',
                            DB::raw('(limite_sessoes * valor) AS total'))
                        ->where('id', Input::get('convenio_id'))
                        ->first();
                    $data['valor_sessao'] = valorBr($valores->valor_sessao);
                    $data['total'] = valorBr($valores->total);
                }

                $tratamento->update($data);
                Agenda::atualizar($tratamento);
            } else {
                $tratamento->observacoes = $data['observacoes'];
                $tratamento->save();
            }
            $msg = 'Tratamento Atualizado';
        }

        $params = array('id' => $tratamento->paciente_id, 'id2' => $tratamento->id);
        return Redirect::route('painel', $params)
            ->with('success', $msg);
    }

    public function destroy($id){

        User::allowedCredentials(array(10));
        $tratamento = Tratamento::findOrFail($id);
        $tratamento->agendas()->delete();
        $tratamento->delete();
        $link_restore = link_to_route('tratamentosRestore', 'DESFAZER ?', array('id' => $tratamento->id));
        return Redirect::route('painel', array('id' => $tratamento->paciente_id))
            ->with('success', 'Registro removido! ('.$link_restore.').');
    }

    public function restore($id){

        User::allowedCredentials(array(10));
        $tratamento = Tratamento::withTrashed()->findOrFail($id);
        $tratamento->restore();
        $tratamento->agendas()->restore();
        return Redirect::route('painel', array('id' => $tratamento->paciente_id));
    }

    public function formAlterarValores($id)
    {
        $tratamento = Tratamento::findOrFail($id);
        $action = route('tratamentosUpdateAlterarValores', ['id' => $tratamento->id]);
        return View::make('painel.faturamento-form-valores-tratamento', compact(['tratamento', 'action']));
    }

    public function updateAlterarValores($id)
    {
        $tratamento = Tratamento::findOrFail($id);
        $validator = Validator::make($data = Input::all(), [
            'valor_sessao' => 'required',
            'total' => 'required',
        ]);
        if ($validator->fails()){
            return Response::json([
                'status' => 'error', 
                'message' => 'Erro de validação. Informe os campos requeridos.', 
                'errors' => $validator->errors()
            ], 422);
        }

        $tratamento->valor_sessao = $data['valor_sessao'];
        $tratamento->total = $data['total'];
        $tratamento->save();

        return Response::json([
            'status' => 'success', 
            'message' => 'Cadastro atualizado.',
            'model' => null
        ], 200);
    }

    public function showLaudo($id){

        $t  = Tratamento::findOrFail($id);
        $lc = array('Y' => 'Sim', 'N' => 'Não');
        return View::make('tratamentos.laudo', compact('t', 'lc'));
    }
    public function editLaudo($id){

        $t  = Tratamento::findOrFail($id);
        $lc = array('Y' => 'Sim', 'N' => 'Não');
        return View::make('tratamentos.laudo-form', compact('t', 'lc'));
    }
    public function updateLaudo($id){

        $tratamento                    = Tratamento::findOrFail($id);
        $tratamento->laudo             = Input::get('laudo');
        $tratamento->laudo_certificado = Input::get('laudo_certificado');
        $tratamento->save();
        return Redirect::route('tratamentosLaudo', array('id' => $tratamento->id))
            ->with('success', 'Cadastro atualizado.');
    }

    public function sendEmail($id){

        $t = Tratamento::with('paciente')->findOrFail($id);
        $display = json_decode(Input::get('display'));
        $s = Sistema::parametros();
        $subject = $s['empresa'].' - Guia '.$t->paciente->nome;
        if ($t->paciente->email) {
            
            try {
            
                Mail::send('tratamentos.guia-paciente-email', array('t' => $t, 'display' => $display), function($message) use ($t, $s, $subject) {
                    $message
                        ->to($t->paciente->email, $t->paciente->nome)
                        ->replyTo([$s['email'], Config::get('mail.from.address')], $subject)
                        ->bcc(Config::get('mail.from.address'))
                        ->subject($subject)
                        ->setReadReceiptTo(Config::get('mail.from.address'));
                });
                
                Agendalog::registrarEmailsEnviadosGuia($t);
            
            
                return Response::json([
                    'status' => 'success', 
                    'message' => 'E-mail enviado.'
                ], 200);
                
            } catch(\Exception $e) {
                return Response::json([
                    'status' => 'fail', 
                    'message' => $e->getMessage()
                ], 422);    
            }
            
        }
        return Response::json([
            'status' => 'fail', 
            'message' => 'O E-mail do paciente não foi informado no cadastro. Envio cancelado.'
        ], 422);
    }

    /**
     * Recebe o id de um workspace e devolve a lista de terapeutas
     */
    public function comboboxAtendimento($workspace_id)
    {
        $workspace  = Workspace::findOrFail($workspace_id);
        $terapeutas = Workspace::terapeutas($workspace->id)->toJson();
        return $terapeutas;
    }
}

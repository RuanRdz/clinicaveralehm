<?php

use app\models\Protocols\Speciality;

class PacientesController extends \BaseController {

    public function index(){

        User::allowedCredentials(array(10, 30));

        $current_char = Input::get('char', 'A');
        if (Request::isMethod('post')) {
            Session::put('filtro_pacientes', Input::all()+['char' => $current_char]);
        } else {
            Session::put('filtro_pacientes', ['char' => $current_char]);
        }
        $pacientes = Paciente::listagem(Session::get('filtro_pacientes'));

        $cidades = array('' => '');
        $cidades+= (array) Paciente::with('cidade')
            ->select('cidade_id', 'cidades.nome')
            ->join('cidades', 'cidades.id', '=', 'cidade_id')
            ->distinct()
            ->orderBy('cidades.nome', 'asc')
            ->lists('cidades.nome', 'cidade_id');

        $empresas = array('' => '');
        $empresas+= (array) Paciente::distinct()
            ->orderBy('empresa', 'asc')
            ->lists('empresa', 'empresa');

        $dados = array(
            'pacientes', 'cidades', 'empresas', 'current_char'
        );

        return View::make('pacientes.index', compact($dados));
    }

    /**
     * 
     * ACTION SUBSTUIDA PELO CONTROLLER PAINEL
     * 
     * 
     * @param  [int] $id  [id paciente]
     * @param  [int] $id2 [tratamento_id]
     * @return Response
     */
    /*
    public function tratamentos($id, $id2 = null){

        $paciente = Paciente::findOrFail($id);
        $listagem = $paciente->tratamentos()->orderBy('created_at', 'DESC')->get();
        if ($id2) {
            $tratamento = $paciente->tratamentos()->findOrFail($id2);
        } else {
            $tratamento = $paciente->tratamentos()->orderBy('created_at', 'DESC')->first();
        }

        if ($tratamento === null) {
          return View::make('tratamentos.paciente.index-new', compact('paciente'));
        }

        $dados = compact(
            'paciente', 'listagem', 'tratamento'
        );

        // Faturamento
        if ($tratamento) {
            $total               = $tratamento->total;
            $total_lancado       = $tratamento->financeiro()->sum('valor');
            $saldo_a_lancar      = $total - $total_lancado;
            $lancamentos_a_pagar = $tratamento->financeiro()->whereNull('pagamento')->sum('valor');
            $total_pago          = $total_lancado - $lancamentos_a_pagar;
        } else {
            $total               = null;
            $total_lancado       = null;
            $saldo_a_lancar      = null;
            $lancamentos_a_pagar = null;
            $total_pago          = null;
        }
        $dadosFaturamento = compact(
            'tratamento', 'total',
            'total_lancado', 'saldo_a_lancar',
            'lancamentos_a_pagar', 'total_pago'
        );
        // /Faturamento

        return View::make('tratamentos.paciente.index')
            ->with('paciente', $paciente)
            ->nest('viewListagem', 'tratamentos.paciente.listagem', $dados)
            ->nest('viewInformacoes', 'tratamentos.paciente.informacoes', $dados)
            ->nest('viewAgenda', 'tratamentos.paciente.agenda', $dados)
            ->nest('viewFaturamento', 'tratamentos.paciente.faturamento', $dadosFaturamento)
            ->nest('viewLogs', 'tratamentos.paciente.lista-logs', $dados)
            //->nest('viewComplexidade', 'tratamentos.paciente.complexidade', $dados)
            ->nest('viewProtocols', 'protocols.menu', $dados);
    }
    */

    /**
     * Show the form for creating a new paciente
     *
     * @return Response
     */
    public function create(){

        $paciente        = new Paciente;
        $paciente_cidade = '';
        $action          = route('pacientesStore');
        return View::make('pacientes.form', compact('paciente', 'paciente_cidade', 'action'));
    }

    /**
     * Display the specified paciente.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id){

        $paciente = Paciente::findOrFail($id);
        return View::make('pacientes.show', compact('paciente'));
    }

    /**
     * Show the form for editing the specified paciente.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id){

        $paciente        = Paciente::findOrFail($id);
        $paciente_cidade = $paciente->cidade_id ? $paciente->cidade->nome.' - '.$paciente->cidade->estado_uf : '';
        $action          = route('pacientesUpdate', array('id' => $paciente->id));
        return View::make('pacientes.form', compact('paciente', 'paciente_cidade', 'action'));
    }

    /**
     * Store a newly created paciente in storage.
     *
     * @return Response
     */
    public function store(){

        $validator = Validator::make($postData = Input::all(), Paciente::$rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $paciente = Paciente::create($postData);

        if ($postData['delete_foto'] != '1') {
            $file = Input::file('foto');
            if ($file){
                $foto = Paciente::uploadFoto($paciente);
                if ($foto) {
                    $paciente->foto = $foto;
                    $paciente->save();
                }
            }
        }

        return Redirect::route('painel', array('id' => $paciente->id))
            ->with('success', 'Paciente cadastrado com sucesso.');
    }

    /**
     * Update the specified paciente in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id){

        $paciente       = Paciente::findOrFail($id);
        $rules          = Paciente::$rules;
        // $rules['email'] = $rules['email'].$paciente->id;
        $rules['rg']    = $rules['rg'].','.$paciente->id;
        $rules['cpf']   = $rules['cpf'].','.$paciente->id;
        $validator      = Validator::make($postData = Input::all(), $rules);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }

        if ($postData['delete_foto'] == '1') {
            Paciente::deleteFotoAtual($paciente);
            $postData['foto'] = '';
        } else {
            $file = Input::file('foto');
            if ($file){
                $foto = Paciente::uploadFoto($paciente);
                if ($foto) {
                    $postData['foto'] = $foto;
                    Paciente::deleteFotoAtual($paciente);
                }
            } else {
                unset($postData['foto']);
            }
        }

        $paciente->update($postData);
        return Redirect::route('painel', array('id' => $paciente->id))
            ->with('success', 'Cadastro atualizado.');
    }

    /**
     * Updated via Ajax
     */
    public function updateAnamnese($id){

        $postData = Input::all();
        $paciente = Paciente::findOrFail($id);
        $paciente->update($postData);

        return $paciente;
    }

    /**
     * Remove the specified paciente from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){
        User::allowedCredentials(array(10));
        $paciente = Paciente::findOrFail($id);
        Paciente::deleteFotoAtual($paciente);
        $paciente->delete();
        return Redirect::back()->with('success', 'Registro removido.');
    }

    public function search(){

        $result = [];
        $term   = Input::get('term');
        $query  = Paciente::where('nome', 'LIKE', '%'.$term.'%')
            ->orWhere('cpf', 'LIKE', $term)
            ->orWhere('rg', 'LIKE', $term)
            ->orWhere('email', 'LIKE', $term)
            ->get();
        foreach ($query as $row) {
            $result[] = array(
                'id'    => $row->id,
                'label' => $row->nome,
                'route' => route('painel', array('id' => $row->id)),
            );
        }
        return Response::json($result);
    }

    public function arquivo($id){

        User::allowedCredentials(array(10, 20, 30));
        $paciente = Paciente::findOrFail($id);

        $arquivos = $this->getPatientFiles(
            'paciente_uploads_path',
            Config::get('app.paciente_uploads_path').$paciente->id
        );
        $arquivosAntigos = $this->getPatientFiles(
            'paciente_uploads_older_path',
            Config::get('app.paciente_uploads_older_path').$paciente->id
        );

        $arquivos  = array_merge($arquivos, $arquivosAntigos);

        return View::make('pacientes.arquivo', compact('paciente', 'arquivos'));
    }

    private function getPatientFiles($configPath, $diretorio)
    {
        $arquivos = [];
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        if (!is_dir($diretorio)) {
            mkdir($diretorio);
        }

        if ($handle = opendir($diretorio)) {
            while (false != ($filename = readdir($handle))) {
                if ($filename != "." && $filename != "..") {
                    $arquivos[] = array(
                        'filename' => $filename,
                        'config_path' => $configPath,
                        'type' => $finfo->file($diretorio.'/'.$filename),
                        'modified' => date ("d.m.Y H:i:s", filemtime($diretorio.'/'.$filename)),
                    );
                }
            }
            closedir($handle);
        }

        return $arquivos;
    }

    public function arquivoStore(){

        User::allowedCredentials(array(10, 20, 30));
        $id       = Input::get('id');
        $arquivo  = Input::file('arquivo');
        $nome     = $arquivo->getClientOriginalName();
        $extensao = $arquivo->getClientOriginalExtension();

        $nome     = pathinfo($nome, PATHINFO_FILENAME);
        $nome     = Str::slug($nome);
        $filename = $nome.'.'.$extensao;

        $extensoes = array(
            'gif', 'jpg', 'jpeg', 'png', 'pdf',
            'doc', 'docx', 'xls', 'xlsx', 'xlsm',
            'ppt', 'txt', 'csv', 'psd', 'xml',
            'htm', 'html', 'zip', 'rar', 'tar', 'sql'
        );
        if (in_array(strtolower($extensao), $extensoes)) {
            $upload = Input::file('arquivo')
                ->move(Config::get('app.paciente_uploads_path').$id, $filename);
        } else {
            return Redirect::back()
               ->with('fail', 'Envio de arquivos ".'.$extensao.'" não são permitidos.');
        }

        if($upload) {
            return Redirect::back()->with('success', 'Arquivo enviado.');
        } else {
            return Redirect::back()->with('fail', 'Não foi possível enviar o arquivo.');
        }
    }

    public function arquivodownload($id)
    {
        $paciente = Paciente::findOrFail($id);
        if (empty(Request::query('filename'))) {
            App::abort(404, 'Param required');
        }
        $path = Config::get('app.'.Request::query('config_path'));
        if (! Config::has('app.'.Request::query('config_path'))) {
            App::abort(404, 'Invalid param');
        }
        $file = $path.$paciente->id.'/'.Request::query('filename');
        if (! file_exists($file)) {
            App::abort(404, 'File not found');
        }

        return Response::download($file);
    }

    public function arquivodelete($id)
    {
        User::allowedCredentials(array(10));

        $paciente = Paciente::findOrFail($id);
        if (empty(Request::query('filename'))) {
            App::abort(404, 'Param required');
        }
        $path = Config::get('app.'.Request::query('config_path'));
        if (! Config::has('app.'.Request::query('config_path'))) {
            App::abort(404, 'Invalid param');
        }
        $file = $path.$paciente->id.'/'.Request::query('filename');
        if (! file_exists($file)) {
            App::abort(404, 'File not found');
        }
        unlink($file);

        return Redirect::back()->with('success', 'Registro removido.');
    }

    public function updateCelular($id) 
    {
        $dados = Paciente::findOrFail($id);
        $dados->fone_celular = Input::get('fone_celular');
        $dados->save();
        return $dados->fone_celular;
    }
}

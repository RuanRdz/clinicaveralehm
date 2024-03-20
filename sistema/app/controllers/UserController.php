<?php

class UserController extends BaseController {

    public function index() {

        User::allowedCredentials(array(10));
        $data = User::todos();
        $credentials = User::$credentials;
        return View::make('user.index', compact('data', 'credentials'));
    }

    public function create() {

        User::allowedCredentials(array(10));
        $action = route('userStore');
        $credentials = User::$credentials;
        return View::make('user.form-create', compact('action', 'credentials'));
    }

    public function store() {

        User::allowedCredentials(array(10));
        $post = Input::all();
        $post['email'] = Input::get('create_email');
        $validator = Validator::make($post, User::$rulesStore);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        } else {

            $data             = new User();
            $data->name       = filter_var(Input::get('create_name'), FILTER_SANITIZE_STRING);
            $data->last_name  = filter_var(Input::get('create_last_name'), FILTER_SANITIZE_STRING);
            $data->email      = filter_var(Input::get('create_email'), FILTER_VALIDATE_EMAIL);
            $data->crefito    = filter_var(Input::get('create_crefito'), FILTER_SANITIZE_STRING);
            $data->password   = Hash::make(Input::get('create_password'));
            $data->credential = filter_var(Input::get('create_credential'), FILTER_SANITIZE_NUMBER_INT);
            if (!isset(User::$credentials[$data->credential])) {
                $data->credential = 30;
            }
            if ($data->save()) {
                return Redirect::route('users')
                    ->with('success', 'Cadastro finalizado.');
            } else {
                return Redirect::route('userCreate')
                    ->with('fail', 'Um erro ocorreu ao cadastrar o usuário.');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id){

        $data = User::findOrFail($id);
        if (Auth::user()->isAdmin || Auth::user()->credential == 10) {
            if ($data->isAdmin && $data->id != Auth::user()->id) {
                echo htmlentities('Ação não autorizada. Acesse o sistema com o usuário '.$data->email.' para alterar as informações.', ENT_QUOTES, "UTF-8");
                die;
            }
        } else {
            if ($data->id != Auth::user()->id) {
                echo htmlentities('Ação não autorizada para esta Credencial de acesso.', ENT_QUOTES, "UTF-8");
                die;
            }
        }

        $action      = route('userUpdate', array('id' => $data->id));
        $credentials = User::$credentials;
        return View::make('user.form-edit', compact('data', 'action', 'credentials'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id){

        $data = User::findOrFail($id);
        if (Auth::user()->isAdmin || Auth::user()->credential == 10) {
            if ($data->isAdmin && $data->id != Auth::user()->id) {
                echo htmlentities('Ação não autorizada. Acesse o sistema com o usuário '.$data->email.' para alterar as informações.', ENT_QUOTES, "UTF-8");
                die;
            }
        } else {
            if ($data->id != Auth::user()->id) {
                echo htmlentities('Ação não autorizada para esta Credencial de acesso.', ENT_QUOTES, "UTF-8");
                die;
            }
        }

        $rules               = User::$rulesUpdate;
        $rules['edit_email'] = $rules['edit_email'].$data->id;
        $validator           = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        } else {
            $data->name      = filter_var(Input::get('edit_name'), FILTER_SANITIZE_STRING);
            $data->last_name = filter_var(Input::get('edit_last_name'), FILTER_SANITIZE_STRING);
            $data->email     = filter_var(Input::get('edit_email'), FILTER_VALIDATE_EMAIL);
            $data->crefito   = filter_var(Input::get('edit_crefito'), FILTER_SANITIZE_STRING);

            if (Auth::user()->credential == 10) {
                $data->credential = filter_var(Input::get('edit_credential'), FILTER_SANITIZE_NUMBER_INT);
            } else {
                $data->credential = Auth::user()->credential;
            }
            if (Input::get('edit_password')) {
                $data->password = Hash::make(Input::get('edit_password'));
            }

            $file = Input::file('assinatura');
            if ($file) {
                $filename  = 'assinatura_'.$data->id;
                $extension = Input::file('assinatura')->getClientOriginalExtension();
                $data->assinatura = $filename.'.'.$extension;
                $path = 'img/assinatura/';
                Input::file('assinatura')->move($path, $data->assinatura);
                $img = Image::make($path.$data->assinatura);
                $img->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($path.$data->assinatura, 100);
            }

            if ($data->save()) {
                return Redirect::back()
                    ->with('success', 'Cadastro atualizado.');
            } else {
                return Redirect::to('user/edit/'.$id)
                    ->with('fail', 'Um erro ocorreu ao cadastrar o usuário.');
            }
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){

        User::allowedCredentials(array(10));
        $user = User::findOrFail($id);
        if ($user->isAdmin) {
            echo htmlentities('Usuário restrito. Ação de remoção não disponível.', ENT_QUOTES, "UTF-8");
            die;
        }
        $user->delete();
        return Redirect::back()->with('success', 'Usuário removido.');
    }

    public function destroyAssinatura($id)
    {
        $user = User::findOrFail($id);

        if (!Auth::user()->isAdmin && $user->id != Auth::user()->id ) {
            echo htmlentities('Ação autorizada somente para o usuário dono do cadastro ou Administrador.', ENT_QUOTES, "UTF-8");
            die;
        }

        if (isset($user->assinatura)) {
            if (!empty($user->assinatura)) {
                if (file_exists('img/assinatura/'.$user->assinatura)) {
                    unlink('img/assinatura/'.$user->assinatura);
                    $user->assinatura = null;
                    $user->save();
                }
            }
        }

        return Redirect::back()->with('success', 'Assinatura removida.');
    }

    public function regeneratePassword($id){

        User::allowedCredentials(array(10));
        $user = User::findOrFail($id);
        if ($user->isAdmin) {
            echo htmlentities('Não é possível gerar senha para administrador.', ENT_QUOTES, "UTF-8");
            die;
        }

        $password = rand(11111, 99999);
        Session::flash('temp_password', $password);
        Session::flash('temp_password_name', $user->name);
        $user->password = Hash::make($password);
        $user->to_logout = 1;
        $user->save();

        return Redirect::back();
    }
}

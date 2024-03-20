<?php

class LoginController extends BaseController {

    public function index(){
        // var_dump(Hash::make('8RPzcVN2UUQYa4lG4F'));
        return View::make('user.login');
    }

    /**
     * Receive post from form login
     * @return [type] [description]
     */
    public function entrar() {

        $validate = Validator::make(Input::all(), array(
            'email' => 'required|email',
            'password' => 'required',
        ));
        if ($validate->fails()) {
            return Redirect::route('login')
                ->withErrors($validate)
                ->withInput();
        } else {
            $remember = (Input::has('remember')) ? true : false;
            $auth     = Auth::attempt(array(
                'email' => Input::get('email'),
                'password' => Input::get('password'),
            ), $remember);
            if ($auth) {
                Session::put('workspace_id', '');
                return Redirect::intended('/dashboard');
            } else {
                return Redirect::route('login')
                    ->with('fail', 'E-mail e/ou senha incorretos.');
            }
        }
    }

    /**
     * Session Logout
     * @return [type] [description]
     */
    public function sair() {

        Auth::logout();
        Session::flush();
        return Redirect::route('index')->with('success', 'Até logo!');
    }
}

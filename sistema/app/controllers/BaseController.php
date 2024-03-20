<?php

use Carbon\Carbon;

class BaseController extends Controller {

    public function __construct() {
        if (Auth::check()) {
            if (!Auth::user()->isAdmin) {
                // Senhas
                if (Auth::user()->to_logout == 1) {
                    $u = User::findOrFail(Auth::user()->id);
                    $u->to_logout = 0;
                    $u->save();

                    // @todo rever
                    // Auth::logout();
                    // App::abort(403, '<a href="/">Sua sessão expirou. Favor logar novamente</a>');
                }

                if (! App::isLocal()) {

                    // Horarios
                    $name = Auth::user()->fullName;
                    $dt = Carbon::now();
                    if (Auth::user()->credential == 20) { // Terapeuta
                        $start = $dt->copy()->startOfDay()->addHours(7)->addMinutes(45);
                        $end = $dt->copy()->startOfDay()->addHours(20);
                    } else { // Atendimento
                        $start = $dt->copy()->startOfDay()->addHours(7)->addMinutes(30);
                        $end = $dt->copy()->startOfDay()->addHours(19);
                    }
                    if ($dt->isSaturday() || $dt->isSunday()) {
                        $this->sendEmailExpediente($name, 'Tentativa de acesso fim de semana');
                        Auth::logout();
                        App::abort(403, 'Acesso indisponível: Expediente');
                    }
                    if ($dt->lessThan($start)) {
                        $this->sendEmailExpediente($name, 'Tentativa de acesso antes do expediente');
                        Auth::logout();
                        App::abort(403, 'Acesso indisponível: Expediente');
                    }
                    if ($dt->greaterThan($end)) {
                        $this->sendEmailExpediente($name, 'Tentativa de acesso após o expediente');
                        Auth::logout();
                        App::abort(403, 'Acesso indisponível: Expediente');
                    }
                }
            }
        }
    }

    private function sendEmailExpediente($name, $text)
    {
        if (! App::isLocal()) {
            Mail::send(
                'emails.expediente', array('name' => $name, 'text' => $text), function($message) {
                $message
                    ->to('veratomao@gmail.com', 'ALERTA SISTEMA')
                    ->subject('ALERTA SISTEMA');
            });
        }
    }
}

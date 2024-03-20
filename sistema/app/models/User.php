<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends \Eloquent implements UserInterface, RemindableInterface
{
    use UserTrait, RemindableTrait, SoftDeletingTrait;

    protected $dates  = array('deleted_at');
    protected $table  = 'users';
    protected $hidden = array(
        'password', 'create_password', 'edit_password', 'remember_token',
    );
    public static $rulesStore = array(
        'create_name' => 'required',
        'email' => 'required|email|unique:users',
        'create_password' => 'required|min:5',
        'create_credential' => 'in:10,20,30',
    );
    public static $rulesUpdate = array(
        'edit_name' => 'required',
        'edit_email' => 'required|email|unique:users,email,',
        'edit_password' => 'min:5',
        'edit_credential' => 'in:10,20,30',
        'assinatura' => 'mimes:jpg,jpeg,png'
    );
    protected $fillable = array(
        'name',
        'last_name',
        'email',
        'password',
        'crefito',
        'credential',
    );

    public static $credentials = array(
        20 => 'Terapeuta',
        30 => 'Atendimento',
        10 => 'Administrativo',
    );

    public function tarefas()
    {
        return $this->hasMany('Tarefa');
    }
    public function tarefasde()
    {
        return $this->hasMany('Tarefa', 'de_user_id');
    }
    public function tarefaspara()
    {
        return $this->hasMany('Tarefa', 'para_user_id');
    }



    public function tratamentos()
    {
        return $this->hasMany('Tratamento', 'terapeuta_id', 'id');
    }
    public function prontuario()
    {
        return $this->hasMany('Prontuario', 'terapeuta_id', 'id');
    }

    public function workspaces()
    {
        return $this->belongsToMany('Workspace');
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['name'].' '.$this->attributes['last_name'];
    }
    public function getFullNameCrefitoAttribute()
    {
        $name = $this->attributes['name'].' '.$this->attributes['last_name'];
        if ($this->attributes['crefito']) {
            $name .= ' - <small>CREFITO '.$this->attributes['crefito'].'</small>';
        }
        return trim(mb_strtoupper($name, 'UTF-8'));
    }

    public function getUrlAssinaturaAttribute()
    {
        if ($this->attributes['assinatura']) {
            return \URL::asset('img/assinatura/'.$this->attributes['assinatura']);
        }
        return null;
    }

    /**
     * Check if logged user is allowed to access a resource.
     *
     * @param [array] $credentials integers
     */
    public static function allowedCredentials($credentials, $layout = false)
    {
        if (
            !in_array(Auth::user()->credential, $credentials)
            &&
            !Auth::user()->isAdmin
        ) {
            if ($layout) {
                return false;
            } else {
                echo htmlentities('Ação não autorizada para sua Credencial de acesso.', ENT_QUOTES, "UTF-8");
                die;
            }
        }

        return true;
    }

    public static function canChangeRecord($id)
    {
        if (! Auth::user()->isAdmin) {
            if ($id != Auth::user()->id) {
                App::abort(403, 'Ação não autorizada para esta Credencial de acesso.');
            }
        }
        return true;
    }

    /**
     * Sobrescrito método all() para não mostrar o
     * usuário master do sistema quando outro usuário estiver acesssando.
     *
     * @return [type] [description]
     */
    public static function todos()
    {
        if (Auth::user()->id == 1) {
            return self::orderBy('name')->get();
        } else {
            return self::where('id', '!=', 1)->orderBy('name')->get();
        }
    }

    /**
     * Listagem de usuários para o inbox
     */
    public static function todosInbox()
    {
        if (Auth::user()->id == 1) {
            return self::with('tarefasde')
                ->orderBy('name')
                ->get();
        } else {
            $id = Auth::user()->id;
            return self::where('id', '!=', 1)
                ->orderBy('name')
                ->get();
        }
    }


    public static function terapeutas()
    {
        return self::withTrashed()
            ->where('credential', '=', 20)
            ->orderBy('name')
            ->get();
    }

    public static function workspacesVisiveisPorUsuario()
    {
        return self::findOrFail(Auth::user()->id)
            ->workspaces
            ->filter(function ($workspace) {
                return $workspace->visivel == 1 ? true : false;
            });
    }
}

<?php

namespace app\models\Protocols;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Test extends \Eloquent {

	protected $table = 'tests';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
		'protocol_id', 'namespace', 'controllers',
		'name', 'description', 'sort', 'enabled'
	];

	public static $rules = array(
		'protocol_id' => 'integer',
		'name' => 'required',
		'sort' => 'integer',
		'enabled' => 'integer',
	);


	// Relationship

	public function protocol()
    {
        return $this->belongsTo(Protocol::class);
    }


	// Mutators

    public function setProtocolIdAttribute($value)
    {
        $this->attributes['protocol_id'] = empty(trim($value)) ? null : $value;
    }

	public function setNamespaceAttribute($value)
	{
		$this->attributes['namespace'] = ucfirst(mb_strtolower(trim($value), 'UTF-8'));
    }
    
	public function setNameAttribute($value)
	{
		$this->attributes['name'] = trim($value);
    }
    
	public function setDescriptionAttribute($value)
	{
		$this->attributes['description'] = trim($value);
	}

	public function getRoutePrefix()
	{
		return \Str::slug($this->namespace);
	}

	public function extractControllers()
	{
		if (empty($this->controllers)) {
			return [];
		}
		$data = [];
		$items = explode(',', $this->controllers);
		foreach ($items as $key => $value) {
			// Generate Controller name and Route prefix
			$data[$value.'Controller'] = \Str::slug($value);
        }

		return $data;
	}


	// Data

	/**
	 * Find a Test by it's namespace
	 */
	public static function findByNamespace($namespace)
	{
		// Extract the last param of the full namespace
		// $namespace = substr($namespace, strrpos($namespace, '\\') + 1);
		$namespace = class_basename($namespace); // Laravel helper

		if (empty ($namespace)) {
			\App::abort(404, 'Módulo não definido para este Teste');
		}

		$test = self::where('namespace', '=', $namespace)->first();
		if ($test === null) {
			\App::abort(404, 'Módulo do Teste não encontrado');
		}

		return $test;
	}
}

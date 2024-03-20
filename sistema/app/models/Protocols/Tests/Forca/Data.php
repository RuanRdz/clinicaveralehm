<?php

namespace app\models\Protocols\Tests\Forca;

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use \Tratamento as Treatment;

class Data extends \Eloquent {

	protected $table = 'test_forca_data';
	protected $orderBy = 'testdate';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

	protected $fillable = [
	 	'treatment_id',
		'testbundle', 'testdate',
		'param_id', 'scale_id_left', 'scale_id_right'
	];
	public static $rules = [
		'treatment_id' => 'required|not_in:0',
		'testdate' => 'required',
	];


	// Relationship

	public function treatment()
	{
		return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
	}
	public function param()
	{
		return $this->belongsTo(Param::class, 'param_id', 'id')->orderBy('sort');
	}
	public function scaleLeft()
	{
		return $this->belongsTo(Scale::class, 'scale_id_left', 'id');
	}
	public function scaleRight()
	{
		return $this->belongsTo(Scale::class, 'scale_id_right', 'id');
	}


	// Mutators

	public function getTestdateAttribute($value)
	{
		// TODO convert date using Carbon
		return timestampToBr($value);
    }
    
	public function setTestdateAttribute($value)
	{
		if ($value == '0000-00-00' || empty($value)) {
			$value = null;
		}
		// TODO convert date using Carbon
		$this->attributes['testdate'] = brDateToDatabase($value);
	}

    public function setTreatmentIdAttribute($value)
    {
        $this->attributes['treatment_id'] = empty(trim($value)) ? null : $value;
    }

    public function setParamIdAttribute($value)
    {
        $this->attributes['param_id'] = empty(trim($value)) ? null : $value;
    }

    public function setScaleIdRightAttribute($value)
    {
        $this->attributes['scale_id_right'] = empty(trim($value)) ? null : $value;
    }

    public function setScaleIdLeftAttribute($value)
    {
        $this->attributes['scale_id_left'] = empty(trim($value)) ? null : $value;
    }

	// Data

	protected static function generateTestBundleId($treatment_id)
	{
		return $treatment_id.time().rand(1000, 9999);
	}

	public static function storeTest($post)
	{
		$treatment = Treatment::findOrFail($post['treatment_id']);
		$testbundle = self::generateTestBundleId($post['treatment_id']);
		foreach ($post['values'] as $param_id => $scale_id) {
			self::create([
				'treatment_id'   => $post['treatment_id'],
				'testbundle' 	 => $testbundle,
				'testdate' 		 => $post['testdate'],
				'param_id' 		 => $param_id,
				'scale_id_left'  => $scale_id['left'],
				'scale_id_right' => $scale_id['right'],
			]);
		}
		$treatment->setFezAvaliacao();
	}

	public static function getData(Treatment $treatment, $withPrevious = true)
	{
		$query = [
			'test_forca_data.id',
			'test_forca_data.treatment_id',
			'test_forca_data.testbundle',
			'test_forca_data.testdate',
			'test_forca_data.param_id',
			'test_forca_data.scale_id_left',
			'test_forca_data.scale_id_right',
		];

		if ($withPrevious) {
			return self::with('scaleLeft', 'scaleRight')
				->select($query)
				->join('test_forca_param', 'test_forca_data.param_id', '=', 'test_forca_param.id')
				->join('tratamentos as treatment', 'test_forca_data.treatment_id', '=', 'treatment.id')
				->where('treatment.paciente_id', '=', $treatment->paciente_id)
				->where('treatment.lesao_id', '=', $treatment->lesao_id)
				->where('test_forca_data.treatment_id', '<=', $treatment->id)
				->where('test_forca_data.deleted_at', '=', null)
				->orderBy('test_forca_data.testdate')
				->orderBy('test_forca_param.sort')
				->get();
		} else {
			return self::with('scaleLeft', 'scaleRight')
				->select($query)
				->join('test_forca_param', 'test_forca_data.param_id', '=', 'test_forca_param.id')
				->where('test_forca_data.treatment_id', '=', $treatment->id)
				->where('test_forca_data.deleted_at', '=', null)
				->orderBy('test_forca_data.testdate')
				->orderBy('test_forca_param.sort')
				->get();
		}
	}

	public static function presentData($data)
	{
		$params = Param::orderBy('sort')->get();
		$hands = Param::$hands;
		$result['head'] = [];
		$result['body'] = [];

		foreach ($params as $row) {
			$result['head']
				[$row->id]
				[$row->name] = [
					'left'  => $hands['left'],
					'right' => $hands['right']
				];
		}
		foreach ($data as $row) {
			if (! isset($result['head'][$row->param_id])) {
				continue;
			}
			$result['body']
				[$row->testbundle]
				[$row->testdate]
				[$row->param_id] = [
					'id' => $row->id,
					'treatment_id' => $row->treatment_id,
					'left' => $row->scaleLeft != null ? $row->scaleLeft->value : '-',
					'right' => $row->scaleRight != null ? $row->scaleRight->value : '-',
				];
		}

		return $result;
	}
}

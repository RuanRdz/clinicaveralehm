<?php

namespace app\models\Protocols\Tests\Jebsen;

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use \Tratamento as Treatment;

class Data extends \Eloquent {

	protected $table   = 'test_jebsen_data';
	protected $orderBy = 'testdate';

	use SoftDeletingTrait;
	protected $dates = array('deleted_at');

    protected $appends = ['time_right_in_seconds', 'time_left_in_seconds'];

	protected $fillable = [
		'treatment_id', 'param_id', 'time_left_hand', 'time_right_hand', 'testdate'
	];
	public static $rules = [
		'treatment_id' => 'required|not_in:0',
        'testdate' => 'required',
	];

	public static $sides = array(
		1 => 'Mão Direita',
		2 => 'Mão Esquerda',
	);


	// Relationship

	public function treatment()
	{
		return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
    }
    
	public function param()
	{
		return $this->belongsTo(Param::class, 'param_id', 'id')->orderBy('sort');
	}


	// Mutators

	public function getTestdateAttribute($value)
	{
		// TODO convert date using Carbon
		return timestampToBr($value);
    }
    
    public function getTimeRightInSecondsAttribute()
    {
        $value = $this->attributes['time_right_hand'];
        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $value);
        sscanf($value, "%d:%d:%d", $hours, $minutes, $seconds);
        $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
        return $time_seconds;
    }

    public function getTimeLeftInSecondsAttribute()
    {
        $value = $this->attributes['time_left_hand'];
        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $value);
        sscanf($value, "%d:%d:%d", $hours, $minutes, $seconds);
        $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
        return $time_seconds;
    }

    public function setTreatmentIdAttribute($value)
    {
        $this->attributes['treatment_id'] = empty(trim($value)) ? null : $value;
    }

    public function setParamIdAttribute($value)
    {
        $this->attributes['param_id'] = empty(trim($value)) ? null : $value;
    }

	public function setTestdateAttribute($value)
	{
		if ($value == '0000-00-00' || empty($value)) {
			$value = null;
		}
		// TODO convert date using Carbon
		$this->attributes['testdate'] = brDateToDatabase($value);
	}

	public function setTimeLeftHandAttribute($value)
	{
		if (empty($value)) {
			$value = '00:00:00';
		}
		$this->attributes['time_left_hand'] = $value;
	}

	public function setTimeRightHandAttribute($value)
	{
		if (empty($value)) {
			$value = '00:00:00';
		}
		$this->attributes['time_right_hand'] = $value;
	}

	// Data

	public static function storeTest($post)
	{
		$treatment = Treatment::findOrFail($post['treatment_id']);
		self::create($post);
		$treatment->setFezAvaliacao();
	}


	public static function getData(Treatment $treatment)
	{
		$query = [
            'test_jebsen_param.task',
			'test_jebsen_data.id',
			'test_jebsen_data.treatment_id',
			'test_jebsen_data.param_id',
			'test_jebsen_data.time_left_hand',
			'test_jebsen_data.time_right_hand',
			'test_jebsen_data.testdate',
		];

        return self::select($query)
            ->join('test_jebsen_param', 'test_jebsen_param.id', '=', 'test_jebsen_data.param_id')
            ->join('tratamentos as treatment', 'test_jebsen_data.treatment_id', '=', 'treatment.id')
            ->where('test_jebsen_data.treatment_id', '<=', $treatment->id)
            ->where('treatment.paciente_id', '=', $treatment->paciente_id)
            ->where('treatment.lesao_id', '=', $treatment->lesao_id)
            ->where('test_jebsen_data.deleted_at', '=', null)
            ->orderBy('test_jebsen_data.testdate')
            ->get();
	}

	public static function presentData($data)
	{
        $transform = [
            'grid' => [],
            'testdates' => []
        ];
        foreach ($data as $item) {
            $transform['grid'][$item['param_id']]['task'] = $item['task'];
            $transform['grid'][$item['param_id']]['testdates'][] = $item['testdate'].' #'.$item['treatment_id'];
            $transform['grid'][$item['param_id']]['time_right'][] = $item['time_right_in_seconds'];
            $transform['grid'][$item['param_id']]['time_left'][] = $item['time_left_in_seconds'];
            $transform['testdates'][$item['treatment_id']][$item['testdate']] = $item['testdate'];
        }

		return $transform;
	}
}

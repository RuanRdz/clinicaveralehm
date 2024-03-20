<?php 

use Tratamento as Treatment;

/**
 * Treatment Report
 */
class Report extends \Model 
{

    public static $rules = array(
        'treatment_id' => 'required',
    );

    public function getOptions(Treatment $treatment)
    {
        return explode('&', $treatment->report_options);
    }

    public function saveOptions(Treatment $treatment, $options)
    {
        $treatment->report_options = $options;
        $treatment->save();
    }
}

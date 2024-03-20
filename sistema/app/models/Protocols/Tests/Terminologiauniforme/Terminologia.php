<?php

namespace app\models\Protocols\Tests\Terminologiauniforme;

class Terminologia extends \Eloquent {

    use \SoftDeletingTrait;

    protected $table   = 'terminologia';
    protected $orderBy = 'parent_id';

	protected $fillable = array(
        'parent_id', 'level', 'code', 'label', 'is_question'
    );

    public static $rules = array();

    public static $levels = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6);
    public static $isQuestionOptions = array(0 => 'Não', 1 => 'Sim');


    public function terminologiatratamento()
    {
        return $this->hasMany('Terminologiatratamento');
    }

    // public function tratamentos()
    // {
    //     return $this->belongsToMany('Tratamento')->withTimestamps();
    // }

    public function setParentIdAttribute($value)
    {
        $this->attributes['parent_id'] = empty(trim($value)) ? null : $value;
    }

    public static function buildTree(array $elements, $parentId = 0)
    {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = self::buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

    public static function buildTreeHTML(array $elements, $parentId = 1)
    {
        $out = $li = '';
        foreach ($elements as $el) {

            if ($el['parent_id'] == $parentId) {

                if ($el['is_question']) {
                    //$icon = '<i class="fa fa-check"></i>';
                    $icon = '.';
                    $class = 'question';
                } else {
                    if ($el['level'] == 2) {
                        $icon = '';
                        $class = 'title';
                    } else {
                        $icon = '<i class="fa fa-caret-down"></i>';
                        $class = 'subtitle';
                    }
                }

                $children = self::buildTreeHTML($elements, $el['id']);
                if ($children) {
                    if ($el['level'] == 2) {
                        $children = '<ul style="padding-top: 12px">'.$children.'</ul>';
                    } else {
                        $children = '<ul>'.$children.'</ul>';
                    }
                } else {
                    $children = '';
                }

                // ('.$el['code'].') '.$el['id'].'
                $li = '<li class="'.$class.'">'.$icon.' '.$el['label'].''.$children.'</li>';

                /*
                switch ($el['id']) {

                    case '41':
                    //Session::push('teste', 41);
                        $li = 'a<table><tr><td style="padding-right:10px;">'.$li.'</td>';
                        Session::put('t_table', 41);
                        break;

                    case '42':
                    //Session::push('teste', 42);

                        if (Session::get('t_table') == 41) {
                            $li = 'b<td style="padding-right:10px;">'.$li;
                        } else {
                            // inicia a tabela no 42
                            $li = 'c<table><tr><td style="padding-right:10px;">'.$li.'</td>';
                            Session::put('t_table', 42);
                        }
                        break;

                    case '43':
                    //Session::push('teste', 43);
                        if (Session::get('t_table') == 41 || Session::get('t_table') == 42) {
                            $li = $li.'d</td></tr></table>';
                        } else {
                            $li = 'e<table><tr><td style="padding-right:10px;">'.$li.'</td></tr></table>';
                        }
                        Session::put('t_table', 43);
                        break;

                    default:
                        if (Session::get('t_table') == 41 || Session::get('t_table') == 42) {
                            $li = $li.'f</tr></table>';
                        }
                        //Session::forget('t_table');
                        break;
                }
                */

                if ($el['level'] == 2) {
                    $out .= '<td style=padding-right:30px;><ul>';
                    $out .= $li;
                    $out .= '</ul></td>';
                } else {
                    $out .= $li;
                }
            }
        }
        return $out;
    }

    public static function buildEditableTreeHTML(array $elements, $parentId = 1)
    {
        $out = '';
        foreach ($elements as $el) {
            if ($el['parent_id'] == $parentId) {

                if ($el['is_question'] == 1) {
                    $is_question = 'font-weight: normal';
                } else {
                    $is_question = 'font-weight: bold';
                }
                $checked     = $el['checked'] == 1 ? 'checked="checked"' : '';
                $checkbox    = \Form::checkbox('terminologia_tratamento[]', $el['id'], $checked);
                $children    = self::buildEditableTreeHTML($elements, $el['id']);
                if ($children) {
                    $children = '<ul>'.$children.'</ul>';
                } else {
                    $children = '';
                }
                $li = '<li style="'.$is_question.'">'.$checkbox.' '.$el['label'].''.$children.'</li>';
                if ($el['level'] == 2) {
                    $out .= '<div class="col-xs-5"><ul>';
                    $out .= $li;
                    $out .= '</ul></div>';
                } else {
                    $out .= $li;
                }
            }
        }
        return $out;
    }

    public static function buildUpdateTreeHTML(array $elements, $parentId = 1)
    {
        $out = '';
        foreach ($elements as $el) {
            if ($el['parent_id'] == $parentId) {

                if ($el['is_question'] == 1) {
                    $is_question = 'font-weight: normal';
                } else {
                    $is_question = 'font-weight: bold';
                }
                $children    = self::buildUpdateTreeHTML($elements, $el['id']);
                if ($children) {
                    $children = '<ul>'.$children.'</ul>';
                } else {
                    $children = '';
                }
                $url = '<a href="'.route('sistemaTerminologiaEdit', array('id' => $el['id'])).'">'.$el['label'].'</a>';
                $li = '<li style="'.$is_question.'">'.$url.''.$children.'</li>';
                if ($el['level'] == 2) {
                    $out .= '<div class="col-xs-5"><ul>';
                    $out .= $li;
                    $out .= '</ul></div>';
                } else {
                    $out .= $li;
                }
            }
        }
        return $out;
    }


    // Organiza as marcacoes para view
    public static function bundleTreeHtml($treatment)
    {
        $tu = array();
        $has_data = 0;

        $terminologias = Terminologia::all()->toArray();
        $tuDados = $treatment->terminologias->lists('id');
        
        // $tu['title'] = 'AVALIAÇÃO DESEMPENHO';
        $tu['titles'] = Terminologia::where('level', '=', 2)->get()->toArray();
        

        $tuArray = array();
        if ($tuDados) {
            foreach ($terminologias as $values) {
                if (! in_array($values['id'], $tuDados)) { continue; }
                $has_data++;
                $tuArray[] = array(
                  'id'          => $values['id'],
                  'parent_id'   => $values['parent_id'],
                  'level'       => $values['level'],
                  'code'        => $values['code'],
                  'label'       => $values['label'],
                  'is_question' => $values['is_question'],
                );
            }
        }
        $tu['2'] = Terminologia::buildTreeHTML($tuArray, 2);
            // Tree 3
            $tu['41'] = Terminologia::buildTreeHTML($tuArray, 41);
            $tu['42'] = Terminologia::buildTreeHTML($tuArray, 42);
            $tu['43'] = Terminologia::buildTreeHTML($tuArray, 43);
        $tu['4'] = Terminologia::buildTreeHTML($tuArray, 4);

        $tu['has-data'] = $has_data;

        return $tu;
    }
}
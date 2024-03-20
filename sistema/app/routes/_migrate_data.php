<?php

Route::group(array('before' => 'auth', 'prefix' => 'migrate'), function(){

    /*
    Route::get('protocols-avds', function() {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        app\models\Protocols\Tests\Avds\Data::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // antigo => novo
        $scale = array(
            0  => null,
            10 => 1,
            20 => 2,
            30 => 3,
        );

        // antigo => novo
        $paramgroup = array(
            'alimentacao'   => 1,
            'higiene'       => 2,
            'equipamentos'  => 3,
            'vestuario'     => 4,
            'comunicacao'   => 5,
            'manipulacao'   => 6,
            'tarefas'       => 7,
            'outros'        => 8,
        );

        $sql = '
            SELECT 
            anamnese.id as antigo,
            test_avds_param.id as novo,
            lower(anamnese.nome),
            lower(test_avds_param.name)
            FROM anamnese 
            inner join test_avds_param 
            on lower(anamnese.nome) = lower(test_avds_param.name)
            where bloco = "C"';
        $query = DB::select($sql);
        $param = array();
        foreach($query as $row) {
            $param[$row->antigo] = $row->novo;
        }

        $query = Anamnesetratamento::join('anamnese', 'anamnese.id', '=', 'anamnesetratamentos.anamnese_id')
            ->select(
                'anamnesetratamentos.id',
                'anamnesetratamentos.tratamento_id',
                'anamnesetratamentos.anamnese_id',
                'anamnesetratamentos.opcao',
                'anamnesetratamentos.created_at',
                'anamnesetratamentos.created_at',
                'anamnesetratamentos.updated_at'
            )
            ->where('anamnese.bloco', '=', 'C')
            ->where('anamnesetratamentos.opcao', '!=', 0)
            ->get();

        $chunks = $query->chunk(100);
        $chunks->toArray();
        foreach($chunks as $chunk) {
            $data = array();
            foreach ($chunk as $row) {
                if (!isset($param[$row->anamnese_id]) || !isset($scale[$row->opcao])){
                    continue;
                }
                $data[] = array(
                    'treatment_id' => $row->tratamento_id,
                    'param_id' => $param[$row->anamnese_id],
                    'scale_id' => $scale[$row->opcao],
                    'testdate' => $row->created_at,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                );
            }
            app\models\Protocols\Tests\Avds\Data::insert($data);
        }
        
        echo 'Done: '.time();
    });
    */

    /*
    Route::get('protocols-forca', function() {

        ///////////////////////////////
        // Rodar arquivo execute.sql //
        ///////////////////////////////

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        app\models\Protocols\Tests\Forca\Scale::truncate();
        app\models\Protocols\Tests\Forca\Param::truncate();
        app\models\Protocols\Tests\Forca\Data::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Scale
        $scale = array(
            array('weight' => -3, 'weightsuffix' => 'Kg', 'enabled' => 1),
            array('weight' => -2.5, 'weightsuffix' => 'Kg', 'enabled' => 1),
            array('weight' => -2, 'weightsuffix' => 'Kg', 'enabled' => 1),
            array('weight' => -1.5, 'weightsuffix' => 'Kg', 'enabled' => 1),
            array('weight' => -1, 'weightsuffix' => 'Kg', 'enabled' => 1),
            array('weight' => -0.5, 'weightsuffix' => 'Kg', 'enabled' => 1),
            array('weight' => -0.2, 'weightsuffix' => 'Kg', 'enabled' => 1),
            array('weight' => 0, 'weightsuffix' => 'Kg', 'enabled' => 1),
            array('weight' => 0.1, 'weightsuffix' => 'Kg', 'enabled' => 1),
            array('weight' => 0.2, 'weightsuffix' => 'Kg', 'enabled' => 1),
            array('weight' => 0.3, 'weightsuffix' => 'Kg', 'enabled' => 1),
            array('weight' => 0.4, 'weightsuffix' => 'Kg', 'enabled' => 1),
            array('weight' => 0.5, 'weightsuffix' => 'Kg', 'enabled' => 1),
            array('weight' => 0.6, 'weightsuffix' => 'Kg', 'enabled' => 1),
            array('weight' => 0.7, 'weightsuffix' => 'Kg', 'enabled' => 1),
            array('weight' => 0.8, 'weightsuffix' => 'Kg', 'enabled' => 1),
            array('weight' => 0.9, 'weightsuffix' => 'Kg', 'enabled' => 1),
        );
        for ($i = 1; $i < 100; $i++) {
            $scale[] = array('weight' => $i, 'weightsuffix' => 'Kg', 'enabled' => 1);
            $scale[] = array('weight' => $i + 0.5, 'weightsuffix' => 'Kg', 'enabled' => 1);
        }
        $scale[] = array('weight' => 100.0, 'weightsuffix' => 'Kg', 'enabled' => 1);
        app\models\Protocols\Tests\Forca\Scale::insert($scale);

        // Param
        $data = [
            ['name' => 'FORÇA DE PREENSÃO', 'sort' => 1, 'enabled' => 1],
            ['name' => 'PINÇA POLPA - LATERAL', 'sort' => 2, 'enabled' => 1],
            ['name' => 'PINÇA TRÍPODE', 'sort' => 3, 'enabled' => 1],
            ['name' => 'PINÇA POLPA - POLPA', 'sort' => 4, 'enabled' => 1],
        ];
        app\models\Protocols\Tests\Forca\Param::insert($data);


        // Data
        $scale = app\models\Protocols\Tests\Forca\Scale::lists('id', 'weight');
        $query = Tabelaforca::get();
        $chunks = $query->chunk(100);
        $chunks->toArray();
        foreach($chunks as $chunk) {
            $data = array();
            foreach ($chunk as $row) {

                $f1d = number_format((float) $row->f1d, 1);
                if(isset($scale[$f1d])) {
                    $f1d = $scale[$f1d];
                } else {
                    $id = app\models\Protocols\Tests\Forca\Scale::insertGetId(
                        array('weight' => $f1d, 'weightsuffix' => 'Kg', 'enabled' => 1)
                    );
                    $scale[$f1d] = $id;
                    $f1d = $id; 
                }
                
                $f1e = number_format((float) $row->f1e, 1);
                if(isset($scale[$f1e])) {
                    $f1e = $scale[$f1e];
                } else {
                    $id = app\models\Protocols\Tests\Forca\Scale::insertGetId(
                        array('weight' => $f1e, 'weightsuffix' => 'Kg', 'enabled' => 1)
                    );
                    $scale[$f1e] = $id;
                    $f1e = $id; 
                }

                $f2d = number_format((float) $row->f2d, 1);
                if(isset($scale[$f2d])) {
                    $f2d = $scale[$f2d];
                } else {
                    $id = app\models\Protocols\Tests\Forca\Scale::insertGetId(
                        array('weight' => $f2d, 'weightsuffix' => 'Kg', 'enabled' => 1)
                    );
                    $scale[$f2d] = $id;
                    $f2d = $id; 
                }

                $f2e = number_format((float) $row->f2e, 1);
                if(isset($scale[$f2e])) {
                    $f2e = $scale[$f2e];
                } else {
                    $id = app\models\Protocols\Tests\Forca\Scale::insertGetId(
                        array('weight' => $f2e, 'weightsuffix' => 'Kg', 'enabled' => 1)
                    );
                    $scale[$f2e] = $id;
                    $f2e = $id; 
                }

                $f3d = number_format((float) $row->f3d, 1);
                if(isset($scale[$f3d])) {
                    $f3d = $scale[$f3d];
                } else {
                    $id = app\models\Protocols\Tests\Forca\Scale::insertGetId(
                        array('weight' => $f3d, 'weightsuffix' => 'Kg', 'enabled' => 1)
                    );
                    $scale[$f3d] = $id;
                    $f3d = $id; 
                }

                $f3e = number_format((float) $row->f3e, 1);
                if(isset($scale[$f3e])) {
                    $f3e = $scale[$f3e];
                } else {
                    $id = app\models\Protocols\Tests\Forca\Scale::insertGetId(
                        array('weight' => $f3e, 'weightsuffix' => 'Kg', 'enabled' => 1)
                    );
                    $scale[$f3e] = $id;
                    $f3e = $id; 
                }

                $f4d = number_format((float) $row->f4d, 1);
                if(isset($scale[$f4d])) {
                    $f4d = $scale[$f4d];
                } else {
                    $id = app\models\Protocols\Tests\Forca\Scale::insertGetId(
                        array('weight' => $f4d, 'weightsuffix' => 'Kg', 'enabled' => 1)
                    );
                    $scale[$f4d] = $id;
                    $f4d = $id; 
                }

                $f4e = number_format((float) $row->f4e, 1);
                if(isset($scale[$f4e])) {
                    $f4e = $scale[$f4e];
                } else {
                    $id = app\models\Protocols\Tests\Forca\Scale::insertGetId(
                        array('weight' => $f4e, 'weightsuffix' => 'Kg', 'enabled' => 1)
                    );
                    $scale[$f4e] = $id;
                    $f4e = $id; 
                }

                $testbundle = app\models\Protocols\Tests\Forca\Data::generateTestBundleId($row->tratamento_id);

                $data[] = array(
                    'treatment_id'   => $row->tratamento_id,
                    'testbundle'     => $testbundle,
                    'testdate' 		 => brDateToDatabase($row->data_sessao),
                    'param_id' 		 => 1,
                    'scale_id_left'  => $f1e,
                    'scale_id_right' => $f1d,
                );

                $data[] = array(
                    'treatment_id'   => $row->tratamento_id,
                    'testbundle'     => $testbundle,
                    'testdate' 		 => brDateToDatabase($row->data_sessao),
                    'param_id' 		 => 2,
                    'scale_id_left'  => $f2e,
                    'scale_id_right' => $f2d,
                );

                $data[] = array(
                    'treatment_id'   => $row->tratamento_id,
                    'testbundle'     => $testbundle,
                    'testdate' 		 => brDateToDatabase($row->data_sessao),
                    'param_id' 		 => 3,
                    'scale_id_left'  => $f3e,
                    'scale_id_right' => $f3d,
                );

                $data[] = array(
                    'treatment_id'   => $row->tratamento_id,
                    'testbundle'     => $testbundle,
                    'testdate' 		 => brDateToDatabase($row->data_sessao),
                    'param_id' 		 => 4,
                    'scale_id_left'  => $f4e,
                    'scale_id_right' => $f4d,
                );

                app\models\Protocols\Tests\Forca\Data::insert($data);
            }
        }

        echo 'Done: '.time();
    });
    */

    /*
    Route::get('protocols-funcaomuscular', function() {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        app\models\Protocols\Tests\Funcaomuscular\Data::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // antigo / novo
        $scale[0] = 1;
        $scale[1] = 2;
        $scale[2] = 3;
        $scale[3] = 4;
        $scale[4] = 5;
        $scale[5] = 6;

        $sql = '
            SELECT 
            testeforca.id as antigo,
            test_funcaomuscular_param.id as novo,
            lower(concat(moviment, muscle)) as a,
            lower(concat(nome, descricao)) as b
            FROM testeforca
            inner join test_funcaomuscular_param 
            on lower(concat(moviment, muscle)) = lower(concat(nome, descricao))';
        $query = DB::select($sql);
        $param = array();
        foreach($query as $row) {
            $param[$row->antigo] = $row->novo;
        }

        $query = Testeforcatratamento::get();
        $chunks = $query->chunk(100);
        $chunks->toArray();
        foreach($chunks as $chunk) {
            $data = array();
            foreach ($chunk as $row) {
                if(!isset($param[$row->testeforca_id])){
                    continue;
                }
                $data[] = array(
                    'treatment_id' => $row->tratamento_id,
                    'param_id' => $param[$row->testeforca_id],
                    'scale_id' => $scale[$row->grau],
                    'testdate' => brDateToDatabase($row->data_sessao),
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                    'deleted_at' => $row->deleted_at,
                );
            }
            app\models\Protocols\Tests\Funcaomuscular\Data::insert($data);
        }

        echo 'Done: '.time();
    });
    */

    /*
    Route::get('protocols-goniometro', function() {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        app\models\Protocols\Tests\Goniometro\Data::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $sides = [
            '-' => 1,
            'direito' => 2,
            'esquerdo' => 3,
        ];

        $query = Amplitudetratamento::get();
        $chunks = $query->chunk(100);
        $chunks->toArray();
        foreach($chunks as $chunk) {
            $data = array();
            foreach ($chunk as $row) {
                $data[] = array(
                    'treatment_id' => $row->tratamento_id,
                    'param_id' => $row->amplitude_id,
                    'side_id' => $sides[$row->lado],
                    'degree_active' => $row->ativo,
                    'degree_passive' => $row->passivo,
                    'testdate' => brDateToDatabase($row->data_sessao),
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                );
            }
            app\models\Protocols\Tests\Goniometro\Data::insert($data);
        }

         echo 'Done: '.time();
    });
    */

    // Route::get('update-avaliacoes', function() {
    //     Tratamento::chunk(100, function($tratamentos)
    //     {
    //         foreach ($tratamentos as $tratamento)
    //         {
    //             $tratamento->updateAvaliacoes();
    //         }
    //         var_dump('Finished');
    //     });
    // });

    // Route::get('update-concluidos', function(){
    //     $t = Tratamento::with('agendas')->where('tratamentosituacao_id', '=', 1)->get();
    //     foreach($t as $tt)
    //     {
    //         $a = $tt->agendas()->where('agendasituacao_id', '=', 2)->get();
    //         $ax = $tt->agendas()->get();
    //         $ac = $a->count();
    //         $axc = $ax->count();
    //         if ($ac > 0 && ($ac <= 10 || $ac == 20 || $ac == 30 || $ac == 40 || $ac == 50)) {
    //             if ($ac == $axc) {
    //                 $tt->tratamentosituacao_id = 2;
    //                 $tt->save();
    //             }
    //             echo $tt->id.' - '.$tt->tratamentosituacao->nome.' = '.$ac.':'.$axc.'<br />';
    //         }
    //     }
    // });

});

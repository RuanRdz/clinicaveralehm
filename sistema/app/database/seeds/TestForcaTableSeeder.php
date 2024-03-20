<?php

class TestForcaTableSeeder extends Seeder {

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		app\models\Protocols\Tests\Forca\Param::truncate();
		app\models\Protocols\Tests\Forca\Scale::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		// PARAMS
		$data = [
			['name' => 'força de preensão', 'sort' => 1],
			['name' => 'pinça polpa - lateral', 'sort' => 2],
			['name' => 'pinça trípode', 'sort' => 3],
			['name' => 'pinça polpa - polpa', 'sort' => 4]
		];
        app\models\Protocols\Tests\Forca\Param::insert($data);

		// SCALE
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
        $scale[] = array('weight' => 100, 'weightsuffix' => 'Kg', 'enabled' => 1);
        app\models\Protocols\Tests\Forca\Scale::insert($scale);
	}
}

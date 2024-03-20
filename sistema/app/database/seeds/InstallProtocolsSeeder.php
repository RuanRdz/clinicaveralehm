<?php

class InstallProtocolsSeeder extends Seeder {

	public function run()
	{

		$this->call('SpecialitiesTableSeeder');
		$this->call('ProtocolsTableSeeder');
		$this->call('TestsTableSeeder');

		// Tests
		$this->call('TestEstesiometroTableSeeder');
		$this->call('TestForcaTableSeeder');
		$this->call('TestAvdsTableSeeder');
		// $this->call('TestFuncaomuscularTableSeeder');
	}
}

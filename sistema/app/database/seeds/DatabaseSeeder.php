<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// Rodar somente na instalação inicial
		$this->call('SistemaTableSeeder');
		$this->call('UserTableSeeder');
		$this->call('WorkspaceTableSeeder');

		$this->call('InstallProtocolsSeeder');
	}

}

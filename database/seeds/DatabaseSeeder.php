<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run() {


		/*$this->call(CountriesSeeder::class);
		$this->call(Permissions::class);
		$this->call(RoleSeeder::class);
		$this->call(courier_zones::class);
		$this->call(OptionSeeder::class);*/

		//$this->call(AdminEmployeesSeeder::class);
		//$this->call(WharehosesSeeder::class);
		//$this->call(warehouseShelvesSeeder::class);
		
		//$this->call(ShopaholicsSeeder::class);
		//$this->call(WalletSeeder::class);
		

		//$this->call(TrackinNumbersSeeder::class);
		$this->call(CoreTablesSeeder::class);

	}
}

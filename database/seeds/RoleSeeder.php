<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder {


	
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$role = [
			[
				'name' => 'admin',
				'display_name' => 'Admin',
				'description' => 'Admin',
			],
			[
				'name' => 'owner',
				'display_name' => 'Owner',
				'description' => 'Owner',
			],
			[
				'name' => 'shopaholic',
				'display_name' => 'Shopaholic',
				'description' => 'Shopaholic',
			],
			[
				'name' => 'worker',
				'display_name' => 'Worker',
				'description' => 'Worker',
			],
			[
				'name' => 'employee',
				'display_name' => 'Employee',
				'description' => 'Employee',
			],
			[
				'name' => 'manager',
				'display_name' => 'Manager',
				'description' => 'Manager',
			],

		];
		foreach ($role as $key => $value) {
			Role::create($value);
		}

		echo "Roles : Done";
	}
}

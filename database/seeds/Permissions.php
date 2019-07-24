<?php

use App\Permission;
use Illuminate\Database\Seeder;

class Permissions extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$permission = [
			[
				'name' => 'add_permission',
				'display_name' => 'Add Permission',
				'description' => 'Add Permission',
			],
			[
				'name' => 'list_permission',
				'display_name' => 'List Permissions',
				'description' => 'List Permissions',
			],

			[
				'name' => 'delete_permission',
				'display_name' => 'Delete Permission',
				'description' => 'Delete Permission',
			],
			[
				'name' => 'add_role',
				'display_name' => 'Add Role',
				'description' => 'Add Role',
			],

			[
				'name' => 'list_role',
				'display_name' => 'List Roles',
				'description' => 'List Roles',
			],
			[
				'name' => 'delete_role',
				'display_name' => 'Delete Role',
				'description' => 'Delete Role',
			],
			[
				'name' => 'add_employee',
				'display_name' => 'Add Employee',
				'description' => 'Add Employee',
			],

			[
				'name' => 'list_employee',
				'display_name' => 'List Employees',
				'description' => 'List Employees',
			],
			[
				'name' => 'delete_employee',
				'display_name' => 'Delete Employee',
				'description' => 'Delete Employee',
			],

		];
		foreach ($permission as $key => $value) {
			Permission::create($value);
		}

		echo "Permissions : Done";
	}
}

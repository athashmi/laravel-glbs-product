<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use DataTables;
use Illuminate\Http\Request;
use JavaScript;

class RoleController extends Controller {

	public function index() {
		JavaScript::put([
			'del_url' => route('role.delete'),
		]);
		$all_perms = Permission::all();
		 
		return view('acl.roles.index', compact('all_perms'));
	}

	public function create() {
		//
	}

	public function getRoles() {

		$result = Role::select('id', 'display_name', 'name', 'description', 'created_at');
		return DataTables::of($result)
			->addColumn('action', function ($result) {
				return view('layout.action-buttons', ['result' => $result, 'modal_id' => 'EditRoleModel'])->render();
			})->make(true);
	}
	public function store(Request $request) {
		$validatedData = $request->validate([
			'name' 			=> 'required|unique:roles|regex:/^[a-zA-Z0-9_.]*$/',
			'display_name' 	=> 'required',
			'description' 	=> 'required',
		]);

		$role 		= new Role($request->all());
		$is_saved 	= $role->save();
		if ($is_saved) {
			if (isset($request->permission)) {
				$is_permission 	= $role->attachPermissions($request->permission);
				$msg['status'] 	= "1";
				$msg['msg'] 	= "Information has been saved successfully ...";
				return json_encode($msg);
			} else {
				$msg['status']	= "1";
				$msg['msg'] 	= "Information has been saved successfully ...";
				return json_encode($msg);
			}
		} else {
			$msg['status'] 	= "0";
			$msg['msg'] 	= "Some thing went wrong...";
			return json_encode($msg);
		}
	}
	public function getpermission() {
		$permissions = Permission::all();
		if (isset($permissions)) {
			$msg['status'] 		= "1";
			$msg['permissions'] = $permissions;
			return json_encode($msg);
		} else {
			$msg['status'] 	= "0";
			$msg['data'] 	= "Data not found...";
			return json_encode($msg);
		}
	}
	public function edit(Request $request) {
		$id = $request->id;
		if (!empty($id)) {
			$role = Role::where('id', $id)->first();
			$assigned_perms = $role->perms->pluck("id")->toArray();
			if (isset($assigned_perms)) {
				$data['status'] 			= "1";
				$data['role'] 				= $role;
				$data['assigned_perms'] 	= $assigned_perms;
				return json_encode($data);
			} else {
				$msg['status'] 	= "0";
				$msg['data'] 	= "Data not found...";
				return json_encode($msg);
			}
		}
	}
	public function update(Request $request) {
		$id 				= $request->update_role_id;
		$validatedData 		= $request->validate([
			"name" 			=> "required|unique:roles,name," . $id . "",
			'display_name' 	=> 'required',
			'description' 	=> 'required',
		]);
		if (!empty($id)) {
			$result 	= Role::find($id);
			$is_update 	= $result->update($request->all());
			if ($is_update) {
				$result->perms()->sync([]);
				if ($request->permissions) {
					$result->attachPermissions($request->permissions);
				}
				$msg['status'] 	= "1";
				$msg['msg'] 	= "Information has been update successfully ...";
				return json_encode($msg);
			} else {
				$msg['status'] 	= "0";
				$msg['msg'] 	= "Some thing went wrong...";
				return json_encode($msg);
			}
		}
	}
	public function delete(Request $request) {
		$id = $request->id;
		if (!empty($id)) {
			$role_obj = Role::where('id', $id)->delete();
			if ($role_obj) {
				$msg['status'] 	= "1";
				$msg['data'] 	= "Record deleted successfully ...";
				return json_encode($msg);
			} else {
				$msg['status'] 	= "0";
				$msg['data'] 	= "some thing went wrong ...";
				return json_encode($msg);
			}

		}
	}
}
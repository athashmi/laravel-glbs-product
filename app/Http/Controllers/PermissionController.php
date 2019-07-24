<?php

namespace App\Http\Controllers;

use App\Permission;
use DataTables;
use Illuminate\Http\Request;
use JavaScript;

class PermissionController extends Controller {

	public function index() {
		JavaScript::put([
			'del_url' => route('permission.delete'),
		]);
		return view('acl.permissions.index');
	}

	public function getPermission() {
		$result = Permission::select('id', 'display_name', 'name', 'description', 'created_at');
		return DataTables::of($result)
			->addColumn('action', function ($result) {
				return view('layout.action-buttons', ['result' => $result, 'modal_id' => 'EditPermissionModel'])->render();
			})->make(true);
	}

	public function create() {
		//
	}

	public function store(Request $request) {
		$validatedData 		= $request->validate([
			'name' 			=> 'required|unique:permissions',
			'display_name' 	=> 'required',
			'description' 	=> 'required',
		]);
		$permission = new Permission($request->all());
		$is_saved 	= $permission->save();
		if ($is_saved) {
			$msg['status'] 	= "1";
			$msg['msg'] 	= "Information has been saved successfully ...";
			return json_encode($msg);
		} else {
			$msg['status'] 	= "0";
			$msg['msg'] 	= "Some thing went wrong...";
			return json_encode($msg);
		}
	}

	public function show($id) {
		//
	}

	public function edit(Request $request) {
		$id = $request->id;
		//dd($id);
		if (!empty($id)) {
			$result = Permission::find($id);
			if (isset($result->id)) {
				$msg['status'] 	= 1;
				$msg['data'] 	= $result;
				return json_encode($msg);
			} else {
				$msg['status'] 	= 0;
				$msg['data'] 	= "Data not found...";
				return json_encode($msg);
			}
		}
	}

	public function update(Request $request) {
		$id 				= $request->update_permission_id;
		$validatedData 		= $request->validate([
			'name' 			=> "required|unique:permissions,name,".$id."",
			'display_name' 	=> 'required',
			'description' 	=> 'required',
		]);
		if (!empty($id)) {
			$result = Permission::find($id);
			$is_update = $result->update($request->all());
			if ($is_update) {
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
			$permission_obj = Permission::where('id', $id)->delete();
			if ($permission_obj) {
				$msg['status'] 	= "1";
				$msg['data'] 	= "Record has been deleted successfully ...";
				return json_encode($msg);
			} else {
				$msg['status'] 	= "0";
				$msg['data'] 	= "some thing went wrong ...";
				return json_encode($msg);
			}

		}
	}
}

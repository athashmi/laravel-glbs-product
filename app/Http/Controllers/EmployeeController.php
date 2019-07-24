<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Role;
use App\User;
use Carbon;
use DataTables;
use File;
use Hash;
use Illuminate\Http\Request;
use JavaScript;
use Storage;
use URL;

class EmployeeController extends Controller {

	public function __construct() {
		JavaScript::put([
			'del_url' => route('employee.delete'),
		]);
	}

	public function index() {
		
		$roles = Role::all();
		return view('employees.index', compact('roles'));
	}

	public function gridIndex() {
		
		$roles = Role::all();

		$employees = Employee::with('user')->get();
		return view('employees.grid_index', compact('roles', 'employees'));
	}
	public function create() {
		$roles = Role::all();

		//$managers = User::withRole('manager')->get();
		$managers = User::whereHas('roles', function ($q) {
			$q->where('name', 'admin');
			$q->orWhere('name', 'manager');
			$q->orWhere('name', 'owner');
		})->get();

		//dd($managers);
		return view('employees.create_employee', compact('roles', 'managers'));
	}

	public function store(Request $request) {
		$validatedData = $request->validate([
			'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'email|unique:users',
			//'user_name' => 'required|unique:users',
			'phone' => 'required',
			'password' => 'required|confirmed|min:6',
			'role' => 'required',
			'dob_date' => 'required',
			'hire_date' => 'required',
			'pay_type' => 'required',
			'pay_rate' => 'required',
			'emergency_name' => 'required',
			'emergency_no' => 'required',
			'address' => 'required',
		]);
		$user = new User();
		$user->first_name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;
		//$user->user_name = $request->user_name;
		$user->phone = $request->phone;
		$user->dob = Carbon::parse($request->dob_date);
		$user->password = Hash::make($request->password);

		if ($request->hasFile('files')) {

			$file = $request->file("files");

			$file_unique_name = $request->first_name . '-' . time() . '-' . date("Ymdhis") . rand(0, 999) . '.' . $file->guessExtension();

			$user->picture = $file_unique_name;

			$file->storeAs(config('constants.img_folder'), $file_unique_name);
		}

		$user_saved = $user->save();
		if ($user_saved) {
			$user->roles()->attach($request->role);
			$employee = new Employee();
			$employee->hire_date = Carbon::parse($request->hire_date);
			$employee->pay_type = $request->pay_type;
			$employee->pay_rate = $request->pay_rate;
			$employee->managed_by = $request->managed_by; //Hard Coded (please change)
			$employee->emergency_contact_name = $request->emergency_name;
			$employee->emergency_contact_phone = $request->emergency_no;
			$employee->address = $request->address;

			if (isset($request->sick_leave)) {
				$employee->sick_leave = $request->sick_leave;
			}
			if (isset($request->vocation_yearly)) {
				$employee->vacation_yearly = $request->vocation_yearly;
			}

			$employee_saved = $user->employee()->save($employee);
			//$employee_saved = $employee->save();
			if ($employee_saved) {
				$msg['status'] = 1;
				$msg['msg'] = "Information has been saved...";
				return json_encode($msg);
			}
		} else {
			$msg['status'] = "0";
			$msg['msg'] = "Some thing went wrong...";
			return json_encode($msg);
		}
	}
	public function getemployee() {
		$employees = Employee::with('user');

		//dd(DataTables::of($employees));
		return DataTables::of($employees)
			->addColumn('full_name', function ($employee) {
				return $employee->user->first_name . ' ' . $employee->user->last_name;
			})

			->addColumn('email', function ($employee) {
				return $employee->user->email;
			})
			->addColumn('phone', function ($employee) {
				return $employee->user->phone;
			})
			->addColumn('dob', function ($employee) {
				return $employee->user->dob;
			})
			->addColumn('created_at', function ($employee) {
				return $employee->user->created_at;
			})
			->addColumn('role', function ($employee) {
				return $employee->user->roles->first()->name;
			})
			->addColumn('picture', function ($employee) {
				if($employee->user->picture){
					$img = URL::route("img_file", $employee->user->picture);
					$html = '<div><img class="img-fluid" src="'.$img.'" /></div>';
					return $html;
				}
				
			else{
				 
				$html = '<div><img class="img-fluid" style="border-radius: 50%;" src="'.asset('images/user2-160x160.jpg').'" /></div>';
				return $html;
			}
				

				//return "<h1> jjj</h1>";
				
			})
			->addColumn('action', function ($employee) {
				return view('employees.action-buttons', ['employee' => $employee])->render();
			})
			->rawColumns(['picture', 'action'])
			->make(true);
	}

	public function edit($id) {
		$employee = Employee::where('id', $id)->with('user')->first();
		//$employee = Employee::where('id', $id)->with('user')->first();

		$roles = Role::all();
		//dd($users);
		$managers = User::whereHas('roles', function ($q) {
			$q->where('name', 'admin');
			$q->orWhere('name', 'manager');
			$q->orWhere('name', 'owner');
		})->get();
		return view('employees.edit_employee', compact('roles', 'employee', 'managers'));

	}
	public function update(Request $request) {
		$id = $request->id;
		$validatedData = $request->validate([
			'first_name' => 'required',
			'last_name' => 'required',
			"email" => "email|unique:users,email," . $id,
			//'user_name' => 'required',
			'phone' => 'required',
			'role' => 'required',
			'dob_date' => 'required',
			'hire_date' => 'required',
			'pay_type' => 'required',
			'pay_rate' => 'required',
			'emergency_name' => 'required',
			'emergency_no' => 'required',
			'address' => 'required',
		]);
		$user = User::where('id', $id)->first();
		$user->first_name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;
		//$user->user_name = $request->user_name;
		$user->phone = $request->phone;
		$user->dob = Carbon::parse($request->dob_date);
		$user->password = Hash::make($request->password);
		if ($request->img_del == 1) {
			Storage::delete(config('constants.img_folder') . '/' . $user->picture);
			$user->picture = "";
		}
		if ($request->hasFile('files')) {
			$file = $request->file("files");

			if ($user->picture != "") {
				Storage::delete(config('constants.img_folder') . '/' . $user->picture);
			}

			$file_unique_name = $request->first_name . '-' . time() . '-' . date("Ymdhis") . rand(0, 999) . '.' . $file->guessExtension();

			$user->picture = $file_unique_name;

			$file->storeAs(config('constants.img_folder'), $file_unique_name);
		}

		$is_update = $user->update();
		if (isset($is_update)) {
			//$role = $user->roles()->where('id', )->first();
			$user->roles()->sync([$request->role]);
			// $user->roles()->attach($request->role);
			$user->employee->hire_date = Carbon::parse($request->hire_date);
			$user->employee->pay_type = $request->pay_type;
			$user->employee->pay_rate = $request->pay_rate;
			$user->employee->managed_by = $request->managed_by; //Hard Coded (please change)
			$user->employee->emergency_contact_name = $request->emergency_name;
			$user->employee->emergency_contact_phone = $request->emergency_no;
			$user->employee->address = $request->address;
			// $user->employee->user_id   = $user->id;
			if (isset($request->sick_leave)) {
				$user->employee->sick_leave = $request->sick_leave;
			}
			if (isset($request->vocation_yearly)) {
				$user->employee->vacation_yearly = $request->vocation_yearly;
			}
			$employee_saved = $user->employee->update();
			if ($employee_saved) {
				$msg['status'] = 1;
				$msg['msg'] = "Information has updated successfully...";
				return json_encode($msg);
			}
		} else {
			$msg['status'] = 0;
			$msg['msg'] = "Something went wrong";
			return json_encode($msg);
		}
	}

	public function delete(Request $request) {
		$id = $request->id;
		if (!empty($id)) {
			$user_obj = User::where('id', $id)->first();
			$storage_path = storage_path(config('constants.img_folder'));
			@unlink($storage_path . '/' . $user_obj->picture);
			if($user_obj->employee){
				$user_obj->employee->delete();
			}
			$user_del = $user_obj->delete();
			if ($user_del) {
				$msg['status'] = "1";
				$msg['data'] = "Record deleted successfully ...";
				return json_encode($msg);
			} else {
				$msg['status'] = "0";
				$msg['data'] = "some thing went wrong ...";
				return json_encode($msg);
			}

		}
	}
}

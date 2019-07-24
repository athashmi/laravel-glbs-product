<?php

namespace App\Http\Controllers;

use App\Country;
use DataTables;
use Illuminate\Http\Request;
use JavaScript;

class CountryController extends Controller {

	public function index(){
		JavaScript::put([
			'del_url' => route('country.delete'),
		]);
		return view('countries.index');
	}

	public function getcountries() {
		$countries 	= Country::select('id', 'name', 'iso', 'num_code', 'phone_code', 'isK');
		return DataTables::of($countries)
			->addColumn('flag', function ($country) {
				$img_absolute = public_path('/images/flags/'.strtolower($country->iso). '.png');
				$img_name = strtolower($country->iso). '.png';
				$img = asset('images/flags/' .$img_name);
				if(!file_exists($img_absolute))
					$img  = asset('images/flags/' . strtolower($country->iso). '.svg');

				return '<div class="mx-auto gs-width-fixed" ><img src="' . $img . '" class="img-fluid  img-thumbnail "></div>';
			})
			->rawColumns(['status', 'action', 'flag'])
			->addColumn('action', function ($country) {
				return view('countries.action-buttons', ['result' => $country, 'modal_id' => 'EditCountryModel'])->render();
			})->make(true);
	}

	public function store(Request $request) {
		$validatedData 	= 	$request->validate([
			'name' 		=> 	'required',
			'iso' 		=> 	'required|max:2',
			'iso3' 		=> 	'required|max:3',
		]);
		$request->merge(['nice_name' => ucwords($request->name)]);
		$country 	= 	new Country($request->all());
		$is_saved 	= 	$country->save();
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

	public function edit(Request $request) {
		$id = $request->id;
		if (!empty($id)) {
			$country = Country::find($id);
			if (isset($country->id)) {
				$msg['status'] 	= 1;
				$msg['data'] 	= $country;
				return json_encode($msg);
			} else {
				$msg['status'] 	= 0;
				$msg['data'] 	= "Data not found...";
				return json_encode($msg);
			}
		}
	}

	public function update(Request $request) {
		$id = $request->id;
		$validatedData = $request->validate([
			'name' 	=> 'required',
			'iso' 	=> 'required|max:2',
		]);
		if (!empty($id)) {
			$country 	= Country::find($id);
			$is_update 	= $country->update($request->all());
			if ($is_update) {
				$msg['status'] 	= 1;
				$msg['msg'] 	= "Information has been update successfully ...";
				return json_encode($msg);
			} else {
				$msg['status'] 	= 0;
				$msg['msg'] 	= "Some thing went wrong...";
				return json_encode($msg);
			}
		} else {
			$msg['status'] 	= 0;
			$msg['msg'] 	= "Some thing went wrong...";
			return json_encode($msg);
		}
	}

	public function update_status(Request $request) {
		$id = $request->id;
		$country 			= Country::find($id);
		$country->status 	= $request->status;
		$is_update 			= $country->update();
		if ($is_update) {
			$msg['status'] 	= 1;
			$msg['data'] 	= "Status has been update successfully ...";
			return json_encode($msg);
		} else {
			$msg['status'] 	= 0;
			$msg['data'] 	= "some thing went wrong ...";
			return json_encode($msg);
		}
	}

	public function delete(Request $request) {
		$id = $request->id;
		if (!empty($id)) {
			$country = Country::where('id', $id)->delete();
			if ($country) {
				$msg['status'] 	= 1;
				$msg['data'] 	= "Record deleted successfully ...";
				return json_encode($msg);
			} else {
				$msg['status'] 	= 0;
				$msg['data'] 	= "some thing went wrong ...";
				return json_encode($msg);
			}

		} else {
			$msg['status'] = 0;
			$msg['data'] = "some thing went wrong ...";
			return json_encode($msg);
		}
	}
}

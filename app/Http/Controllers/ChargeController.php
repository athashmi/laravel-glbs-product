<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charge;
use DataTables,JavaScript;

class ChargeController extends Controller
{
    public function index(){
    	JavaScript::put([
			'del_url' => route('setting.charges.delete'),
		]);
    	return view('settings.charges.index');
    }
    public function getCharges(){
    	$charges 	= Charge::select('id','title','amount','applicable_module');
		return DataTables::of($charges)
			->editColumn('applicable_module',function($charge){
				$html 	='<div class="row">';
				foreach ($charge->applicable_module->name as $key => $value) {
					$html .='<div class="col-md-6">
        							<button type="button" class="btn btn-block btn-default btn-word-wrap">
										<span class="">
										</span>'.$value.'</button>
									</div>';
				} 
        		$html .= '</div>';

				return $html;
			})
			->rawColumns(['action','applicable_module'])
			->addColumn('action', function ($request_info) {
				return view('settings.charges.action-buttons', ['result' => $request_info, 'modal_id' => 'edit_charge_model'])->render();
			})->make(true);
    }
    public function store(){ 
    	$validatedData 				= 	request()->validate([
			'title' 				=> 	'required',
			'amount'				=>	'required|numeric',
			'applicable_module' 	=>  'required', 
		]);
		$key = str_replace(' ', '_', request()->title);
		$applicable_module = request()->applicable_module;
		$data = [];
		$charges_obj = new Charge();		
		$charges_obj->title = request()->title;
		$charges_obj->amount = request()->amount; 
		$charges_obj->key = $key;
		foreach ($applicable_module as $key => $value) {
			$data['name'][] = $value;
		}
		$charges_obj->applicable_module = $data;
		$is_saved = $charges_obj->save();
		if($is_saved){
			$msg['status'] = 1; 
		}else{
			$msg['status'] = 0;
		}
		return json_encode($msg);
	}
	public function edit(){
		$id = request()->id;
		$charges_obj = Charge::find($id);
		if($charges_obj){
			$msg['status'] = 1;
			$msg['total'] = sizeof($charges_obj->applicable_module->name);
			$msg['data'] = $charges_obj;
		}else{
			$msg['status'] = 0;
		}
		return json_encode($msg);
	}
	public function update(){
		$id = request()->id;
		$validatedData 				= 	request()->validate([
			'title' 				=> 	'required',
			'amount'				=>	'required|numeric',
			'applicable_module' 	=>  'required', 
		]);
		if(!empty($id)){
			$data = [];
			$key = str_replace(' ', '_', request()->title);
			$applicable_module = request()->applicable_module;
			$charges_obj = Charge::find($id);
			$charges_obj->title = request()->title;
			$charges_obj->key = $key;
			$charges_obj->amount = request()->amount;
			foreach ($applicable_module as $key => $value) {
				$data['name'][] = $value;
			}
			$charges_obj->applicable_module = $data;
			$is_updated = $charges_obj->update();
			if($is_updated){
				$msg['status'] = 1;
			}else{
				$msg['status'] = 0;
			}
		}else{
			$msg['status'] = 0;
		}
		return json_encode($msg);
	}
	public function delete(){
		$id = request()->id;
		$is_deleted = Charge::find($id)->delete();
		if ($is_deleted) {
			$msg['status'] = 1;
		}else{
			$msg['status'] = 0;
		}
		return response()->json($msg);
	}
}
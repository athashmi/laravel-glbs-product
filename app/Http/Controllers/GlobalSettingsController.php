<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables,JavaScript;
use App\Option;
class GlobalSettingsController extends Controller
{
     public function index(){
    	JavaScript::put([
			'del_url' => route('setting.global.delete'),
		]);
    	return view('settings.global.index');
    }


    public function getSettings(){
    	$settings 	= Option::where('module','global');
		return DataTables::of($settings)
			
			->rawColumns(['action'])
			->addColumn('action', function ($request_info) {
				return view('settings.global.action-buttons', ['result' => $request_info, 'modal_id' => 'edit_global_setting_model'])->render();
			})->make(true);
    }


     public function store(){ 
    	$validatedData 				= 	request()->validate([
			'title' 				=> 	'required',
			'value'					=>	'required',
			
		]);
		$key = strtolower(str_replace(' ', '_', request()->title));

		$key_exist = Option::where('module','global')
							->where('key',$key)
							
							->first();
		if($key_exist)
		{
			return response()->json(['errors'=>[0=>'Record with same title already exists.']],422);
		}
		
		$data = [];
		$new_setting = new Option();		
		$new_setting->title = request()->title;
		
		$new_setting->key = $key;

		$new_setting->module = 'global';
		$new_setting->value = request()->value;
		$is_saved = $new_setting->save();
		if($is_saved){
			$msg['status'] = 1; 
		}else{
			$msg['status'] = 0;
		}
		return json_encode($msg);
	}
	public function edit(){
		$id = request()->id;
		$option_obj = Option::find($id);
		if($option_obj){
			$msg['status'] = 1;
			
			$msg['data'] = $option_obj;
		}else{
			$msg['status'] = 0;
		}
		return json_encode($msg);
	}
	public function update(){
		$id = request()->id;
		$validatedData 				= 	request()->validate([
			'title' 				=> 	'required',
			'value'					=>	'required',
		]);
		if(!empty($id)){
			$data = [];
			$key = str_replace(' ', '_', request()->title);

			$key_exist = Option::where('module','global')
								->where('key',$key)
								->where('id','!=',$id)
								->first();
			if($key_exist)
			{
				return response()->json(['errors'=>[0=>'Record with same title already exists.']],422);
			};
			$option_obj = Option::find($id);
			$option_obj->title = request()->title;
			$option_obj->key = $key;
			$option_obj->value = request()->value;
			dd($option_obj);
			$is_updated = $option_obj->update();
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
		$is_deleted = Option::find($id)->delete();
		if ($is_deleted) {
			$msg['status'] = 1;
		}else{
			$msg['status'] = 0;
		}
		return response()->json($msg);
	}
}

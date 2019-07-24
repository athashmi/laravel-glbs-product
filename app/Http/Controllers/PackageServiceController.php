<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PackageService;
use DataTables;
use Illuminate\Validation\Rule;
use JavaScript;

class PackageServiceController extends Controller
{
    public function index(){
    	JavaScript::put([
			'del_url' => route('package.services.delete'),
		]);
    	return view('packages.services.index');
    }
    public function getPackageServices($type){
    	if($type == 'free'):
    		$result = PackageService::select('id', 'title', 'description', 'status','type','amount', 'created_at')->where('type',$type);
    	endif;
    	if($type == 'paid'):
    		$result = PackageService::select('id', 'title', 'description', 'status','type','amount', 'created_at')->where('type',$type);
    	endif;
    	 
		return DataTables::of($result)
			->editColumn('status',function($result){
				if($result->status == 'active'):
					return '<label class="label label-primary">Active</label>';
				endif;
				if($result->status == 'in_active'):
					return '<label class="label label-danger">InActive</label>';
				endif;	
			})
			->rawColumns(['status','action'])
			->addColumn('action', function ($result) {
				return view('packages.services.action-buttons', ['result' => $result, 'modal_id' => 'edit_service_model'])->render();
			})->make(true);
    }

    public function store(){
    	$title = request()->title;
    	$key = str_replace(' ','_', strtolower($title));
    	$validate_data = [
			'description'      	=> 'required',
			'type'				=> 'required',
		];
		if(request()->type == 'free'){
			$validate_data['title'] = ['required',
							Rule::unique('package_services')->where(function ($query) use ($key) {
			            		return $query->where('key', $key);
			        		})
        				];
		}
		if(request()->type == 'paid'){
			$validate_data['amount'] = 'required|numeric';
			$validate_data['title']  =  ['required',
							Rule::unique('package_services')->where(function ($query) use ($key) {
			            		return $query->where('key', $key);
			        		})
        				];
		}
		$validatedData = request()->validate($validate_data);
		$package_service 				= new PackageService();
		$package_service->title 		= request()->title;
		$package_service->description 	= request()->description;
		$package_service->key 			= $key;
		$package_service->status 		= 'active';
		if(request()->type == 'free'){
			$package_service->type     	= 'free';
		}
		if(request()->type == 'paid'){
			 $package_service->amount   = request()->amount;
			 $package_service->type     = 'paid'; 
		}
		
		$is_saved = $package_service->save();
		if ($is_saved) {
			$msg['status'] = 1;
			return json_encode($msg);
		} else {
			$msg['status'] = 0;
			return json_encode($msg);
		}
    }
    public function edit(){
    	$id = request()->id;
		//dd($id);
		if (!empty($id)) {
			$result = PackageService::find($id);
			if (isset($result->id)) {
				$msg['status'] = 1;
				$msg['data'] = $result;
				return json_encode($msg);
			} else {
				$msg['status'] = 0;
				$msg['data'] = "Data not found...";
				return json_encode($msg);
			}
		}
    }
    public function update(){
    	$title = request()->title;
    	$id    = request()->s_id;
    	$key = str_replace(' ','_', strtolower($title));
    	$validate_data = [
			'description'      	=> 'required',
			'type'				=> 'required',
		];
		if(request()->type == 'free'){
			$validate_data['title'] = ['required',
							Rule::unique('package_services')->where(function ($query) use ($key,$id) {
			            		return $query
			            		        ->where('key', $key)
			            		        ->where('id','!=',$id);
			        		})
        				];
		}
		if(request()->type == 'paid'){
			$validate_data['amount'] = 'required|numeric';
			$validate_data['title']  =  ['required',
							Rule::unique('package_services')->where(function ($query) use ($key,$id) {
			            		return $query
			            		        ->where('key', $key)
			            		        ->where('id','!=',$id);
			        		})
        				];
		}
		$validatedData = request()->validate($validate_data);
		$package_service 				= PackageService::find($id);
		$package_service->title 		= request()->title;
		$package_service->description 	= request()->description;
		$package_service->key 			= $key;
		$package_service->status 		= 'active';
		if(request()->type == 'free'){
			$package_service->type     	= 'free';
		}
		if(request()->type == 'paid'){
			 $package_service->amount   = request()->amount;
			 $package_service->type     = 'paid'; 
		}
		
		$is_saved = $package_service->update();
		if ($is_saved) {
			$msg['status'] = 1;
			return json_encode($msg);
		} else {
			$msg['status'] = 0;
			return json_encode($msg);
		}
    }
    public function changeStatus(){
    	$id = request()->id;
    	if(!empty($id)){
    		$package_service = PackageService::where('id',$id)->first();
    		$package_service->status = request()->status;
    		$is_status_update = $package_service->update();
    		if($is_status_update){
    			$msg['status'] = 1;
    			return json_encode($msg);
    		}else{
    			$msg['status'] = 0;
    			return json_encode($msg);
    		}
    	}
    }
    public function delete(){
    	 $id = request()->id;
		if (!empty($id)) {
			$package_service = PackageService::where('id', $id)->delete();
			if ($package_service) {
				$msg['status'] 	= "1"; 
				return json_encode($msg);
			} else {
				$msg['status'] 	= "0"; 
				return json_encode($msg);
			}

		}
    }
}

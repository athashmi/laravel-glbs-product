<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PackageCustomCategory;
use DataTables;
use JavaScript;
use Illuminate\Validation\Rule;

class PackageCategoryController extends Controller
{
    public function index(){
    	JavaScript::put([
			'del_url' => route('package.categories.delete'),
		]);
    	return view('packages.categories.index');
    }
    public function getPackageCategories(){
    	$result = PackageCustomCategory::select('*');
		return DataTables::of($result)
			->addColumn('action', function ($result) {
				return view('packages.services.action-buttons', ['result' => $result, 'modal_id' => 'edit_package_category'])->render();
			})->make(true);
    }
    public function store(){
    	$title = request()->title;
		$key = str_replace(' ', '_', strtolower($title));
    	$validatedData = request()->validate([
			'title' => ['required',
							Rule::unique('package_custom_categories')->where(function ($query) use ($key) {
			            		return $query->where('key', $key);
			        		})
        				]
		]);
		
		$package_category = new PackageCustomCategory;
		$package_category->title = $title;
		$package_category->key = $key;
		$is_saved = $package_category->save();
		if($is_saved){
			$msg['status'] = 1;
			return json_encode($msg);
		}else{
			$msg['status'] = 0;
			return json_encode($msg);
		}
    }
    public function edit(){
    	$id = request()->id;
    	$package_category = PackageCustomCategory::find($id);
    	if($package_category){
    		$msg['status'] = 1;
    		$msg['data'] = $package_category;
    		return json_encode($msg);
    	}else{
    		$msg['status'] = 0;
    		return json_encode($msg);
    	}
    }
    public function update(){
    	$id 				= request()->id;
    	$title = request()->title;
		$key = str_replace(' ', '_', strtolower($title));
		$validatedData 		= request()->validate([
			'title' => ['required',
							Rule::unique('package_custom_categories')->where(function ($query) use ($key,$id) {
			            		return $query
			            		        ->where('key', $key)
			            				->where('id','!=',$id);
			        		})
        				]
		]);
		
		if (!empty($id)){
			$result 	= PackageCustomCategory::find($id);
			$result->title = $title;
			$result->key   = $key;
			$is_update 	= $result->update();
			if ($is_update){
				$msg['status'] 	= 1;
				return json_encode($msg);
			}else{
				$msg['status'] 	= 0;
				return json_encode($msg);
			}
		}
    }
    public function delete(){
    	$id = request()->id;
    	if (!empty($id)) {
			$package_category = PackageCustomCategory::where('id', $id)->delete();
			if ($package_category) {
				$msg['status'] 	= "1";
				return json_encode($msg);
			} else {
				$msg['status'] 	= "0";
				return json_encode($msg);
			}
		}
    }
}

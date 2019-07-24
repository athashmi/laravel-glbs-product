<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\ConsolidationRequestInfo;
use Illuminate\Validation\Rule;
use JavaScript;

class ConsolidationRequestInfoController extends Controller
{
    public function index(){
    	JavaScript::put([
			'del_url' => route('consolidation.request_info.delete'),
		]);
    	return view('consolidation.request-infos.index');
    }
    public function getRequestInfos(){
    	$request_infos 	= ConsolidationRequestInfo::select('id','title','description');
		return DataTables::of($request_infos)
			->rawColumns(['action'])
			->addColumn('action', function ($request_info) {
				return view('consolidation.request-infos.action-buttons', ['result' => $request_info, 'modal_id' => 'Editrequest_infoModel'])->render();
			})->make(true);
    }
    public function store(){
    	$key = str_replace(' ','_',request()->title);
    	$validatedData 		= 	request()->validate([
			'title' 		=> 	['required',
									Rule::unique('consolidation_request_infos')->where(function ($query) use($key){
					            		return $query->where('key', $key);
					        		})
		        				],
			'description' 	=> 	'required',
		]);

		$request_obj = ConsolidationRequestInfo::create([
															'title' => request()->title,
															'key'   => $key,
															'description' => request()->description
														]);
		if($request_obj){
			$msg['status'] = 1;
			return json_encode($msg);
		}else{
			$msg['status'] = 0;
			return json_encode($msg);
		}
    }
    public function delete(Request $request){
    	$id = $request->id;
		if (!empty($id)) {
			$country = ConsolidationRequestInfo::where('id', $id)->delete();
			if ($country) {
				$msg['status'] 	= 1; 
				return json_encode($msg);
			} else {
				$msg['status'] 	= 0; 
				return json_encode($msg);
			}

		} else {
			$msg['status'] = 0;
			$msg['data'] = "some thing went wrong ...";
			return json_encode($msg);
		}
    }
}

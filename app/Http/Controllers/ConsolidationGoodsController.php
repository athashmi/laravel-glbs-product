<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ConsolidationGoodsDescription;
use App\Courier;
use DataTables;
use JavaScript;

class ConsolidationGoodsController extends Controller
{
    public function index(){
    	JavaScript::put([
			'del_url' => route('consolidation.goods_description.delete'),
		]);
    	$couriers = Courier::where('status','active')->get();
    	return view('consolidation.goods-description.index',compact('couriers'));
    }
    public function getGoodsDescription(){
    	$goods_descriptions 	= ConsolidationGoodsDescription::select('id','title','description','amount','allowed_carriers');
		return DataTables::of($goods_descriptions)
			->editColumn('allowed_carriers',function($goods){
					$ids 	= $goods->allowed_carriers;

					$couriers = Courier::whereIn('id', $ids)
        			->get();

        			$html 	='<div class="row">';

        			foreach($couriers as $courier):

       					$html .='<div class="col-md-6">
        							<button type="button" class="btn btn-block btn-default btn-word-wrap">
										<span class="">'.$courier->title.'</button>
									</div>';
        			endforeach;
        			$html .= '</div>';

				return $html;
			})
			->rawColumns(['action','allowed_carriers'])
			->addColumn('action', function ($request_info) {
				return view('consolidation.goods-description.action-buttons', ['result' => $request_info, 'modal_id' => 'update_goods_description_model'])->render();
			})->make(true);
    }
    public function store(){
    	$validatedData 			= 	request()->validate([
			'title' 			=> 	'required',
			'amount'			=>	'required|numeric',
			'courier' 			=>  'required',
			'description' 		=> 	'required',
		]);
		$db_key = str_replace(' ', '_', request()->title);

		$key_exist = ConsolidationGoodsDescription::where('key',$db_key)->first();
		if($key_exist)
		{
			return response()->json(['errors'=>[0=>'Record with same title already exists.']],422);
			die();
		}
		$courier = [];
		foreach (request()->courier as $key => $value) {
			$courier[] = (int)$value;
		}
		$goods_obj = ConsolidationGoodsDescription::create([
															'title' 			=> request()->title,
															'amount'   			=> request()->amount,
															'description' 		=> request()->description,
															'allowed_carriers' 	=> $courier,
															'key'				=> $db_key
														]);
		if($goods_obj){
			$msg['status'] = 1;
			return json_encode($msg);
		}else{
			$msg['status'] = 0;
			return json_encode($msg);
		}
    }
    public function edit(){
    	$id = request()->id;
    	if(!empty($id)){
    		$goods_obj = ConsolidationGoodsDescription::find($id);
    		if($goods_obj){
    			$msg['status'] 	= 1;
    			$msg['data'] 	= $goods_obj;
    			return json_encode($msg);
    		}else{
    			$msg['status'] = 0;
    			return json_encode($msg);
    		}
    	}
    }
    public function update(){
    	$id = request()->id_u;
    	$validatedData 			= 	request()->validate([
			'title' 			=> 	'required',
			'amount'			=>	'required|numeric',
			'courier' 			=>  'required',
			'description' 		=> 	'required',
		]);
    	$courier = [];
		foreach (request()->courier as $key => $value) {
			$courier[] = (int)$value;
		}
    	$data = [
					'title' 			=> request()->title,
					'amount'   			=> request()->amount,
					'description' 		=> request()->description,
					'allowed_carriers' 	=> $courier,
				];
		$goods_obj = ConsolidationGoodsDescription::find($id);
		$is_updated = $goods_obj->update($data);
		if($is_updated){
			$msg['status'] = 1;
			return json_encode($msg);
		}else{
			$msg['status'] = 0;
			return json_encode($msg);
		}
    }
    public function delete(){
    	$id = request()->id;
    	$is_deleted = ConsolidationGoodsDescription::find($id)->delete();
    	if($is_deleted){
    		$msg['status'] = 1;
    		return json_encode($msg);
    	}else{
    		$msg['status'] = 0;
    		return json_encode($msg);
    	}
    }
}

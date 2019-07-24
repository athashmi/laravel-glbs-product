<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourierZone;
use App\Courier;
use App\Country;
use DataTables,JavaScript;


class DomesticCourierController extends Controller
{
    public function index(){
    	JavaScript::put([
			'del_url' => route('courier.domestic.delete'),
		]);
    	$countries = Country::all();
    	return view('courier-manipulation.domestic-courier.index',compact('countries'));
    }
    public function getDomesticCourier(){
    	$couriers = Courier::with('domesticCourier')->where('type','domestic');
		return DataTables::of($couriers)
			->addColumn('title', function ($courier) {
				return $courier->title;
			})
			->editColumn('status', function ($courier) {
				if ($courier->status == 'active') {
					return '<label class="label label-primary">Active</label>';
				}
				if ($courier->status == 'inactive') {
					return '<label class="label label-danger">Inactive</label>';
				} else {
					return '<label class="label label-danger">closed</label>';
				}
			})
			->addColumn('country', function ($courier) {
				$ids 	= $courier->domesticCourier->country_ids;

					$countries = Country::whereIn('id', $ids)
        			->get();
        			$html 	='';
        			foreach($countries as $ctry):

       					$html .='<div class="col-md-5 offset-md-3">
        							<button type="button" class="btn btn-block btn-default btn-word-wrap">
										<span class="">
										</span>'.$ctry->nice_name.'</button>
									</div>';
        			endforeach;
        			$html .= '';

				return $html;
			})
			->rawColumns(['status', 'action','country'])
			->addColumn('action', function ($courier) {
				return '<div class="dropdown dropdown-default">
							<button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Actions
							</button>
							<div class="dropdown-menu">
							<a class="dropdown-item" href="javascript:void(0)"  data-toggle="modal" data-id="'.$courier->id.'"   id="edit_id" data-target="#edit_domestic_courier_modal">Edit </a>
							<a class="dropdown-item" href="javascript:void(0)"  data-id="'.$courier->id.'" id="delete_id'.$courier->id.'" onclick=deleteById("'.$courier->id.'")>Delete</a>
							</div>
							</div>';
			})->make(true);
    }
    public function store(){
    	$validatedData = request()->validate([
			'c_name' => 'required',
			'c_title' => 'required',
			'country' => 'required'
		]);
		$domestic_courier = new Courier();
		$domestic_courier->title = request()->c_title;
		$domestic_courier->name  = request()->c_name;
		$domestic_courier->type  = 'domestic';
		$is_saved = $domestic_courier->save();
		if($is_saved){
			foreach (request()->country as $key => $value) {
				$data[] = (int)$value;
			}
			$domestic_zone_obj = new CourierZone();
			$domestic_zone_obj->title = request()->c_title;
			$domestic_zone_obj->country_ids = $data;
			$domestic_zone_obj->courier_id	= $domestic_courier->id;
			$domestic_zone_obj->save();
			$msg['status'] = 1;
		}else{
			$msg['status'] = 0;
		}
		return response()->json($msg);
    }
    public function edit(){
    	$id = request()->id;
    	$couriers = Courier::where('id',$id)
    	                     ->where('type','domestic')
    	                     ->with('domesticCourier')
    	                     ->first();
    	if($couriers){
    		$msg['status'] = 1;
    		$msg['data']   = $couriers;
    	}else{
    		$msg['status'] = 0;
    	}
    	return response()->json($msg);
    }
    public function update(){
    	$id = request()->id;
    	$validatedData = request()->validate([
			'name' => 'required',
			'title' => 'required',
			'country' => 'required'
		]);
    	$domestic_courier = Courier::where('id',$id)->where('type','domestic')->first();
    	if($domestic_courier){
    		$domestic_courier->title = request()->title;
    		$domestic_courier->name  = request()->name;
    		$is_updated = $domestic_courier->update();
    		if($is_updated){
    			foreach (request()->country as $key => $value) {
					$data[] = (int)$value;
				}
    			$courier_domestic = CourierZone::where('courier_id',$domestic_courier->id)->first();
    			if($courier_domestic){
    				$courier_domestic->title = request()->title;
    				$courier_domestic->country_ids = $data;
    				$courier_domestic->update();
    				$msg['status'] = 1;
    			}else{
    				$msg['status'] = 0;
    			}
    		}else{
    			$msg['status'] = 0;
    		}
    	}else{
    		$msg['status'] = 0;
    	}
    	return response()->json($msg);
    }

    public function delete(){
    	$id = request()->id;
    	$courier = Courier::where('id',$id)->where('type','domestic')->first();
    	$courier->delete();
    	$domestic = CourierZone::where('courier_id',$courier->id)->delete();
    	if($domestic){
    		$msg['status'] = 1;
    	}else{
    		$msg['status'] = 0;
    	}
    	return response()->json($msg);
    }
}

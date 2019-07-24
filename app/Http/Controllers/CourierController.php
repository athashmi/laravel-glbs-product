<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourierZone;
use JavaScript;
use App\Courier;
use App\Country; 
use Session;
use Excel;
use App\CourierRate;
use File;
use DataTables;
use App\Imports\CourierRateImport;

class CourierController extends Controller
{
	/************ 		Function return courier zone listing page    ***************/
    public function index() {
		JavaScript::put([
			'del_url' => route('courier.zone.deletezone'),
		]);
		$countries = Country::all();
		$couriers  = Courier::where('status','active')->get();
		return view('courier-manipulation.zone.index',compact('countries','couriers'));
	}
	/***********  		End function ***********************************************/

	public function getCourierZone(Request $request){
		$courier_zones = CourierZone::with('courier')->whereHas('courier',function($qry) use ($request){
			$qry->where('name',$request->courier_name);
		})
		//->with('countries')

		
		
		;
		return DataTables::of($courier_zones)
			->editColumn('courier.title', function ($courier_zone) {
				return $courier_zone->courier->title;
			})
			->editColumn('status', function ($courier_zone) {
				if ($courier_zone->courier->status == 'active') {
					return '<label class="label label-primary">Active</label>';
				}
				if ($courier_zone->courier->status == 'inactive') {
					return '<label class="label label-danger">Inactive</label>';
				} else {
					return '<label class="label label-danger">closed</label>';
				}
			})
			->editColumn('country_ids', function ($courier_zone) {
				$ids 	= $courier_zone->country_ids;

					$countries = Country::whereIn('id', $ids)
        			->get();

        			$html 	='<div class="row">';

        			foreach($countries as $ctry):

       					$html .='<div class="col-md-4">
        							<button type="button" class="btn btn-block btn-default btn-word-wrap">
										<span class="pull-right m-l-5" onclick="deleteCountry('.$ctry->id.','.$courier_zone->id.')"><i class="pg-close"></i>
										</span>'.$ctry->nice_name.'</button>
									</div>';
        			endforeach;
        			$html .= '</div>';

				return $html;
			})
			->rawColumns(['status', 'action','country_ids'])
			->addColumn('action', function ($courier_zone) {

				return '<div class="dropdown dropdown-default">
							<button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Actions
							</button>
							<div class="dropdown-menu">
							<a class="dropdown-item" href="javascript:void(0)"  data-toggle="modal" data-id="'.$courier_zone->id.'"  data-target="#Importrate" onclick="parsingId('.$courier_zone->id.')">Import Rate</a>
							<a class="dropdown-item" href="javascript:void(0)"  data-toggle="modal" data-id="'.$courier_zone->id.'"   id="edit_id" data-target="#EditCourierZoneModel">Edit </a>
							<a class="dropdown-item" href="javascript:void(0)"  data-id="'.$courier_zone->id.'" id="delete_id'.$courier_zone->id.'" onclick=deleteById("'.$courier_zone->id.'")>Delete</a>
							</div>
							</div>';

				/*return '<div class="btn-group dropdown-split-primary">
					
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
					<div class="dropdown-menu dropdown-menu-right b-none contact-menu">
					<a class="dropdown-item" href="javascript:void(0)"  data-toggle="modal" data-id="'.$courier_zone->id.'"  data-target="#Importrate" onclick="parsingId('.$courier_zone->id.')">Import Rate</a>
					<a class="dropdown-item"href="javascript:void(0)"  data-toggle="modal" data-id="'.$courier_zone->id.'"   id="edit_id" data-target="#EditCourierZoneModel"><i class="icofont icofont-edit"></i>Edit</a>
					<a class="dropdown-item" href="javascript:void(0)"  data-id="'.$courier_zone->id.'" id="delete_id'.$courier_zone->id.'" onclick=deleteById("'.$courier_zone->id.'") ><i class="icofont icofont-ui-delete"></i>Delete</a>


					</div>
					
					</div>';*/

				//return view('courier-manipulation.zone.action-buttons', ['result' => $courier_zone, 'modal_id' => 'EditCourierZoneModel','import_modal_id'=>'Importrate'])->render();


			})->make(true);
	}
	/**************   	Edit courier Zone ******************************************/
	public function edit(){
		$id = request()->id;
		if (!empty($id)) {
			$courier = CourierZone::with('courier')->where('id', $id)->first();
			if($courier) {
				$ids 						= $courier->country_ids;
				$data['status'] 			= 1;
				$data['data'] 				= $courier;
				$data['assigned_country'] 	= $ids;
				return json_encode($data);
				 
			}
		}
	}
	/****************   End Coureiwe Zone *****************************************/

	public function insertCourierZone(){
		$validatedData 	= request()->validate([
			'z_title' 	=> 'required',
		]);
			$courier_zone 				= new CourierZone();
			$courier_zone->title 		= request()->z_title;
			$courier_zone->courier_id 	= request()->courier_id;
			if(request()->country){
				$courier_zone->country_ids = request()->country; 
			}else{
				$courier_zone->country_ids = [];
			}
			$is_saved = $courier_zone->save();
			if ($is_saved) {
				$msg['status'] 	= 1;
				return json_encode($msg);
			}else{
				$msg['status'] 	= 0;
				return json_encode($msg);
			}	
	}
	/***************    Updtae Courier Zone ***************************************/
	public function update(){
		$id 				= request()->id;
		$validatedData 		= request()->validate([
			'title' 		=> 'required',
		]);
		if (!empty($id)) {
			$courier_zone 			= CourierZone::find($id);
			$courier_zone->title 	= request()->title;
			if(request()->country){
				$courier_zone->country_ids = request()->country; 
			}else{
				$courier_zone->country_ids = [];
			}
			$is_update = $courier_zone->update();
			if($is_update){
				$msg['status'] 	= "1";
				$msg['msg'] 	= "Information has been update successfully ...";
				return json_encode($msg);
			}else {
				$msg['status'] 	= "0";
				$msg['msg'] 	= "Some thing went wrong...";
				return json_encode($msg);
			}	
			}else {
				$msg['status'] 	= "0";
				$msg['msg'] 	= "Some thing went wrong...";
				return json_encode($msg);
			}
	}
	/***************    End Update courier Zone *************************************/

	/*************** Individuly Delete country in Courier zone ********************/
	public function deleteCountry(){
		$id = request()->id;
		$request_country_id 	= request()->country_id;
		$courier_zone 			= CourierZone::where('id',$id)->first();
		$ids 					= $courier_zone->country_ids;
		$country 				= [];
		foreach ($ids as $key => $country_id) {
				if($request_country_id == $country_id){
					continue;
				}
				$country[] = $country_id;
		}
		if(sizeof($country) > 0){
			$courier_zone->country_ids = $country;
		}else{
			$courier_zone->country_ids = [];
		}
		$is_update = $courier_zone->update();
		if($is_update){
			$msg['status'] = 1;
			return json_encode($msg);
		}else{
			$msg['status'] = 0;
			return json_encode($msg);
		}
	}
	/******************** End **************************************************/

	public function deleteZone(){
		$id 			= request()->id;
		$courier_zone 	= CourierZone::where('id',$id)->first();
		$courier_zone->courierRate()->delete();
		$is_del = $courier_zone->delete();
		if($is_del){
			$msg['status'] = 1;
			return json_encode($msg);
		}else{
			$msg['status'] = 0;
			return json_encode($msg);
		}
	}



	public function courier(){
		JavaScript::put([
			'del_url' => route('courier.delete'),
		]);
		return view('courier-manipulation.courier.index');
	}
	public function getCourier(Request $request){
		$couriers = Courier::all();
		return DataTables::of($couriers)
			->rawColumns(['action'])
			->addColumn('action', function ($courier) {
				
				return '

					<div class="btn-group">
						
						<button type="button" class="btn btn-default" data-toggle="modal" data-id="'.$courier->id.'"   id="edit_id" data-target="#EditCourierModel"><i class="fa fa-pencil"></i>
						</button>
						<button type="button" class="btn btn-default" data-id="'.$courier->id.'" id="delete_id'.$courier->id.'" onclick=deleteById("'.$courier->id.'") ><i class="fa fa-trash-o"></i>
						</button>
						</div>';
				//return view('courier-manipulation.courier.action-buttons', ['result' => $courier, 'modal_id' => 'EditCourierModel'])->render();
			})
			->make(true);
	}
	public function insertCourier(){
		$validatedData 	= request()->validate([
			"c_name" 	=> "required",
			'c_title' 	=> 'required',
		]);
		$courier = Courier::create([
			'name' 	 => request()->c_name,
			'title'  => request()->c_title,
		]);
		if($courier){
			$msg['status'] = 1;
			return json_encode($msg);
		}else{
			$msg['status'] = 0;
			return json_encode($msg);
		}
	}
	public function editCourier(){
		$id = request()->id;
		$courier = Courier::find($id);
		if($courier){
			$msg['status'] 	= 1;
			$msg['data'] 	= $courier;
			return json_encode($msg);
		}else{
			$msg['status'] 	= 0;
			return json_encode($msg);
		}
	}
	public function updateCourier(){
		$id = request()->id;
		$validatedData 	= request()->validate([
			"name" 	=> "required",
			'title' => 'required',
		]);
		$courier = Courier::find($id);
		$courier->name  = request()->name;
		$courier->title = request()->title;
		$is_updated = $courier->update();
		if($is_updated){
			$msg['status'] = 1;
			return json_encode($msg);
		}else{
			$msg['status'] = 0;
			return json_encode($msg);
		}
	}
	public function deleteCourier(){
		$id = request()->id;
		$courier 	= Courier::where('id',$id)->first();
		foreach($courier->courier_zone as $zone){
			$zone->courierRate()->delete();
		}
		$courier->courier_zone()->delete();
		$is_del = $courier->delete();
		if($is_del){
			$msg['status'] = 1;
			return json_encode($msg);
		}else{
			$msg['status'] = 0;
			return json_encode($msg);
		}
	}
	public function importRates(Request $request){ 
		if($request->hasFile('file')){
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xls") {
                $path = $request->file->getRealPath();
                $data = Excel::toArray(new CourierRateImport, request()->file('file'));
                $data = $data[0];
                if($data[0][0] == 'weight' && $data[0][1] == 'amount'){
                	
                	foreach($data as $d){
                		$courier_obj = CourierRate::where('weight',$d[0])->where('courier_zone_id',request()->id)->first();
                		if($courier_obj){
		                	if($d[0] == 'weight'){continue;}
		                	if($d[1] == 'amount'){continue;}
		                	$courier_obj->weight = $d[0];
		                	$courier_obj->amount = $d[1];
		                	$courier_obj->courier_zone_id = request()->id;
		                	$courier_obj->update();
                		}else{
                			$courier_rate = new CourierRate;
		                	if($d[0] == 'weight'){continue;}
		                	if($d[1] == 'amount'){continue;}
		                	$courier_rate->weight = $d[0];
		                	$courier_rate->amount = $d[1];
		                	$courier_rate->courier_zone_id = request()->id;
		                	$courier_rate->save();
                		}
	                	
                	}
                	$msg['status'] = 1;
                	return json_encode($msg);
                	exit; 
                } else{
                	$msg['status'] = 0;
                	$msg['msg']    = 'please follow the above pattern.';
                	return json_encode($msg);
                }
        	}else{
        		$msg['status'] = 0;
                $msg['msg']    = 'Please pick only xls file.';
                return json_encode($msg);
        	}
		}else{
			$msg['status'] = 0;
            $msg['msg']    = 'Please Choose file.';
            return json_encode($msg);
		}
	}
	
}

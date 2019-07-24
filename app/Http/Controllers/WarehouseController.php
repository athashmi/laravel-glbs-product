<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Warehouse;
use App\Country;
use JavaScript;
use App\WarehouseShelf;
use DataTables;
use App\Events\WareHouseStausEvent;
use Illuminate\Validation\Rule;

class WarehouseController extends Controller
{

 function __construct()
    {
    	JavaScript::put([
			'del_url' => route('warehouse.delete'),
		]);
    }

    public function index() {
		
		$countries = Country::all();
		return view('warehouses.list.index')->with('countries',$countries);
	}

	public function getwarehouses() {
		$warehouses = Warehouse::select('*');
		return DataTables::of($warehouses)
			->editColumn('status', function ($warehouse) {
				if($warehouse->status == 'active')
				{
					return '<label class="label label-success">Active</label>';
				}
				if($warehouse->status == 'inactive')
				{
					return '<label class="label label-danger">Inactive</label>';
				}
				else
				{
					return '<label class="label label-danger">closed</label>';
				}
			})
			->editColumn('country',function($warehouse){
				return $warehouse->country->name;
			})
			->rawColumns(['status', 'action'])
			->addColumn('action', function ($warehouse) {
				return view('warehouses.list.action-buttons', ['result' => $warehouse,'modal_id' => 'edit_warehouse_model'])->render();
			})->make(true);
	}

	public function store(Request $request) {
		$validatedData = $request->validate([
			'name' => 'required',
			'email' => 'required|email',
			'phone' => 'required',
			'street' => 'required',
			'city' => 'required',
			'state' => 'required',
			'country_id' => 'required'
		]);
		$warehouse = new Warehouse($request->all());
		$is_saved = $warehouse->save();
		if ($is_saved) {
			$msg['status'] = 1;
			$msg['msg'] = "Information has been saved successfully ...";
			return json_encode($msg);
		} else {
			$msg['status'] = 0;
			$msg['msg'] = "Some thing went wrong...";
			return json_encode($msg);
		}
	}
	public function edit(Request $request) {
		$id = $request->id;
		//dd($id);
		if (!empty($id)) {
			$result = Warehouse::find($id);
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

	public function update(Request $request) {
		$id = $request->id;
		$validatedData = $request->validate([
			'name' => 'required',
			'email' => 'required|email',
			'phone' => 'required',
			'street' => 'required',
			'city' => 'required',
			'state' => 'required',
			'country_id' => 'required'
		]);
		if (!empty($id)) {
			$warehouse = Warehouse::find($id);
			$is_update = $warehouse->update($request->all());
			if ($is_update) {
				$msg['status'] = "1";
				$msg['msg'] = "Information has been update successfully ...";
				return json_encode($msg);
			} else {
				$msg['status'] = "0";
				$msg['msg'] = "Some thing went wrong...";
				return json_encode($msg);
			}
		}
	}
	public function update_status(Request $request){
		$id = $request->id;
		$warehouse = Warehouse::find($id);
		$warehouse->status = $request->status;
		$is_update = $warehouse->update();
		
		if ($is_update) {
				broadcast(new WareHouseStausEvent($warehouse));
				$msg['status'] = 1;
				$msg['data'] = "Status has been update successfully ...";
				return json_encode($msg);
			} else {
				$msg['status'] = 0;
				$msg['data'] = "some thing went wrong ...";
				return json_encode($msg);
			}
	}

	public function delete(Request $request) {
		$id = $request->id;
		if (!empty($id)) {
			$warehouse = Warehouse::where('id', $id)->delete();
			if ($warehouse) {
				$msg['status'] = 1;
				$msg['data'] = "Record deleted successfully ...";
				return json_encode($msg);
			} else {
				$msg['status'] = 0;
				$msg['data'] = "some thing went wrong ...";
				return json_encode($msg);
			}

		}
	}

	public function ShelvesIndex(){
		JavaScript::put([
			'del_url' => route('warehouse.shelves.deleteshelf'),
		]);
		$warehouses = Warehouse::all();
		return view('warehouses.shelves.index')->with('warehouses',$warehouses);
	}

	public function getShelves($type) {
		if($type == 'package'){
			$shelves = WarehouseShelf::with('warehouse')->where('usage_type',$type)->select('*');
		}
		if($type == 'consolidated'){
			$shelves = WarehouseShelf::with('warehouse')->where('usage_type',$type)->select('*');
		}
		return DataTables::of($shelves)
			->editColumn('status', function ($shelf) {
				if($shelf->status == 'partially_full')
				{
					return '<label class="label label-success">Partially Full</label>';
				}
				if($shelf->status == 'full')
				{
					return '<label class="label label-danger">Full</label>';
				}
			})
			->editColumn('color',function($shelf){
				if($shelf->usage_type == 'package'){
					return '';
				}else{


					$bg_class = '';
					$txt_class = 'text-black';

					if($shelf->color=='white' )
					{
							$bg_class = 'bg-danger-darker';
							$txt_class = 'text-white';
					}

					

					
					return '<div class="col-12 col-md-12 border '.$bg_class.'   '.$txt_class.' m-b-10 no-padding">
							<p class="pull-left no-margin p-t-10 p-b-10 font-montserrat all-caps semi-bold small col-md-6">'.$shelf->color.'</p>
							<p class="pull-right no-margin p-t-10 p-b-10 col-md-6" style="background-color:'.$shelf->color.'">&nbsp;</p>
							<div class="clearfix"></div>
							</div>
							';

					
				}

			})
			->addColumn('warehouse_name',function($shelf){
				//dd($shelf);
				if($shelf->warehouse != NULL)
					return $shelf->warehouse->name;
				else
					return '';
			})
			->rawColumns(['status', 'action','warehouse.name','color'])
			->addColumn('action', function ($warehouse) {
				return view('warehouses.shelves.action-buttons', ['result' => $warehouse,'modal_id' => 'edit_shelf_model'])->render();
			})->make(true);
	} 

	public function insertShelf(){
		$validate_data = [
			'warehouse' => 'required|numeric',
			'type'      => 'required'
		];
		if(request()->type == 'package'){
			$validate_data['name'] = ['required',
							Rule::unique('warehouse_shelves')->where(function ($query) {
			            		return $query->where('name', request()->name)
			            		->where('warehouse_id', request()->warehouse);
			        		})
        				];
		}
		if(request()->type == 'consolidated'){
			$validate_data['color'] = 'required';
			$validate_data['name']  =  ['required',
							Rule::unique('warehouse_shelves')->where(function ($query) {
			            		return $query->where('name', request()->name)
			            		->where('warehouse_id', request()->warehouse)
			            		->where('color' , request()->color);
			        		})
        				];
		}

		$validatedData = request()->validate($validate_data);
		$warehouse_shelf 				= new WarehouseShelf();
		$warehouse_shelf->name 			= request()->name;
		$warehouse_shelf->warehouse_id 	= request()->warehouse;
		$warehouse_shelf->usage_type 	= request()->type;
		if(request()->type == 'package'){
			$warehouse_shelf->color     = 'none';
			$warehouse_shelf->status    = 'partially_full';
		}
		if(request()->type == 'consolidated'){
			 $warehouse_shelf->color     = request()->color; 
		}
		
		$is_saved = $warehouse_shelf->save();
		if ($is_saved) {
			$msg['status'] = 1;
			return json_encode($msg);
		} else {
			$msg['status'] = 0;
			return json_encode($msg);
		}
	}

	public function editShelf(){
		$id = request()->id;
		$warehouseshelf = WarehouseShelf::where('id',$id)->first();
		if($warehouseshelf){ 
			$msg['status'] 	= 1;
			$msg['data']	= $warehouseshelf;
			return json_encode($msg); 
			exit;
		}else {
			$msg['status'] = 0;
			return json_encode($msg);
		}
	}

	public function updateShelf(){
		$id 		   = request()->id;
		$validate_data = [
			'warehouse' => 'required|numeric',
			'type'      => 'required'
		];
		if(request()->type == 'package'){
			$validate_data['name'] = ['required',
							Rule::unique('warehouse_shelves')->where(function ($query) use($id) {
			            		return $query->where('name', request()->name)
			            		->where('warehouse_id', request()->warehouse)
			            		->where('id','!=',$id);
			        		})
        				];
		}
		if(request()->type == 'consolidated'){
			$validate_data['color'] = 'required';
			$validate_data['name']  =  ['required',
							Rule::unique('warehouse_shelves')->where(function ($query) use($id) {
			            		return $query->where('name', request()->name)
			            		->where('warehouse_id', request()->warehouse)
			            		->where('color' , request()->color)
			            		->where('id','!=',$id);
			        		})
        				];
		}
		$validatedData  = request()->validate($validate_data);
		
		$warehouse_shelf 				= WarehouseShelf::where('id',$id)->first();
		$warehouse_shelf->name 			= request()->name;
		$warehouse_shelf->warehouse_id 	= request()->warehouse;
		$warehouse_shelf->usage_type 	= request()->type;
		if(request()->type == 'package'){
			$warehouse_shelf->color     = 'none';
			$warehouse_shelf->status    = 'partially_full';
		}
		if(request()->type == 'consolidated'){
			 $warehouse_shelf->color     = request()->color;
			 $warehouse_shelf->status    = 'empty';
		}
		$is_updated 					= $warehouse_shelf->update();
		if($is_updated){
			$msg['status'] = 1;
			return json_encode($msg);
		}else{
			$msg['status'] = 0;
			return json_encode($msg);
		}
	}

	public function deleteShelf(){
		$id = request()->id;
		$warehouse_shelf = WarehouseShelf::where('id',$id)->first();
		$is_deleted = $warehouse_shelf->delete();
		if($is_deleted){ 
			$msg['status'] = 1;
			$msg['data']   = "Information has been deleted successfully ...";
			return json_encode($msg);  
		}else {
			$msg['status'] = 0;
			$msg['data']   = "some thing went wrong ...";
			return json_encode($msg);
		}
	}

	public function updateStatusShelf(){ 
		$id = request()->id;
		$warehouse_shelf = WarehouseShelf::find($id);
		$warehouse_shelf->status = request()->status;
		$is_update = $warehouse_shelf->update();
		if ($is_update) {
			$msg['status'] = 1;
			$msg['data'] = "Status has been update successfully ...";
			return json_encode($msg);
		} else {
			$msg['status'] = 0;
			$msg['data'] = "some thing went wrong ...";
			return json_encode($msg);
		}
	}

}

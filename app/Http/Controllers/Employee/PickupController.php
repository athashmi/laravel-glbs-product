<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

use Auth,DataTables,Helper,Carbon;
use App\ConsolidationRequest;
use App\Option;
use App\Package;
use App\Task;
use App\TaskDetail;
use App\PackageDetail;
use App\WarehouseShelf;
use App\Events\PackageLogEvent;

class PickupController extends EmployeeController
{
    public function index(){

    	//dd(session()->get('sort_shelves'));
    	$packages =[];
    	return view('employee.pickup.index',compact('packages'));
    }

    public function pickPackages()
    {
    	//dd(request()->all());
    	$requests_limit_per_day = Helper::dbConfigValue('global','consolidation_requests_limit_per_day');

    	$cons_reqsts =  ConsolidationRequest::where('status','preparing')
    										->orderBy('created_at','ASC')
    										->whereNull('assigned_to')
    										->limit($requests_limit_per_day)
    										->select('id')
    										->get()
    										->pluck('id');

    	//dd($cons_reqsts);
		
    	if(request()->racks):

			$pickup_packages = Package::with(['warehouseShelf',
											  'primaryThumbnail',
											  'parentPackage',
											  'parentPackage.primaryThumbnail'
											])
			
								->whereHas('warehouseShelf',function($qry){
									
									foreach (request()->racks as $key=>$rack_name) {
										if($key==0)
											$qry->where('name','like','%'.$rack_name.'%');
										else
											$qry->orWhere('name','like','%'.$rack_name.'%');
									}
								})
								->whereIn('consolidation_request_id',$cons_reqsts)
								->where('pick_status','available')
								->where('status','!=','missing')
								->get()
								//->toArray()
								//->keyBy('warehouseShelf.name')
								;
		else:
			$pickup_packages = Package::whereIn('consolidation_request_id',$cons_reqsts)
										->with(['warehouseShelf',
												'primaryThumbnail',
												'parentPackage'
											  ])
										->where('pick_status','available')
										->where('status','!=','missing')
										->get()
										//->toArray()
										//->keyBy('warehouseShelf.name')
										;
		endif;
		//dd($pickup_packages);

		request()->flash();
			
		/*$arr = array_multisort(array_map(function($element) {
			//dd($element);
				      return $element['warehouse_shelf']['name'];
				  }, $packages), SORT_ASC, $packages);*/

		$pkgs = [];
		//dd($pickup_packages);

		  foreach ($pickup_packages as $package) {
		  	$pkg =[];

		  	$pkg['id']= $package->id;
		  	$pkg['tracking_no']= $package->tracking_number;
		  	$pkg['consolidation_request_id']= $package->consolidation_request_id;
		  	$pkg['shopaholic_id']= $package->shopaholic_id;
		  	$pkg['warehouse_loc']= $package->warehouseShelf->name;
		  	if($package->primaryThumbnail)
		  	$pkg['image']= $package->primaryThumbnail->image_name;
		  	else
		  	{
		  		$pkg['image']= $package->parentPackage->primaryThumbnail->image_name;
		  	}
		  	
		  	$pkgs[] = $pkg;
		  }
		  //dd($pkgs);

		  $warehouse_loc  = array_column($pkgs, 'warehouse_loc');
		  array_multisort($warehouse_loc, SORT_ASC, $pkgs);

			//dd($pkgs);
		  $packages = $pkgs;
		  


		return view('employee.pickup.index',compact('packages'));
    	
    }
    

    function updatePackageStatus(){

    	//dd(request()->all());
    	if(request()->status == 'missing')
    	{
    		$package = Package::where('id',request()->package_id)->first();
	    	$package->status = 'missing';
	    	$package->save();

	    	$pkg_detail 				= new PackageDetail;
	    	$pkg_detail->package_id 	= request()->package_id;
	    	$pkg_detail->action_status 	= 'missing';
	    	$pkg_detail->action_by 		= Auth::user()->employee->id;

	    	$pkg_detail->save();

	    	$msg['status'] 	= 1;
			$msg['msg'] 	= "Package reported missing successfully ...";
			return json_encode($msg);
    	}
    	else
    	{
	    	$package 				= Package::where('id',request()->package_id)->first();
	    	$package->pick_status 	= 'picked';
	    	$package->save();

	    	$existing_pkg_detail 		= PackageDetail::where('action_status','picked')->where('package_id',request()->package_id)->first();

	    	if($existing_pkg_detail)
	    	{
	    		$existing_pkg_detail->delete();
	    	}

	    	$rqst = ['cart'=>request()->cart,
	    									'cart_section_color'=>request()->cart_section_color];
	    	$prev_status = ''; 

	    	 event(new PackageLogEvent($package,'picked',$prev_status,$rqst));
                    

	    	$msg['status'] 		= 1;
			$msg['msg'] 		= "Package picked successfully ...";
			return json_encode($msg);
	    }

    }

    function endTask()
    {
    	$start_time = request()->start_time;
    	//dd('strt='.$start_time.'---------end='.Carbon::now());

    	$task       = Task::where('title','pick')->first();

    		$task_detail                = new TaskDetail();
            $task_detail->ended_at      = Carbon::now();
            $task_detail->end_status    = 'task_ended';
            $task_detail->task_id       = $task->id;
            $task_detail->employee_id   = $this->employee_id;
            
            $task_detail->started_at    = $start_time;
            $is_saved 					= $task_detail->save();
             if($is_saved){
                $msg['status'] = 1;
                $msg['msg'] 		= "Task ended successfully ...";
            }else{
                $msg['status'] = 0;
            }

            return json_encode($msg);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shopaholic;
use App\User;
use App\Employee;
use App\ConsolidationRequest;
use App\ConsolidationRequestInfo;
use App\Package;
use App\WarehouseShelf;
use App\ConsolidationGoodsDescription;
use App\PackageService;
use App\ConsolidationBoxDetail;
use DataTables,Helper,DB,JavaScript;
use App\Jobs\ConsolidationRequestLabelGenerate;
use App\Events\ConsolidationLogEvent;
use App\ConsolidationRequestActionDetail;
use Illuminate\Support\Facades\Storage;
use Config;
class ConsolidationController extends Controller{

    function __construct(){
        parent::__construct();
        JavaScript::put([
            'del_url' => route('consolidation.shipment.delete'),
        ]);
        Config::set('services.easypost.api_key', Helper::dbConfigValue('easypost','api_key') );

    }

    public function index(){
        
        $employees = Employee::where('user_id','!=','')->with('user')->get();
    	$goods_descriptions = ConsolidationGoodsDescription::all();
    	$consolidation_locations = WarehouseShelf::where('usage_type','consolidated')->get();
    	return view('consolidation.ship.index',compact('consolidation_locations','goods_descriptions','employees'));
    }
    public function getConsolidatePackage($type){
    	if($type == 'ordinary'){
    		$consolidation_requests = ConsolidationRequest::where(function($qry){
                $qry->where('status','preparing')
                ->orWhere('status','cancelled');
            })->whereHas('shopaholic' , function($qry){
    			$qry->where('type','ordinary');
    		})->with(['packagePreparing','employee.user','shopaholic.user'])->get();	
    	}
    	if($type == 'corporate'){
    		$consolidation_requests = ConsolidationRequest::where(function($qry){
                $qry->where('status','preparing')
                ->orWhere('status','cancelled');
            })->whereHas('shopaholic' , function($qry){
    			$qry->where('type','corporate');
    		})->with(['packagePreparing','shopaholic.user'])->get();

    	}
        return DataTables::of($consolidation_requests)
            ->addColumn('checkBox',function($consolidation_request){
                return '<input type="checkbox" onclick="checkBoxTable(\'.checkbox_package\',\'.top_button\')" data-id="'.$consolidation_request->id.'" name="checkBox" class="checkbox_package">';
            })
            ->addColumn('no_of_pkgs',function($consolidation_request){
            	if($consolidation_request->packagePreparing){
            		return $consolidation_request->packagePreparing->count();	
            	}
            })
            ->addColumn('name',function($consolidation_request){
                return @$consolidation_request->shopaholic->user->first_name.' '.@$consolidation_request->shopaholic->user->last_name;
            })
            ->addColumn('actual_amount',function($consolidation_request){
                return '0';
            })
            ->addColumn('final_weight',function($consolidation_request){
                return '0';
            })
            ->addColumn('assigned_to',function($consolidation_request){
                if($consolidation_request->employee){
                    return $consolidation_request->employee->user->first_name.' '.$consolidation_request->employee->user->last_name;
                }
            })
            ->addColumn('status',function($consolidation_request){
                if($consolidation_request->status == 'preparing'){
                    return '<label class="label label-warning">Preparing</label>';
                }elseif($consolidation_request->status == 'cancelled'){
                    return '<label class="label label-danger">Cancelled</label>';
                }
            })
            ->editColumn('created_at',function($consolidation_request){
                return Helper::formatDate($consolidation_request->created_at);
            })
            ->rawColumns(['status','action','checkBox','no_of_pkgs','name','actual_amount','final_weight'])
            ->addColumn('action', function ($consolidation_request) {
              return view('consolidation.ship.action-button', ['result' => $consolidation_request, 'modal_id' => 'actual_weight_model'])->render();
			})->make(true);
    }
    public function getPendingPayment(){
        $consolidation_requests = ConsolidationRequest::where('status','payment_pending')->whereHas('shopaholic' , function($qry){
            $qry->with('user');
        })->with(['packagePendingPayment','shopaholic.user','employee.user'])->get();
        return DataTables::of($consolidation_requests)
            ->addColumn('checkBox',function($consolidation_request){
                return '<input type="checkbox" data-id="'.$consolidation_request->id.'" name="checkBox" class="">';
            })
            ->addColumn('no_of_pkgs',function($consolidation_request){
                if($consolidation_request->packagePreparing){
                    return $consolidation_request->packagePreparing->count();   
                }
                
            })
            ->addColumn('name',function($consolidation_request){
                return @$consolidation_request->shopaholic->user->first_name.' '.@$consolidation_request->shopaholic->user->last_name;
            })
            ->addColumn('actual_amount',function($consolidation_request){
                return '0';
            })
            ->addColumn('final_weight',function($consolidation_request){
                return '0';
            })
            ->addColumn('status',function($consolidation_request){
                return '<label class="label label-danger">Pending Payment</label>';
            })
            ->addColumn('assigned_to',function($consolidation_request){
                if($consolidation_request->employee){
                    return $consolidation_request->employee->user->first_name.' '.$consolidation_request->employee->user->last_name;
                }
            })
            ->editColumn('created_at',function($consolidation_request){
                return Helper::formatDate($consolidation_request->created_at);
            })
            ->rawColumns(['status','action','checkBox','no_of_pkgs','name','actual_amount','final_weight'])
            ->addColumn('action', function ($consolidation_request) {
              return view('consolidation.ship.pending-payment.action-buttons', ['result' => $consolidation_request, 'modal_id' => 'edit_actual_weight_model'])->render();
            })->make(true);
    }
    public function getProcessing(){
        $consolidation_requests = ConsolidationRequest::where('status','processing')->whereHas('shopaholic' , function($qry){
            $qry->with('user');
        })->with(['packageProcessing','shopaholic.user','employee.user','paymentDetail.shippingCharges.courier'])->get();
        return DataTables::of($consolidation_requests)
            ->addColumn('checkBox',function($consolidation_request){
                return '<input onclick="checkBoxTable(\'.checkbox_processing_package\',\'.top_button_processing\',\'processing\',this)" type="checkbox" data-id="'.$consolidation_request->id.'" name="checkBox" class="checkbox_processing_package">
                    <input type="hidden" name="label_url" class="label_url" value='.route("consolidation.shipment.label_printing",$consolidation_request->id).' />
                ';
            })            
            ->addColumn('no_of_pkgs',function($consolidation_request){
                if($consolidation_request->packageProcessing){
                    return $consolidation_request->packageProcessing->count();   
                }
            })
            ->addColumn('courier_id',function($consolidation_request){
                return $consolidation_request->paymentDetail->shippingCharges->courier->title;
            })
            ->addColumn('name',function($consolidation_request){
                return @$consolidation_request->shopaholic->user->first_name.' '.@$consolidation_request->shopaholic->user->last_name;
            })
            ->addColumn('actual_amount',function($consolidation_request){
                return '<b>$ '.$consolidation_request->paymentDetail->shipping_cost.'</b>';
            })
            ->addColumn('final_weight',function($consolidation_request){
                return '0';
            })
            ->addColumn('status',function($consolidation_request){
                return '<label class="label label-danger">Processing</label>';
            })
            ->addColumn('assigned_to',function($consolidation_request){
                if($consolidation_request->employee){
                    return $consolidation_request->employee->user->first_name.' '.$consolidation_request->employee->user->last_name;
                }
            })
            ->editColumn('created_at',function($consolidation_request){
                return Helper::formatDate($consolidation_request->paymentDetail->paid_at);
            })
            ->rawColumns(['status','action','checkBox','no_of_pkgs','name','actual_amount','final_weight','courier_id','created_at'])
            ->addColumn('action', function ($consolidation_request) {
              return view('consolidation.ship.pending-payment.action-buttons', ['result' => $consolidation_request, 'modal_id' => 'edit_actual_weight_model'])->render();
            })->make(true);
    }
    public function gePickUpPool(){
        $consolidation_requests = ConsolidationRequest::where('action_status','pickup')->where(function($qry){
            $qry->orWhere('status','preparing');
            $qry->orWhere('status','cancelled');   
        })->with(['packagePendingPayment','packagePreparing','shopaholic.user','employee.user'])->get();
        return DataTables::of($consolidation_requests)
            ->addColumn('checkBox',function($consolidation_request){
                return '<input type="checkbox" onclick="checkBoxTable(\'.checkbox_package_pickup\',\'.top_button_pickup\')" data-id="'.$consolidation_request->id.'" name="checkBox" class="checkbox_package_pickup checkbox_package">';
            })
            ->addColumn('no_of_pkgs',function($consolidation_request){
                if($consolidation_request->packagePreparing){
                    return $consolidation_request->packagePreparing->count();   
                }
                
            })
            ->addColumn('name',function($consolidation_request){
                return @$consolidation_request->shopaholic->user->first_name.' '.@$consolidation_request->shopaholic->user->last_name;
            })
            ->addColumn('actual_amount',function($consolidation_request){
                return '0';
            })
            ->addColumn('final_weight',function($consolidation_request){
                return '0';
            })
            ->addColumn('status',function($consolidation_request){
                if($consolidation_request->status == 'preparing'){
                 return '<label class="label label-warning">Preparing</label>';   
                }
                if($consolidation_request->status == 'cancelled'){
                 return '<label class="label label-danger">Cancelled</label>';   
                }
                
            })
            ->addColumn('assigned_to',function($consolidation_request){
                if($consolidation_request->employee){
                    return $consolidation_request->employee->user->first_name.' '.$consolidation_request->employee->user->last_name;
                }
            })
            ->editColumn('created_at',function($consolidation_request){
                return Helper::formatDate($consolidation_request->created_at);
            })
            ->rawColumns(['status','action','checkBox','no_of_pkgs','name','actual_amount','final_weight'])
            ->addColumn('action', function ($consolidation_request) {
              return view('consolidation.ship.action-button', ['result' => $consolidation_request, 'modal_id' => 'edit_actual_weight_model'])->render();
            })->make(true);
    }
    public function getOnHold(){
        $consolidation_requests = ConsolidationRequest::where('status','on_hold')->with(['packagePendingPayment','packagePreparing','shopaholic.user','employee.user'])->get();
        return DataTables::of($consolidation_requests)
            ->addColumn('checkBox',function($consolidation_request){
                return '<input type="checkbox" data-id="'.$consolidation_request->id.'" name="checkBox" class="">';
            })
            ->addColumn('no_of_pkgs',function($consolidation_request){
                if($consolidation_request->packagePreparing){
                    return $consolidation_request->packagePreparing->count();   
                }
                
            })
            ->addColumn('name',function($consolidation_request){
                return @$consolidation_request->shopaholic->user->first_name.' '.@$consolidation_request->shopaholic->user->last_name;
            })
            ->addColumn('actual_amount',function($consolidation_request){
                return '0';
            })
            ->addColumn('final_weight',function($consolidation_request){
                return '0';
            })
            ->addColumn('status',function($consolidation_request){
                if($consolidation_request->status == 'on_hold'){
                 return '<label class="label label-danger">Hold</label>';   
                }
                
            })
            ->addColumn('assigned_to',function($consolidation_request){
                if($consolidation_request->employee){
                    return $consolidation_request->employee->user->first_name.' '.$consolidation_request->employee->user->last_name;
                }
            })
            ->editColumn('created_at',function($consolidation_request){
                return Helper::formatDate($consolidation_request->created_at);
            })
            ->rawColumns(['status','action','checkBox','no_of_pkgs','name','actual_amount','final_weight'])
            ->addColumn('action', function ($consolidation_request) {
              return view('consolidation.ship.hold-request.action-button', ['result' => $consolidation_request, 'modal_id' => 'edit_actual_weight_model'])->render();
            })->make(true);
    }
    public function onHoldRequest(){
        $id = request()->id;
        $mag = [];
        if(!empty($id)){
            $consolidation = ConsolidationRequest::where('id',$id)->first();
            $consolidation->update(['status' => 'on_hold']);
            event(new ConsolidationLogEvent($consolidation,'on_hold'));
            if($consolidation){
                $msg['status'] = 1;
            }else{
                $msg['status'] = 0;
            }
        }else{
            $msg['status'] = 0;
        }
        return response()->json($msg);
    }
    public function reviewRequest($id){
    	$consolidation = ConsolidationRequest::where('id',$id)->with(['fetchLocation.location','packages.packageCustomDetail','requestDetail' => function($qry){
             
        }])->first();
    	//$data = [];
    	$sum = 0;
    	foreach($consolidation->packagePreparing as $package){
           $sum +=  $package->packageCustomDetail->sum('value');
    		//$data = DB::select('call GetSum(?)',array($package->id));
    		//$sum = $data[0]->clicks+$sum;
    	}
    	$consolidation_request_info = ConsolidationRequestInfo::all();
    	return view('consolidation.ship.review-request',compact('consolidation','consolidation_request_info','sum'));
    }
 
    /************* Get Package ******/
    public function getReviewRequestPackage(){
    	$id = request()->id;
    	$packages = Package::where('consolidation_request_id',$id)->with(['paidService.services','warehouseShelf','primaryThumbnail','packageCustomDetail.category' => function($qry){
    	}])->paginate(Helper::paginatePerPage());

        //dd($packages);
    	$free_ser = PackageService::where('type','free')->get();
    	$msg = [];
    	if($packages){
    		$msg['data'] = $packages;
    		$msg['free_ser'] = $free_ser;
     		$msg['status'] = 1;
    	}else{
    		$msg['status'] = 0;
    	}
    	return response()->json($msg);
    }
    public function addActualWeight(){
    	$validatedData 			= 	request()->validate([
			'location' 			=> 	'required',
		]);
		$msg = [];
		foreach (request()->arr as $key => $value) {
			if(!empty($value['width']) && !empty($value['height']) && !empty($value['lenght']) && !empty($value['actual_weight'])){
			}else{
				$g['errors']['all'] = 'Please Choose all field in Dimensional weight';
				return response()->json($g,422);
				exit;
			}
		}
        $rr = array_values(request()->arr);
		foreach ($rr as $key => $value) {
			$consolidationBoxDetail = new ConsolidationBoxDetail();
			$consolidationBoxDetail->height 					= $value['height'];
			$consolidationBoxDetail->width  					= $value['width'];
			$consolidationBoxDetail->length					    = $value['lenght'];
			$consolidationBoxDetail->actual_weight 				= $value['actual_weight'];
			$consolidationBoxDetail->dimensional_weight 		= $value['dimensional_weight'];
			$consolidationBoxDetail->status             		= 'pending';
			$consolidationBoxDetail->consolidation_location_id 	= request()->location;
			$consolidationBoxDetail->consolidation_request_id 			   	= request()->request_id;
			$consolidationBoxDetail->save();
		}
		$consolidation_request = ConsolidationRequest::where('id',request()->request_id)->first();
			if($consolidation_request){
			$data = [];
			foreach (request()->goods_des as $key => $value) {
				$data[] = (int)$value;
			}
			$consolidation_request->goods_description_ids = $data;
			$consolidation_request->status = 'payment_pending';
			$consolidation_request->update();
            event(new ConsolidationLogEvent($consolidation_request,'payment_pending'));
			$msg['status'] = 1;
		}else{
			$msg['status'] = 0;
		}
		return response()->json($msg);
    }
    public function editActualWeight(){
        $id = request()->id;
        $msg = [];
        if(!empty($id)){
            $consolidation_request = ConsolidationRequest::where('id',$id)->with('boxDetail','fetchLocation')->first();
            $goods_descriptions = ConsolidationGoodsDescription::all();
            if($consolidation_request){
                $msg['data'] = $consolidation_request;
                $msg['goods_description'] = $goods_descriptions;
                $msg['status'] = 1;
            }else{
                $msg['status'] = 0;
            }
        }else{
            $msg['status'] = 0;
        }
        return response()->json($msg);
    }
    public function updateActualWeight(){
        $validatedData          =   request()->validate([
            'location'          =>  'required',
        ]);
        $msg = [];
        foreach (request()->arr as $key => $value) {
            if(!empty($value['width']) && !empty($value['height']) && !empty($value['lenght']) && !empty($value['actual_weight'])){
            }else{
                $g['errors']['all'] = 'Please Choose all field in Dimensional weight';
                return response()->json($g,422);
                exit;
            }
        }
        
        $consolidation_request = ConsolidationRequest::where('id',request()->request_id)->with('boxDetail')->first();
        $consolidation_request->boxDetail()->delete();
        if($consolidation_request){
            foreach (request()->arr as $key => $value) {
                $consolidationBoxDetail                 = new ConsolidationBoxDetail();
                $consolidationBoxDetail->height         = $value['height'];
                $consolidationBoxDetail->width          = $value['width'];
                $consolidationBoxDetail->length         = $value['lenght'];
                $consolidationBoxDetail->actual_weight  = $value['actual_weight'];
                $consolidationBoxDetail->dimensional_weight         = $value['dimensional_weight'];
                $consolidationBoxDetail->status                     = 'pending';
                $consolidationBoxDetail->consolidation_location_id  = request()->location;
                $consolidationBoxDetail->consolidation_request_id                 = request()->request_id;
                $consolidationBoxDetail->save();
            }
        if(request()->goods_des){
           $data = [];
            foreach (request()->goods_des as $key => $value) {
                $data[] = (int)$value;
            }
            $consolidation_request->goods_description_ids = $data; 
        }
        
        $consolidation_request->status = 'payment_pending';
        $consolidation_request->update();
        $msg['status'] = 1;
        }else{
            $msg['status'] = 0;
        }
        return response()->json($msg);
    }

    public function assignEmployee(){
        $msg = [];
        $validatedData          =   request()->validate([
            'employee'          =>  'required',
        ]);
        $request_ids = explode(',', request()->request_id);
        $consolidation_request = ConsolidationRequest::whereIn('id',$request_ids)->update(['assigned_to' => request()->employee]);
        if($consolidation_request){
            $msg['status'] = 1;
        }else{
            $msg['status'] = 0;
        }
        return response()->json($msg);
    }

    public function pickUpPool(){
        $msg = [];
        $consolidate_request = ConsolidationRequest::whereIn('id',request()->ids)->first();
        $consolidate_request->update(['action_status' => 'pickup']);
        event(new ConsolidationLogEvent($consolidate_request,'pickup'));
        if($consolidate_request){
            $msg['status'] = 1;
        }else{
            $msg['status'] = 0;
        }
        return response()->json($msg);
    }
    /********* Move pickup pool to preparing ******/
    public function outPickUpPool(){
        $msg = [];
        $consolidate_request = ConsolidationRequest::whereIn('id',request()->ids)->first();
        $consolidate_request->update(['action_status' => 'none']);
        event(new ConsolidationLogEvent($consolidate_request,'preparing'));
        if($consolidate_request){
            $msg['status'] = 1;
        }else{
            $msg['status'] = 0;
        }
        return response()->json($msg);
    }
    /***** Move Request Hold to Prev Step  *******/
    public function reOpenRequest(){
        $msg = [];
        if(!empty(request()->id)){
            $action_detail = ConsolidationRequestActionDetail::where('consolidation_request_id',request()->id)->orderBy('created_at','desc')->skip(1)->take(1)->first();
            if($action_detail){
                $consolidate_request = ConsolidationRequest::where('id',request()->id)->first();
                $consolidate_request->update(['status' => $action_detail->action_status]);
                event(new ConsolidationLogEvent($consolidate_request,$action_detail->action_status));
                if($consolidate_request){
                    $msg['status'] = 1;
                }else{
                    $msg['status'] = 0;
                }
            }      
        }
        return response()->json($msg);
    }    



    public function delete(){
        $id = request()->id;
        $consolidation_request = ConsolidationRequest::where('id',$id)->with('packages')->first();
        if($consolidation_request->boxDetail){
            $consolidation_request->boxDetail()->delete();
        }
        $consolidation_request->status = 'cancelled';
        $is_cancelled = $consolidation_request->update();
        if($is_cancelled){
            event(new ConsolidationLogEvent($consolidation_request,'cancelled',request()->reason));
            $is_changed = Package::where('consolidation_request_id',$id)->update(['request_id'=>NULL,'status' => 'sorted']);
            
            $msg['status'] = 1;
        }
        return response()->json($msg);
    }

    public function label_printing(){
      //  ConsolidationRequestLabelGenerate::dispatch(request()->id)->onConnection('database');

        $consolidation_request = ConsolidationRequest::where('id',request()->id)->with('paymentDetail.shippingCharges.courier','boxDetail')->first();
             \EasyPost\EasyPost::setApiKey('y4HNPR7IVaSFphhKI2Ye3Q');
             $order = \EasyPost\Order::retrieve($consolidation_request->paymentDetail->shippingCharges->shipment_id);
             //dd($order);
            //     /*******
            //         Old EasyPost key 
            //         a2or0tDgk2I9MpLy3ZTmmQ
            //     *********/
           //     $order->buy(array("carrier" => 'USPS', "service" => 'ExpressMailInternational'));    

              $order->buy(array("carrier" => $consolidation_request->paymentDetail->shippingCharges->courier->name, "service" => $consolidation_request->paymentDetail->shippingCharges->courier->details->easy_post));
                $shipments = $order->__get('shipments');
                foreach ($shipments as $key => $value) {
                    $id = $value->__get('id');
                    $shipment = \EasyPost\Shipment::retrieve($id);
                    $shipment->insure(array('amount' => 1));
                    break;
                }
                dd($order);
            $shipment_data = [];
            foreach ($order->shipments as $key => $shipment) {
                Storage::disk('s3')->put(config('filesystems.s3.url').config('filesystems.s3.bucket').'/LabelEasyPostGlobalShopoaholicsNew/'.time(), file_get_contents($shipment['postage_label']['label_url']));
                $shipment_data['label'][] = $shipment['postage_label']['label_url'];
                $shipment_data['tracking_number'][] = $shipment->tracking_code;
           }
           foreach ($consolidation_request->boxDetail as $key => $box) {
                $arr = [];
                $arr['shipment'][$key]['label_url'] = $shipment_data['label'][$key];
                $arr['shipment'][$key]['tracking_number'] = $shipment_data['tracking_number'][$key];
               $box->details = $arr;
               $box->update();
               unset($arr);
           }
    }

    function calculateShipping() {
        $request_id = request()->id;

        $direct_request = ConsolidationRequest::where('request_id', $request)->first();

        $package = Package::where("request_id", $request_id)->first();
        $from_country_code = 'US';

        if ($direct_request->dimensional_weight > $direct_request->parcel_net_weight) {
            $weight = $direct_request->dimensional_weight;
            $min_weight = $direct_request->parcel_net_weight;
        } else {
            $weight = $direct_request->parcel_net_weight;
            $min_weight = $direct_request->dimensional_weight;
        }

        $ounces_weight = round($weight * 16.000002821917267, 2);
        $min_weight = round($min_weight * 16.000002821917267, 2);
        $d_is_package_insure = $direct_request->is_package_insure;
        $length = 1;
        $width = 1;
        $height = 1;
    }
}

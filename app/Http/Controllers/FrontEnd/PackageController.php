<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Package;
use App\PackageService;
use App\PackageServiceRequests;
use App\PackageCustomCategory;
use App\PackageCustomDetail;

use Auth,DataTables,Helper,Carbon,JavaScript;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SplitPackageNotification;
use App\Events\SplitPackageEvent;


class PackageController extends Controller
{

    function __construct()
    {
        //dd(route("storage.getpackages"));
        JavaScript::put([
            'ajaxPackagesJson' =>   route("storage.ajax-storage-packages"),
            'getConRequests'       =>   route("frontend.consolidate.get_consolidation_requests")
            
        ]);

    }

    public function index($type){
        //dd($type);

    	$shopaholic_id = Auth::user()->shopaholic->id; 
    	$packages = Package::where('shopaholic_id',$shopaholic_id)->get();
    	$free_services = PackageService::where(['type'=>'free','status' => 'active'])->get();
        $custom_categories = PackageCustomCategory::all();
    	$paid_services = PackageService::where('type','paid')->get();
        $layout = $type;
    	return view('frontend.dashboard.storage-ship.index',compact('packages','free_services','paid_services','custom_categories','layout'));
    } 
    public function getMyStoragePackage(){
        $shopaholic_id = Auth::user()->shopaholic->id;

        $packages = Package::where('shopaholic_id',$shopaholic_id)
                            ->where('status','sorted')
                            ->where('parent_package_id',NULL)
                            ->with('primaryThumbnail','childPackages');

        //dd($packages->get());

        return DataTables::of($packages)
            ->addColumn('checkBox',function($package){
                return '<input type="checkbox" data-id="'.$package->id.'" name="checkBox" class="checkbox_package">';
            })
            ->addColumn('image',function($package){
                //echo $package->primaryThumbnail->image_name;
                //["https:\/\/s3.amazonaws.com\/uploads-gshopaholics\/20180322110136_IMG_20180322_094737.jpg"] 
                if($package->primaryThumbnail){

                    //foreach ($package->primaryThumbnail as $key => $value) {
                        return '<div class="mx-auto gs-width-fixed"><img src="'.$package->primaryThumbnail->image_name.'" class="img-fluid  img-thumbnail"/></div>'; 
                    //}

                }else{

                }
            })
            ->editColumn('created_at',function($package){
                return Helper::formatDate($package->created_at);
            })
            ->rawColumns(['status','action','checkBox','image'])
            ->addColumn('action', function ($package) {
              return '<button data-toggle="modal" data-id="'.$package->id.'" data-target="#package_details_modal" class="btn btn-primary" >Details</button>';
            })
           /* ->setRowAttr([
                'trck_no' => function($package) {
                    return  $package->tracking_number;
                }
            ])*/
            ->make(true);
    }

/******************** package Grid Adnan */


    function ajaxPackagesJson(){

        $q = request()->text;
        $shopaholic_id = Auth::user()->shopaholic->id;

        if(!empty($q)){
            $storage_packages = Package::with('images')
                                ->where('shopaholic_id',$shopaholic_id)
                                ->where('status','sorted')
                                ->where(function($query) use($q){
                                    $query->orWhere('description','like',"%$q%")
                                    ->orWhere('tracking_number','like',"%$q%");
                                    
                                })
                                
                                ->paginate(9);
        }
        else
        {
            $storage_packages = Package::with('images')
                                ->where('shopaholic_id',$shopaholic_id)
                                ->where('status','sorted')
                                ->paginate(9);
        }
        
            
        $msg['status'] = 1;
        
        $msg['no_of_page'] = request()->page;
        $msg['packages'] = $storage_packages->items();
        return json_encode($msg);

    }



/******************End Adnan code ************************/




    public function packageServices($type){ 
    	if(!empty($type) && $type == 'free'){
            $service_id = [];
            foreach(request()->package_free_service_id as $package_service_id){
                $service_id[] = intval($package_service_id);
            }
            $package = Package::find(request()->package_id);
            $package->package_free_services = $service_id;
            $is_updated = $package->update();
            if($is_updated){
                $msg['status'] = 1;
                return json_encode($msg);
            }else{
                unset($service_id);
                $msg['status'] = 0;
                return json_encode($msg);
            }
        }
        if(!empty($type) && $type == 'paid'){
             $service_id = [];
            foreach(request()->package_free_service_id as $package_service_id){
                $service_id[] = intval($package_service_id);
            }
            $package = Package::find(request()->package_id);
            $package->package_free_services = $service_id;
            $is_updated = $package->update();
            if($is_updated){
                $msg['status'] = 1;
                return json_encode($msg);
            }else{
                $msg['status'] = 0;
                return json_encode($msg);
            }
        }
    }
    public function getPackageDetails(){
        $package_id = request()->id;
        $added_service = [];
        $package = Package::where('id',$package_id)->with(['warehouseShelf','paidService' => function($query){
            $query->select('package_id','package_service_id');
        }])->first();
        $package_custom_detail_obj = PackageCustomDetail::where('object_type','package')->where('object_id',$package_id)->get();
        $sum_custom_value = 0;
        if($package_custom_detail_obj){
            foreach ($package_custom_detail_obj as $key => $value) {
                $sub_total = (float)$value->quantity * (float)$value->value;
                $sum_custom_value = (float)$sub_total + (float)$sum_custom_value;
            }
        }
        $paid_services = PackageService::where('type','paid')->get();
        $fee_services  = PackageService::where('type','free')->get();
        $reserve_paid_service = $package->paidService->toArray();
        if(!empty($reserve_paid_service)){
           foreach ($reserve_paid_service as $key => $value) {
                $added_service[] = $value['package_service_id'];
            }
        }
        $msg['paid_services'] = $paid_services;
        $msg['added_paid_services'] = $added_service;
        $msg['free_services'] = $fee_services;
        $msg['custom_detail_total'] = $sum_custom_value;
        $msg['package']       = $package; 
        $to                   = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $package->created_at);
        $from                 = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', Carbon\Carbon::now());
        $diff_in_days         = $to->diffInDays($from);
        $msg['storage']       = $diff_in_days; 
        $msg['status']        = 1;
        return response()->json($msg);
    }
    public function splitPackage(){
        //dd(request()->all());

        $parent_package = Package::find(request()->package_id);
        //dd($parent_package);
        $package =[];
        $pointer = 1;
        foreach (request()->package as $key => $items) {

            $new_package = new Package;
            $new_package->package_id = $parent_package->package_id.'-child'.$pointer;
            $new_package->tracking_number = $parent_package->tracking_number.'-child'.$pointer;
            $new_package->parent_package_id = $parent_package->id;
            $new_package->shopaholic_id = $parent_package->shopaholic_id;
            if($parent_package->description !='')
                 $new_package->description = $parent_package->description.'-child'.$pointer;
            if($parent_package->warehouse_shelf_id !='')
                $new_package->warehouse_shelf_id = $parent_package->warehouse_shelf_id;
            $new_package->status = $parent_package->status;
            
            $new_package->save();

            $package[$key] = ['package_id'=> $new_package->id,'items'=>array_values($items['item'])];

            $pointer++;
        }
    
        $split_data = ['split'=>array_values($package)];
       

        $request_services = new PackageServiceRequests();
        $request_services->package_id = request()->package_id;
        $request_services->package_service_id = request()->service_id;
        $request_services->details =  $split_data;
        $is_saved = $request_services->save();
//dd($request_services->details);

        event(new SplitPackageEvent($request_services));
        // Notification::send(Auth::user(), new SplitPackageNotification(Auth::user()));
        if($is_saved){
            $msg['status'] = 1;
        }else{
            $msg['status'] = 0; 
        }
        return response()->json($msg);
    }
    public function returnPackageFile(){ 
        $msg = [];
        $package_id = request()->package_id;
        $service_id = request()->service_id; 
        if(!empty($package_id) && !empty($service_id)){
            if (request()->hasFile('file')) {
                $package_service_request = new PackageServiceRequests();
                $package_service_request->package_id = $package_id;
                $package_service_request->package_service_id  = $service_id;
                $file = request()->file("file");
                $file_unique_name = request()->first_name . '-' . time() . '-' . date("Ymdhis") . rand(0, 999) . '.' . $file->guessExtension();
                $file_unique_name_resized = time() . '-' . date("Ymdhis") . rand(0, 999) . '.' . $file->guessExtension();
                $file->storeAs(config('constants.img_folder'), $file_unique_name);
                $data = ['return_label' => $file_unique_name_resized];
                $package_service_request->details = $data;
                $is_saved = $package_service_request->save();
                if($is_saved){
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
    public function postFreeServicePackage(){
        $id = request()->id;
        $msg = [];
        $flag = request()->flag;

        $service_id = (int)$id;
        $package = Package::where('id',request()->package_id)->first();
        $service_ids = $package->free_services;
        if($flag == 'insert'){
           if($package->free_services){
                $data = array_push($service_ids,$service_id);
                $package->free_services = $service_ids;
           }else{
                $package->free_services = [$service_id];
           }
           $is_updated = $package->update();
           if($is_updated){
            $msg['status'] = 1;
           }else{
            $msg['status'] = 0;
           }
           return response()->json($msg);
        }
        if($flag == 'delete'){ 
            if($package->free_services){
                $key = array_search($service_id, $service_ids);
                if ($key !== false) {
                    array_splice($service_ids,$key,1); 
                    $package->free_services = $service_ids;
                    $is_updated = $package->update();
                    $msg['status'] = 2;
                }else{
                    $msg['status'] = 0;
                }
                return response()->json($msg);
            }
        }
    }
    public function postPaidServicesPackage(){
        $service_id = request()->service_id;
        $package_id = request()->package_id;
        $msg = [];
        if(!empty($package_id) && !empty($service_id)){
           $package_service_request = new PackageServiceRequests();
            $package_service_request->package_id = $package_id;
            $package_service_request->package_service_id = $service_id;
            $is_saved = $package_service_request->save();
            if($is_saved){
                $msg['status'] = 1;
            }else{
                $msg['status'] = 0;
            } 
        }else{
            $msg['status'] = 0;
        }
        return response()->json($msg);
    }
    public function packageDescription(){
        $msg = [];
        $package_id = request()->package_id;
        if(!empty($package_id)){
            $package = Package::where('id',$package_id)->first();
            if($package){
                $package->description = request()->description;
                $is_updated = $package->update();
                if($is_updated){
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
    public function existPackageCustomValue(){
        $package_custom_detail_obj = PackageCustomDetail::where('object_type','package')->where('object_id',request()->custom_value_package_id)->get();
        if($package_custom_detail_obj){
            $msg['status'] = 1;
            $msg['data'] = $package_custom_detail_obj;
        }else{
            $msg['status'] = 0;
        }
        return response()->json($msg);
    }
    public function packageCustomValue(){ 
        $category = request()->category;
        $quantity = request()->quantities;
        $value    = request()->value;
        $result   = [];
        $msg      = [];
        foreach ($value as $id => $key) {
            $result[] = array(
                'category_id'   => $category[$id],
                'quantity'      => $quantity[$id],
                'value'         => $value[$id],
            );
            if(empty($category[$id]) || empty($quantity[$id]) || empty($value[$id])){
                $msg['status'] = 2;
                return response()->json($msg, 422);
                die();
            }
        } 
        $package_custom_detail_obj = PackageCustomDetail::where('object_type','package')->where('object_id',request()->custom_value_package_id)->delete();
        foreach($result as $key=>$data){
            $package_custom_detail                      = new PackageCustomDetail();
            $package_custom_detail->object_type         = 'package';
            $package_custom_detail->quantity            = $data['quantity'];
            $package_custom_detail->value               = $data['value'];
            $package_custom_detail->object_id           = request()->custom_value_package_id;
            $package_custom_detail->custom_category_id  = $data['category_id'];
            $is_saved = $package_custom_detail->save();
            if($is_saved){
                $msg['status'] = 1;
            }else{
                $msg['status'] = 0; 
            }
        }
        return response()->json($msg);
    }

}

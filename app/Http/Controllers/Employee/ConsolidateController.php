<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth,DataTables,Helper,Carbon;
use App\ConsolidationRequest;
use App\Option;
use App\Package;
use App\PackageImage;
use App\WarehouseShelf;
use App\PackageDetail;
use App\ConsolidationGoodsDescription;
use App\Events\PackageLogEvent;
use App\Events\ConsolidationLogEvent;
use App\ConsolidationBoxDetail;
use App\PackageCustomDetail;
use Config;
use App\Country;
use App\Courier;
use App\RateManipulation;
use App\ConsolidationCourierShippingCharges;

use App\Task;
use App\TaskDetail;

class ConsolidateController extends EmployeeController
{
    public function __construct(){
       parent::__construct();
        Config::set('services.easypost.api_key', Helper::dbConfigValue('easypost','api_key') );
    }
    public function index(){
    	return view('employee.consolidate.index');
    }
    public function pullConsolidateRequest(){
		$a_id = Auth::user()->id;
		$consolidation_request = ConsolidationRequest::where('status','preparing')
                                                        ->whereNull('assigned_to')
                                                        ->whereHas('packages',function($qry)
                                                        {
                                                            $qry->where('pick_status','picked');
                                                        })
                                                        ->limit(1)
                                                        ->update(['assigned_to'=>$a_id]);
        //dd($consolidation_request);
		$msg['status'] = 1;
		return response()->json($msg);
	}

  public function checkPackageInnerContent(Request $request){
    $index = 0;
    $ids = array();
    $data = PackageImage::whereIn('package_id', $request->packages)->where('type',"inner_content")->get();
    foreach ($data as $d) {
      $ids[$index] = $d->package_id;
      $index++;
    }
    $ids = array_unique($ids);
    $ids = array_values($ids);
    return response()->json($ids);
  }

    public function getConsolidateRequest(){
    	$assigned_id = Auth::user()->id;
		$consolidations = ConsolidationRequest::where('status','preparing')->where('assigned_to',$assigned_id)->with('packages','shopaholic.user')->whereHas('packages',function($qry){
            $qry->where('pick_status','picked');
        });

        //dd($consolidations->get());

		if($consolidations){
			return DataTables::of($consolidations)
				->addColumn('request_id',function($consolidation){
	                return '<a href="'.route('employee.consolidate.package_consolidate_request',$consolidation->id).'" class="btn-shopaholic_id">'.$consolidation->unique_key.'</a>';
	            })
	            ->addColumn('name',function($consolidation){
	                return @$consolidation->shopaholic->user->first_name.' '.@$consolidation->shopaholic->user->last_name;
	            })
	            ->addColumn('no_of_pkgs',function($consolidation){
	            		return $consolidation->packages->count();
	            })
	            ->addColumn('status',function($consolidation){
	                if($consolidation->status == 'preparing'){
	                    return '<label class="label label-warning">Preparing</label>';
	                }
	            })
	            ->editColumn('created_at',function($consolidation){
	                return Helper::formatDate($consolidation->created_at);
	            })
	            ->rawColumns(['status','request_id','name','no_of_pkgs','created_at'])
	           	->make(true);
		}else{
			//dd(1);
			//No Consolidation record found
		}
    }

    public function packageConsolidateRequest($id){
    	$consolidation = ConsolidationRequest::where('id',$id)->where('status','preparing')->orWhere('status','missing')->with(['packages.warehouseShelf','packages.primaryThumbnail','packages.primaryFullImage','packages.secondaryThumbs','packages.fullImages','packages.found','shopaholic.user','packages.packagePicked'])->first();
    	$consolidate_goods_descriptions = ConsolidationGoodsDescription::where('type','!=',null)->get();
        //dd($consolidation);
    	$warehouse_shelves = WarehouseShelf::where('usage_type','consolidated')->get();
    	return view('employee.consolidate.package',compact('consolidation','warehouse_shelves','consolidate_goods_descriptions'));
    }
    public function packageImages(){
    	$id = request()->id;
    	$package = Package::where('id',$id)
    						->with('images')
    						->first();
    	$msg['package'] = $package;
    	$msg['status']   = 1;
    	return response()->json($msg);
    }
    /**** Missing or Found ******/
    public function packageMissingFound(){

    	$id = request()->data['id'];
        $package = Package::where('id',$id)->first();
        if(request()->data['type'] == 'missing'){
            $prevStatus = $package->status;
            if($package){
                $package->status = 'missing';
                $package->update();

                $response = event(new PackageLogEvent($package,'missing',$prevStatus));
                return response()->json($response);
            }
        }
        if(request()->data['type'] == 'found'){

           $package_detail = PackageDetail::where('action_status','missing')->orderBy('created_at','desc')->first();
           if($package_detail){
                $package->status = $package_detail->details->package_prev_status;
                $is_updated = $package->update();

                if($is_updated){

                    $response = event(new PackageLogEvent($package,'found'));
                    return response()->json($response);
               }
            }else{
                $response = event(new PackageLogEvent($package,'found'));
                return response()->json($response);
            }
        }
    }
    public function addActualWeight(){
        /*dd(request()->all());*/

        /*if(request()->goods_id){
            $gg = array_map('intval', request()->goods_id);
        }*/

        //dd($gg);


        $msg = [];
        foreach (request()->arr as $key => $value) {
            if(!empty($value['width']) && !empty($value['height']) && !empty($value['lenght']) && !empty($value['actual_weight'])){
            }else{
                $g['errors']['all'] = 'Please Choose all field in Dimensional weight';
                return response()->json($g,422);
                exit;
            }
        }

         $validatedData  =   request()->validate([
                'location'       =>  'required',
            ]);


        $rr = array_values(request()->arr);
        $height = [];
        $lenght = [];
        $width  = [];
        $actual_weight = [];
        foreach ($rr as $key => $value) {
            $height[] = $value['height'];
            $width[] = $value['width'];
            $lenght[] = $value['lenght'];
            $actual_weight[] = $value['actual_weight'];
            //$actual_weight[$key] = (float)$value['actual_weight'] + (float)$actual_weight[$key];
            $consolidationBoxDetail = new ConsolidationBoxDetail();
            $consolidationBoxDetail->height                     = $value['height'];
            $consolidationBoxDetail->width                      = $value['width'];
            $consolidationBoxDetail->length                     = $value['lenght'];
            $consolidationBoxDetail->actual_weight              = $value['actual_weight'];
            $consolidationBoxDetail->dimensional_weight         = $value['dimensional_weight'];
            $consolidationBoxDetail->status                     = 'pending';
            $consolidationBoxDetail->consolidation_location_id  = request()->location;
            $consolidationBoxDetail->consolidation_request_id               = request()->consolidate_id;
            //dd($consolidationBoxDetail);
            $consolidationBoxDetail->save();

        }
        $consolidation = ConsolidationRequest::where('id',request()->consolidate_id)->with('shopaholic.user','packages.paidService.services','packages.packageCustomDetail.category')->first();

        if(request()->goods_id){
            $consolidation->goods_description_ids = array_map('intval', request()->goods_id);
        }
        $consolidation->status = 'payment_pending';
        $consolidation->special_instructions = request()->special_instructions;

        //dd( $consolidation);
        $consolidation->update();
        event(new ConsolidationLogEvent($consolidation,'payment_pending'));
        $msg['status'] = 1;
        $this->easyPostRates($lenght,$width,$height,$actual_weight,$consolidation);
        return response()->json($msg);
    }
    /*** Any difficulty during consolidation ***/
    public function confirmModel(){
        $confirm = request()->name;
        if($confirm == 'yes'){

        }elseif($confirm == 'no'){

        }
    }

    public function easyPostRates($lenght,$width,$height,$actual_weight,$consolidation){
        $to_country         = $consolidation->address->iso;
        $to_city            = $consolidation->address->city;
        $to_zip             = $consolidation->address->zip_code;
       // $call_from          = request()->call_from;
        $parcel_length      = $lenght;
        $parcel_width       = $width;
        $parcel_height      = $height;
        $parcel_weight      = $actual_weight;
        $toCountry      = Country::select('isK')->where('iso', $to_country)->first();
        \EasyPost\EasyPost::setApiKey(Config::get('services.easypost.api_key'));
        $from_adrs = array(
            "name"    => "Safian Hafeez",
            "street1" => "601 carnell Drive Unit G11",
            "street2" => "Global Shopaholics",
            "city"    => "Wilmington",
            "state"   => "DE",
            "zip"     => "19713",
            'country' => "US",
            'phone' => '03456283921'
            );

        $to_adrs = array(
            "name"          => $consolidation->address->name,
            "street1"       => $consolidation->address->street,
            'residential'   => true,
            "city"          => $to_city,
            "zip"           => $to_zip,
            "country"       => $to_country,
            'phone'         => $consolidation->address->phone
            );
        $from_address = \EasyPost\Address::create($from_adrs);
        $to_address = \EasyPost\Address::create($to_adrs);


        $customs_items = [];
        $contents_explanation = [];
        //for ($i=0;$i<count($parcel_length);$i++) {
        foreach($consolidation->packages as $key => $value){
            foreach ($value->packageCustomDetail as $key => $custom_detail) {
                //$customs_item_params = $custom_detail->get();
                $customs_item_params = [
                    "description" => $custom_detail->category->title,
                    "hs_tariff_number" => '',
                    "origin_country" => "US",
                    "quantity" => (float)$custom_detail->quantity,
                    "value" => (float)$custom_detail->value,
                    "weight" => (float)$custom_detail->quantity * (float)$custom_detail->value
                ];
                $customs_items[] = \EasyPost\CustomsItem::create($customs_item_params);
                $contents_explanation[] = preg_replace('/[^A-Za-z0-9\-\(\) ]/', '', $custom_detail->category->title);
            }

        }

        //}
        $contents_type = 'Merchandise';
        $contents_explanation = implode(",", $contents_explanation);
        $contents_explanation = substr($contents_explanation, 0, 200);
        $customs_info_params = array(
            "customs_certify"      => true,
            "customs_signer"       => "Global Shopaholic",
            "contents_type"        => $contents_type,
            "contents_explanation" => removeSpecialChar($contents_explanation),
            "eel_pfc"              => "NOEEI 30.37(a)",
            "non_delivery_option"  => "return",
            "restriction_type"     => "none",
            "restriction_comments" => "",
            "customs_items"        => $customs_items
        );
        $customs_info = \EasyPost\CustomsInfo::create($customs_info_params);
        $shipments = [];
        $round_weight = 0;
        for ($i=0;$i<count($parcel_length);$i++) {
            // if($_POST['measurement_unit'] == 2 ){
            //     $parcel_length[$i]  = cm_to_inches($parcel_length[$i]);
            //     $parcel_width[$i]   = cm_to_inches($parcel_width[$i]);
            //     $parcel_height[$i]  = cm_to_inches($parcel_height[$i]);
            //     $parcel_weight[$i]  = kg_to_pounds($parcel_weight[$i]);
            // }
            $parcel['length']   = $parcel_length[$i];
            $parcel['width']    = $parcel_width[$i];
            $parcel['height']   = $parcel_height[$i];
            $dimension_weight   = ($parcel_length[$i] * $parcel_width[$i] * $parcel_height[$i])/138.4;
            $diff = $dimension_weight - $parcel_weight[$i];
            if($diff > 15 && $diff < 25){
                $dimension_weight = ($parcel_length[$i] * $parcel_width[$i] * $parcel_height[$i])/166;
            }else if($diff > 24){
                $dimension_weight = ($parcel_length[$i] * $parcel_width[$i] * $parcel_height[$i])/194;
            }
            if($dimension_weight > $parcel_weight[$i] ) {
                $parcel['weight']   = pounds_to_ounces($dimension_weight);
            }else {
                $parcel['weight']   = pounds_to_ounces($parcel_weight[$i]);
            }
            $round_weight += $parcel['weight'];
            $shipments[$i]['parcel']        = $parcel;
            $shipments[$i]['customs_info']  = $customs_info;
            $shipments[$i]['reference']     = "Calculate Shipment";
            $shipments[$i]['options']       = array('incoterm' => "DDU","label_format" => 'PDF');
        }

        $round_weight = ounces_to_pounds($round_weight);
        //dd($shipments);
        // $shipments = \EasyPost\Shipment::create(array(
        //     "from_address"  => $from_address,
        //     "to_address"    => $to_address,
        //     "shipments"     => $shipments
        // ));
        $shipments = \EasyPost\Order::create(array(
            "from_address"  => $from_address,
            "to_address"    => $to_address,
            "shipments"     => $shipments
        ));
        $ins_amount = 0;
        $responseData = [];

       //dd($shipments);

        $fedExRates     = RateManipulation::where('weight', ceil($round_weight))->first();
        foreach ($shipments->rates as $rate) {
            $rateArr            = [];
            $rateArr['id']      = $rate->id;
            $rateArr['carrier'] = $rate->carrier;
            $rateArr['service'] = $rate->service;
            $rateArr['rate']    = $rate->rate + $ins_amount;
            $rateArr['actaul_rate']     = $rate->rate + $ins_amount;
            $_SESSION[$rateArr['service']] = $rate->delivery_date;
            // $toCountry      = Country::select('isK')->where('iso', $to_country)->first();
            // $fedExRates     = RateManipulation::where('weight', ceil($round_weight))->first();
            if($rateArr['carrier'] == 'FedEx'){
                if($rateArr['service'] == 'INTERNATIONAL_ECONOMY' && $toCountry->isK == 1) {
                    if($round_weight < 99){
                        $rateArr['rate'] = $rateArr['rate'] + ($fedExRates->economyZoneK);
                    }else {
                        $rateArr['rate'] = $rateArr['rate'] * 2 ;
                    }
                } else if($rateArr['service'] == 'INTERNATIONAL_PRIORITY' && $toCountry->isK == 1) {
                    if($round_weight < 99){
                        $rateArr['rate'] = $rateArr['rate'] + ($fedExRates->priorityZoneK);
                    }else {
                        $rateArr['rate'] = $rateArr['rate'] + ($rateArr['rate'] * 77)/100 ;
                    }
                }else if($rateArr['service'] == 'INTERNATIONAL_ECONOMY' && $toCountry->isK == 0) {
                    if($round_weight < 99){
                        $rateArr['rate'] = $rateArr['rate'] + ($fedExRates->economyZoneR);
                    }else {
                        $rateArr['rate'] = $rateArr['rate'] + ($rateArr['rate'] * 77)/100 ;
                    }
                }else if($rateArr['service'] == 'INTERNATIONAL_PRIORITY' && $toCountry->isK == 0) {
                    if($round_weight < 65){

                        $rateArr['rate'] = $rateArr['rate'] + ($fedExRates->priorityZoneR);
                    }else {
                        $rateArr['rate'] = $rateArr['rate'] * 1.5 ;
                    }
                }else if($rateArr['service'] == 'FEDEX_GROUND' || $rateArr['service'] == 'FIRST_OVERNIGHT' || $rateArr['service'] == 'PRIORITY_OVERNIGHT' || $rateArr['service'] == 'STANDARD_OVERNIGHT' || $rateArr['service'] == 'FEDEX_2_DAY_AM' || $rateArr['service'] == 'FEDEX_2_DAY' || $rateArr['service'] == 'FEDEX_EXPRESS_SAVER' || $rateArr['service'] == 'GROUND_HOME_DELIVERY') {
                    $rateArr['rate'] = $rateArr['rate'] + ($rateArr['rate'] * 50)/100 ;
                }

                // $rateArr['rate'] =  $rateArr['rate'] + $rateArr['rate'] * .15;
            }else if($rateArr['carrier'] == 'UPS'){
                if($rateArr['service'] == 'Ground' || $rateArr['service'] == '3DaySelect' || $rateArr['service'] == '2ndDayAir' || $rateArr['service'] == 'NextDayAirSaver' || $rateArr['service'] == 'NextDayAirEarlyAM' || $rateArr['service'] == 'NextDayAir'){
                    $rateArr['rate'] = $rateArr['rate'] + ($rateArr['rate'] * 30)/100 ;
                }else if($rateArr['service'] == 'Expedited' && $toCountry->isK == 1) {
                    if($round_weight < 99){
                        $rateArr['rate'] = $rateArr['rate'] + ($fedExRates->economyZoneK);
                    }else {
                        $rateArr['rate'] = $rateArr['rate'] * 2 ;
                    }
                } else if($rateArr['service'] != 'Expedited' && $toCountry->isK == 1) {
                    if($round_weight < 99){
                        $rateArr['rate'] = $rateArr['rate'] + ($fedExRates->priorityZoneK);
                    }else {
                        $rateArr['rate'] = $rateArr['rate'] + ($rateArr['rate'] * 77)/100 ;
                    }
                }else if($rateArr['service'] == 'Expedited' && $toCountry->isK == 0) {
                    if($round_weight < 99){
                        $rateArr['rate'] = $rateArr['rate'] + ($fedExRates->economyZoneR);
                    }else {
                        $rateArr['rate'] = $rateArr['rate'] + ($rateArr['rate'] * 77)/100 ;
                    }
                }else if($rateArr['service'] != 'Expedited' && $toCountry->isK == 0) {
                    if($round_weight < 65){
                        $rateArr['rate'] = $rateArr['rate'] + ($fedExRates->priorityZoneR);
                    }else {
                        $rateArr['rate'] = $rateArr['rate'] * 1.5 ;
                    }
                }
            }else if($rateArr['carrier'] == 'USPS'){
                $rateArr['rate'] = $rateArr['rate'] + ($rateArr['rate'] * 30)/100 ;
            }else if($rateArr['carrier'] == 'Aramex'){
                if(floatval($round_weight) >= 3){
                    $rateArr['rate'] = $rateArr['rate'] + ($rateArr['rate'] * 25)/100 ;
                }
            }else if($rateArr['carrier'] == 'DHLExpress') {
                if($round_weight < 65){
                    $rateArr['rate'] = $rateArr['rate'] + ($fedExRates->priorityZoneR);
                }else {
                    $rateArr['rate'] = $rateArr['rate'] * 1.5 ;
                }
            }

            $rateArr['est_delivery_days'] = $rate->est_delivery_days;
            $rateArr['shipment_id']       = $shipments->id;
            // Update rate 4.4 %
            $rateArr['rate'] = $rateArr['rate'] +  $rateArr['rate'] * 0.044 ;

            if($rate->carrier == 'DHLExpress'){
                if($rate->service == "ExpressWorldwideNonDoc"){ $responseData[] = $rateArr; }
            }elseif($rate->carrier == 'Aramex'){
                if($rate->service == "PriorityParcelExpress"){
                // $responseData[] = $rateArr;
                 }
            }else{
                $responseData[] = $rateArr;
            }
        }
 dd($responseData);
        $this->manipulateChanges($responseData,$consolidation);
    }

    public function manipulateChanges($response,$consolidation){
      //  dd($response);
        // $goods_amount = [];
        // $j = 0;
        // foreach ($consolidation->packages as $key => $value) {
        //      foreach ($value->paidService as $key => $service_req) {
        //         $goods_amount['package_sevice_amount'][$j][] = $service_req->services->amount;
        //         $goods_amount['package_sevice_amount'][$j][] = $service_req->services->title;
        //         $j++;
        //      }
        // }



        if(!$consolidation->goods_description_ids == null){
            //dd('hhhh');
            $consolidation_goods = ConsolidationGoodsDescription::whereIn('id',$consolidation->goods_description_ids)->get();
            $i = 0;
            if($consolidation_goods){
                foreach ($response as $key => $data) {
                    foreach ($consolidation_goods as $key => $value) {

                        $carrier_allow = Courier::whereIn('id',$value->allowed_carriers)->get();


                        if($carrier_allow){
                            foreach ($carrier_allow as $key => $allow_courier) {
                                $carrier = $data['service'];
                                if(!empty($allow_courier->details) && ($allow_courier->details->easy_post == $carrier)){

                                   // dd($data['shipment_id']);
                                    $consolidation_charges = new ConsolidationCourierShippingCharges();
                                    $consolidation_charges->est_delivery_days = $data['est_delivery_days'];
                                    $consolidation_charges->shipping_rate_actual = $data['actaul_rate'];
                                    $consolidation_charges->rate = $data['rate'];
                                    $consolidation_charges->shipment_id = $data['shipment_id'];
                                    $consolidation_charges->consolidation_request_id = $consolidation->id;
                                    //$consolidation_charges->charges = $goods_amount;
                                    $consolidation_charges->courier_id = $allow_courier->id;
                                    //dd( $consolidation_charges);
                                    $consolidation_charges->save();
                                }
                            }
                        }
                    }
                }
            }
        }else{
            //dd('kkkk');
                foreach ($response as $key => $data) {
                    $search = $data['service'];
                   // dd($search);
                    $courier = Courier::where('details->easy_post','like','%'.$search.'%')->first();

                   if($courier){
                    $consolidation_charges = new ConsolidationCourierShippingCharges();
                    $consolidation_charges->est_delivery_days = $data['est_delivery_days'];
                    $consolidation_charges->shipping_rate_actual = $data['actaul_rate'];
                    $consolidation_charges->rate = $data['rate'];
                    $consolidation_charges->consolidation_request_id = $consolidation->id;
                    $consolidation_charges->shipment_id = $data['shipment_id'];
                    //$consolidation_charges->charges = $goods_amount;
                    $consolidation_charges->courier_id = $courier->id;
                    $consolidation_charges->save();
                   }

                }
        }
    }

    function endTask()
    {
        $start_time = request()->start_time_consolidation;
        //dd('strt='.$start_time.'---------end='.Carbon::now());

        $task       = Task::where('title','consolidation')->first();

            $task_detail                = new TaskDetail();
            $task_detail->ended_at      = Carbon::now();
            $task_detail->end_status    = 'task_ended';
            $task_detail->task_id       = $task->id;
            $task_detail->employee_id   = $this->employee_id;

            $task_detail->started_at    = $start_time;
            $is_saved                   = $task_detail->save();
             if($is_saved){
                $msg['status'] = 1;
                $msg['msg']         = "Task ended successfully ...";
            }else{
                $msg['status'] = 0;
            }

            return json_encode($msg);
    }

}

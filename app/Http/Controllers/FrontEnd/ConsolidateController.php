<?php

namespace App\Http\Controllers\FrontEnd;

require base_path().'/vendor/autoload.php';
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shopaholic;
use App\ShopaholicAddress;
use App\WalletRequest;
use App\Jobs\ConsolidationRequestLabelGenerate;

use Auth;
use App\User;
use App\Package;
use App\ConsolidationRequestInfo;
use App\PackageCustomDetail;
use App\ConsolidationRequest;
use App\WalletTransaction;
use JavaScript, DataTables;
use App\PackageService;
use App\Events\ConsolidationLogEvent;
use App\Charge;

use App\ShopaholicCreditInfo;
use App\PaymentMethod;
use App\ConsolidationCourierShippingCharges;
use App\ConsolidationRequestPaymentDetail;
use App\ConsolidationGoodsDescription;
use App\ShopaholicFailedTransaction;
use App\PackageCharge;
use Carbon\Carbon;
use Session;
use DB;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Api\Refund;
use PayPal\Api\RefundRequest;
use PayPal\Api\Sale;

use Config;
use Helper;

class ConsolidateController extends Controller
{
    public $api_context;

    function __construct()
    {
        //dd(route("storage.getpackages"));
        JavaScript::put([
            'getConRequests'       =>   route("frontend.consolidate.get_consolidation_requests")
        ]);

        Config::set('services.paypal.client_id',Helper::dbConfigValue('paypal','client_id'));
        Config::set('services.paypal.secret',Helper::dbConfigValue('paypal','client_secret'));

        $this->api_context = new ApiContext(
            new OAuthTokenCredential(config('services.paypal.client_id'), config('services.paypal.secret'))
        );
        $this->api_context->setConfig(config('services.paypal.settings'));
        Config::set('services.authorize_net.key',Helper::dbConfigValue('authorize_net','api_login_id'));
        Config::set('services.authorize_net.secret',Helper::dbConfigValue('authorize_net','transaction_key'));
    }

    public function getConsolidateInfo(){

    	$msg = [];
    	$id = Auth::user()->id;
        $package_custom_detail_obj = PackageCustomDetail::where('object_type','package')->whereIn('object_id',json_decode(request()->custom_value_package_id))->get();
        $sum_custom_value = 0;
        if($package_custom_detail_obj){
            foreach ($package_custom_detail_obj as $key => $value) {
                $sub_total = (float)$value->quantity * (float)$value->value;
                $sum_custom_value = (float)$sub_total + (float)$sum_custom_value;
            }
        }
    	$shopaholic = Shopaholic::where('user_id',$id)->with('addresses')->get(); 
    	$consolidate_request_infos = ConsolidationRequestInfo::all();
    	$msg['shopaholics'] = $shopaholic;
        $msg['custom_value'] = $sum_custom_value;
    	$msg['consolidate_request_infos'] = $consolidate_request_infos;
    	$msg['status'] = 1;
    	return json_encode($msg);
    }

    public function save(){
      //  dd(request()->all());
        $validatedData = request()->validate([
            'dest_add' => 'required'
        ]);
        $msg = [];

        $address_record = ShopaholicAddress::where('id',request()->dest_add)
                                    ->with('country')
                                    ->first();
    

        $address['name'] = $address_record->name;
        $address['phone'] = $address_record->phone;
        $address['street'] = $address_record->street;
        $address['city'] = $address_record->city;
        $address['iso']  = $address_record->country->iso;
        $address['state'] = $address_record->state;
        $address['zip_code'] = $address_record->zip_code;
        $address['country'] = $address_record->country->name;
       

        $consolidation = new ConsolidationRequest();
        $consolidation->address = $address;

        //dd($consolidation);
        $consolidation->status = 'preparing';
        if(request()->total_pkg > 1){
            $consolidation->type = 'combined';
        }else{
            $consolidation->type = 'individual';
        }
        $consolidation->unique_key = 'REQ-'.bin2hex(random_bytes(5)).time();
        $consolidation->special_instructions = request()->spec_req;
        $consolidation->shopaholic_id = Auth::user()->shopaholic->id;
        if(!empty(request()->spec)){
            $data = [];
            foreach (request()->spec as $key => $value) {
                $data[] = (int)$value;
            }
            $consolidation->request_infos  = $data;
        }

        $is_saved = $consolidation->save();
        event(new ConsolidationLogEvent($consolidation,'consolidation'));
        event(new ConsolidationLogEvent($consolidation,'preparing'));
        if($is_saved){
            $package_ids = explode(",", request()->pacakge_ids);

             $package = Package::whereIn('id',$package_ids)->update(['status'=>'review','consolidation_request_id'=>$consolidation->id]);

            foreach ($package_ids as $p_id) {
               $package =  Package::find($p_id);
                if($package->parent_package_id != NULL)
                {
                    $parent_package = Package::where('id',$package->parent_package_id)
                                                ->with('childSortedPackages')->first();
                    $sorted_childs = $parent_package->childSortedPackages->count();

                   // dd($sorted_childs);

                    if($sorted_childs ==0)
                    {
                         Package::where('id',$package->parent_package_id)->update(['status'=>'review']);
                    }
                    
                }
            }

          
            $msg['status'] = 1;
        }else{
            $msg['status'] = 0;
        }
        return response()->json($msg);
    }
    
    public function getReviewRequest(){
        $id = request()->id;
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
        $data['consolidation'] = $consolidation;
        $data['sum']  = $sum;
        $data['consolidation_request_info'] = $consolidation_request_info;
        $data['status'] = 1;
        return response()->json($data);
    }

    public function getAllCustomValue(){
        $id = request()->id;
        $packages = Package::where('consolidation_request_id',$id)->with('packageCustomDetail.category')->get();
        $data = [];
        if($packages){
            $data['packages'] = $packages;
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }
        return response()->json($data);
    }


    /*********************** Adnan Coding*******************/

    function getRequests($type){
        $shopaholic_id = Auth::user()->shopaholic->id;
        if($type=='outgoing')
            return $this->outgoing($shopaholic_id);
    }

   
    function outgoing($shopaholic_id){
        $cons_requests = ConsolidationRequest::where('shopaholic_id',$shopaholic_id)
                            ->where('status','preparing')
                            ->orWhere('status','payment_pending')
                            ->orWhere('status','processing')
                            //->where('parent_package_id',NULL)
                            ->with('packages','packages.packageCustomDetail.category','packages.paidService.services','packages.primaryThumbnail','packages.warehouseShelf')
                            ->withCount('packages');
        return DataTables::of($cons_requests)
            ->addColumn('additional_info',function($cons_request){
               $html ='<address>
                            <strong>No of Packages</strong> &nbsp;&nbsp;&nbsp;<label>'.$cons_request->packages_count.'</label>
                            <br>
                        </address>';         
               return $html;
            })->addColumn('address',function($cons_request){
                $html ='<address>
                            <strong>'.$cons_request->address->name.'</strong>
                            <br>
                            '.$cons_request->address->street.',
                            '.$cons_request->address->city.',
                            '.$cons_request->address->state.',
                            '.$cons_request->address->zip_code.',
                            '.$cons_request->address->country.'
                             <br>
                            <abbr title="Phone">P:</abbr>
                              '.$cons_request->address->phone.'
                            </address>';
                            return $html;
               })->addColumn('show_status',function($cons_request){
                if($cons_request->status == 'preparing'){
                    return '<label class="label label-warning">Preparing</label>';
                }
                if($cons_request->status == 'payment_pending'){
                    return '<label class="label label-danger">Payment Pending</label>';
                }
            })->rawColumns(['show_status','action','additional_info','address'])
            ->addColumn('action', function ($cons_request) {
                return view('frontend.dashboard.storage-ship.outgoing.action-button', ['result' => $cons_request, 'review_modal_id' => 'outgoing_review_request','custom_dec_model_id' => 'outgoing_complete_custom_value'])->render();
            })->make(true);
    }

    public function checkout($id){
        


        /*******************************/
        $consolidation = ConsolidationRequest::where('id',$id)->with('shopaholic.user','shopaholic.creditCardExist','shippingCharges.courier','packages.paidService.services')->first();
        //dd($consolidation);
        if($consolidation->goods_description_ids){
            $consolidation_goods = ConsolidationGoodsDescription::whereIn('id',$consolidation->goods_description_ids)->get();    
        }else{
            $consolidation_goods = collect([]);
        }

        $walletBalance = WalletRequest::walletBalance(Auth::user()->id);
        if ($walletBalance && $walletBalance->transaction) {
            $balance = $walletBalance->transaction->closing_balance;
        } else {
            $balance = '0.00';
        }
        
        $charges_global = Charge::whereJsonContains('applicable_module->name',["consolidation"])->get();
        $payment_methods = PaymentMethod::where('status','active')->get();
        return view('frontend.dashboard.storage-ship.outgoing.checkout',compact(['consolidation','charges_global','payment_methods','consolidation_goods','balance']));
    }

    public function checkoutSubmit(Request $request){
        $id = request()->shopaholic_id;
        request()->validate([
            'shipper_charges_id' => 'required',
            'payment_method_id' => 'required',
        ]);
        $payment_method = request()->payment_method_id;
        $payment_method = explode('_',$payment_method);
        $shipping_charges =  ConsolidationCourierShippingCharges::where('id',request()->shipper_charges_id)->first();
        $rate  = 0;
        $service_total = 0;
        $grand_total = 0;
        if($shipping_charges){
            $rate = $shipping_charges->rate;
            $consolidationRequest = ConsolidationRequest::where('id',$shipping_charges->consolidation_request_id)->with('packages.paidService.services')->first();
            foreach ($consolidationRequest->packages as $key => $package) {
                if($package->paidService){
                    foreach ($package->paidService as $index => $value) {
                        $service_total = (float)$value->services->amount + (float)$service_total;
                    }
                }
            }
            $goods_amount = 0;
            if($consolidationRequest->goods_description_ids){
                $consolidation_goods = ConsolidationGoodsDescription::whereIn('id',$consolidationRequest->goods_description_ids)->get();
                if($consolidation_goods->count() > 0){
                    foreach ($consolidation_goods as $key => $value) {
                        $goods_amount = (float)$value->amount + (float)$goods_amount;
                    }
                }
            }
            
            $globalCharges = Charge::whereJsonContains('applicable_module->name','consolidation')->get();
            $globalChargesTotal = $globalCharges->sum('amount');
            $grand_total = (float)$service_total + (float)$rate + (float)$globalChargesTotal + (float)$goods_amount;
        }
        if($payment_method[1] == 'crditCard'){
            request()->validate([
                'number' => 'required',
                'name' => 'required',
                'expiry' => 'required',
                'csv' => 'required',
            ]);
            $shopaholic_credit_card = ShopaholicCreditInfo::where('id',$payment_method[0])->first();
            $stripped = preg_replace('/\s/', '', request()->number);
            $last_degit = substr($stripped,-4);
         
            if($last_degit !== $shopaholic_credit_card->digit)
            {
                $msg['errors']['message'] = 'Credit Card Number cannot matched...';
                return response()->json($msg,422);
                exit;
            }
            $request->session()->put('shipping_cost', $shipping_charges->shipping_rate_actual);
            $processing_charges = (float)$shipping_charges->rate - (float)$shipping_charges->shipping_rate_actual;
            $processing_charges = (float)$globalChargesTotal + (float)$processing_charges;
            $request->session()->put('processing_charges', $processing_charges);
            $request->session()->put('service_total', $service_total);
            $request->session()->put('consolidation_request_id', $shipping_charges->consolidation_request_id);
            $request->session()->put('consolidation_courier_shipping_charge_id', request()->shipper_charges_id);
            $request->session()->save();
            if($request->use_wallet){
                $walletBalance = WalletRequest::walletBalance(Auth::user()->id);
                if ($walletBalance && $walletBalance->transaction) {
                    $balance = $walletBalance->transaction->closing_balance;
                } else {
                    $balance = '0.00';
                }
                if($grand_total > $balance){
                    $grand_total = (float)$grand_total - (float)$balance;
                    $request->session()->put('wallet_amount_deduct', $balance);
                    $request->session()->put('remaining_amount', $grand_total);
                    $request->session()->put('wallet_used', 1);
                    $request->session()->save();

                    $responseData = $this->chargeCreditCard($grand_total,request()->number,request()->expiry,request()->csv,Auth::user());
                    $responseMsg = $this->handleCreditCard($responseData);
                }else{
                    $request->session()->put('wallet_amount_deduct', $balance); // wallet total amount
                    $request->session()->put('remaining_amount', $grand_total); // grand total
                    $request->session()->put('wallet_used', 1);
                    $request->session()->save(); 
                    $responseMsg = $this->handleCreditCardWallet();
                }
            }else{
                $responseData = $this->chargeCreditCard($grand_total,request()->number,request()->expiry,request()->csv,Auth::user());
                $responseMsg = $this->handleCreditCard($responseData);
                
            } 
            
            
            if($responseMsg['status'] == 0){
                return response()->json($responseMsg,422);
            }else{
                return response()->json($responseMsg);
            }
            
            //dd($shopaholic_credit_card);
        }elseif($payment_method[1] == 'paymentMethod'){
            $payment_methods = PaymentMethod::where('id',$payment_method[0])->first();
            if($payment_methods->key == 'paypal'){
                if($payment_methods->charges_type == 'fixed'){
                    $grand_total = (float)$grand_total + (float)$payment_methods->charges;
                }
                $request->session()->put('shipping_cost', $shipping_charges->shipping_rate_actual);
                $processing_charges = (float)$shipping_charges->rate - (float)$shipping_charges->shipping_rate_actual;
                $processing_charges = (float)$globalChargesTotal + (float)$processing_charges;
                $request->session()->put('processing_charges', $processing_charges);
                $request->session()->put('goods_amount', $goods_amount);
                $request->session()->put('service_total', $service_total);
                $request->session()->put('paymeny_charges_type', $payment_methods->charges_type);
                $request->session()->put('paymeny_charges', $payment_methods->charges);
                $request->session()->put('consolidation_request_id', $shipping_charges->consolidation_request_id);
                $request->session()->put('consolidation_courier_shipping_charge_id', request()->shipper_charges_id);
                $request->session()->save();
                if($request->use_wallet){
                    $walletBalance = WalletRequest::walletBalance(Auth::user()->id);
                    if ($walletBalance && $walletBalance->transaction) {
                        $balance = $walletBalance->transaction->closing_balance;
                    } else {
                        $balance = '0.00';
                    }
                    if($grand_total > $balance){
                        $grand_total = (float)$grand_total - (float)$balance;
                        $request->session()->put('wallet_amount_deduct', $balance);
                        $request->session()->put('remaining_amount', $grand_total);
                        $request->session()->put('wallet_used', 1);
                        $request->session()->save();
                        $this->paypalMethod($payment_methods,$grand_total);
                    }else{
                        $request->session()->put('wallet_amount_deduct', $balance); // wallet total amount
                        $request->session()->put('remaining_amount', $grand_total); // grand total
                        $request->session()->put('wallet_used', 1);
                        $request->session()->save(); 
                        $this->confirmDepositWallet($request);
                    }
                }else{
                     $this->paypalMethod($payment_methods,$grand_total);
                }        
            }
        }
    }
    public function paypalMethod($payment_method,$grand_total){
        // $this->validate(request(), [
        // 'amount'    => ['required','numeric',new TotalWithdraw],
        // ]);
        $pay_amount = $grand_total;
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $item1 = new Item();
        $item1->setName('Deposit Money')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setSku("123123")
            ->setPrice($pay_amount);
        $itemList = new ItemList();
        $itemList->setItems(array($item1));
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($pay_amount); 
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Paying money for shipping charges.")
            ->setInvoiceNumber(uniqid());
        //$baseUrl = getBaseUrl();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('frontend.consolidate.confirm_deposit'))
        ->setCancelUrl(route('frontend.consolidate.confirm_deposit'));
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        //$request = clone $payment;
        try {
            $payment->create($this->api_context);
        } catch (PayPalConnectionException $ex){
            return back()->withError('Some error occur, sorry for inconvenient');
        } catch (Exception $ex) {
            return back()->withError('Some error occur, sorry for inconvenient');
        }
        $approvalUrl = $payment->getApprovalLink();
        if(!empty($approvalUrl)) {
            //request()->session()->put('amount', $pay_amount);
            $res = [];
            $res['approved_url'] = $approvalUrl;
            echo json_encode($res);
            exit();
        }else {     
            return redirect()->route('storage.index','list')->with( ['status' => 0,'paypal_res' => 1,'message' => 'Something went wrong...']);    
            // return redirect()->route('wallet.index')->with( ['status' => 0,'paypal_res' => 1,'message' => 'Something went wrong...']);
        }
    }

    public function confirmDeposit(Request $request){
        //dd($request->session()->all());
        if (empty($request->query('paymentId')) || empty($request->query('PayerID')) || empty($request->query('token'))){
            // return redirect()->route('wallet.index')->with( ['status' => 0,'paypal_res' => 1,'message' => 'Payment was not successfully Something went wrong...']);
            return redirect()->route('storage.index','list')->with( ['status' => 0,'paypal_res' => 1,'message' => 'Something went wrong...']);
        }
        try {
            $payment = Payment::get($request->query('paymentId'), $this->api_context);
            $execution = new PaymentExecution();
            $execution->setPayerId($request->query('PayerID'));
            $result = $payment->execute($execution, $this->api_context);
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
           return redirect()->route('wallet.index')->with( ['status' => 0,'paypal_res' => 1,'message' => 'Something went wrong...']);
        } catch (Exception $ex) {
           return redirect()->route('wallet.index')->with( ['status' => 0,'paypal_res' => 1,'message' => 'Something went wrong...']);
        }
        $paymentDetail = new ConsolidationRequestPaymentDetail();
        $paymentDetail->shipping_cost = $request->session()->get('shipping_cost');
        if($request->session()->get('paymeny_charges_type') == 'fixed'){
            $processing_charges = (float)$request->session()->get('processing_charges') + (float)$request->session()->get('paymeny_charges');
            $paymentDetail->processing_charges = $processing_charges;
        }
        $process_charging = [];
        $globalCharges = Charge::whereJsonContains('applicable_module->name','consolidation')->get();
        $global = [];
        foreach ($globalCharges as $key => $value) {
            $global[$key][] = $value->title;
            $global[$key][] = $value->amount;
        }
        $process_charging = [
            'payment' => [
                'via' => 'paypal',
                'paymentID' => $request->query('paymentId'),
                'payerID'   => $request->query('PayerID'),
            ],
            'chargesDetail' => [
                'paymentProcessFee' => [
                    'amount' => $request->session()->get('paymeny_charges'),
                    'type'   => $request->session()->get('paymeny_charges_type'),
                    'wallet_uses' => [
                        'wallet_amount_deduct' =>  $request->session()->get('wallet_amount_deduct'),
                        'remaining_amount' => $request->session()->get('remaining_amount'),
                        'remaining_amount_type' => 'paypal'
                    ],
                ],
                'service' => [
                    'amount' => $request->session()->get('service_total'), 
                ],
                'global' => $global,
            ]
        ];
        $paymentDetail->processing_charges_details = $process_charging;
        $paymentDetail->total_cost = (float)$processing_charges + (float)$request->session()->get('shipping_cost') + (float)$request->session()->get('service_total') + (float)$request->session()->get('goods_amount');
        $paymentDetail->paid_at = Carbon::now()->toDateTimeString();
        $paymentDetail->consolidation_request_id = $request->session()->get('consolidation_request_id');
        $paymentDetail->consolidation_courier_shipping_charge_id = $request->session()->get('consolidation_courier_shipping_charge_id');
        $is_saved = $paymentDetail->save();
        if($request->session()->get('wallet_used') == 1){
           // dd(1);
             $transaction                    = WalletRequest::where('user_id', Auth::user()->id)
                ->where('status', 'processed')
                ->orderBy('created_at', 'desc')
                ->take('1')
                ->with(['transaction' => function ($query) {
                        $query->orderBy('created_at', 'desc')->take('1');
                    }])
                ->first();
               // dd($transaction);
            $wallet_request = new WalletRequest();  
            $wallet_request->amount = $request->session()->get('wallet_amount_deduct');
            $wallet_request->status = 'processed';
            $wallet_request->type   = 'offline_payment';
            $wallet_request->processed_by = Auth::user()->shopaholic->id;
            $wallet_request->user_id   = Auth::user()->id;
            $wallet_request->save();
            if ($transaction) {
                $transaction_obj = new WalletTransaction();
                if($wallet_request->type == "offline_payment")
                {
                    $transaction_obj->opening_balance   = $transaction->transaction->closing_balance;
                    $balance                            = $transaction_obj->opening_balance - $wallet_request->amount;
                    $transaction_obj->closing_balance   = $balance;
                    $transaction_obj->request_id        = $wallet_request->id;
                }
            }
                DB::transaction(function () use($transaction_obj){
                    $transaction_obj->save();
                });
        }
       // dd($is_saved);
        $msg = [];
        if($is_saved){
            $this->packageCharges();
            $request->session()->forget('paymeny_charges');
            $request->session()->forget('paymeny_charges_type');
            $request->session()->forget('wallet_used');
            $request->session()->save();
            return redirect()->route('storage.index','list')->with( ['status' => 1,'paypal_res' => 1,'message' => 'Payment sucscessfully processed...']);
        }
        
       // return response()->json($msg);  
    }
    public function confirmDepositWallet($request){
        $paymentDetail = new ConsolidationRequestPaymentDetail();
        $paymentDetail->shipping_cost = $request->session()->get('shipping_cost');
        if($request->session()->get('paymeny_charges_type') == 'fixed'){
            $processing_charges = (float)$request->session()->get('processing_charges') + (float)$request->session()->get('paymeny_charges');
            $paymentDetail->processing_charges = $processing_charges;
        }
        $process_charging = [];
        $globalCharges = Charge::whereJsonContains('applicable_module->name','consolidation')->get();
        $global = [];
        foreach ($globalCharges as $key => $value) {
            $global[$key][] = $value->title;
            $global[$key][] = $value->amount;
        }
        $process_charging = [
            'payment' => [
                'via' => 'paypal_local',
                'paymentID' => '',
                'payerID'   => '',
            ],
            'chargesDetail' => [
                'paymentProcessFee' => [
                    'amount' => $request->session()->get('paymeny_charges'),
                    'type'   => $request->session()->get('paymeny_charges_type'),
                    'wallet_uses' => [
                        'wallet_amount_deduct' =>  $request->session()->get('wallet_amount_deduct'),
                        'remaining_amount' => $request->session()->get('remaining_amount'),
                        'remaining_amount_type' => 'wallet'
                    ],
                ],
                'service' => [
                    'amount' => $request->session()->get('service_total'), 
                ],
                'global' => $global,
            ]
        ];
        $paymentDetail->processing_charges_details = $process_charging;
        $paymentDetail->total_cost = (float)$processing_charges + (float)$request->session()->get('shipping_cost') + (float)$request->session()->get('service_total') + (float)$request->session()->get('goods_amount');
        $paymentDetail->paid_at = Carbon::now()->toDateTimeString();
        $paymentDetail->consolidation_request_id = $request->session()->get('consolidation_request_id');
        $paymentDetail->consolidation_courier_shipping_charge_id = $request->session()->get('consolidation_courier_shipping_charge_id');
        $is_saved = $paymentDetail->save();
        //dd($request->session()->get('wallet_used'));
        if($request->session()->get('wallet_used') == 1){
             $transaction                    = WalletRequest::where('user_id', Auth::user()->id)
                ->where('status', 'processed')
                ->orderBy('created_at', 'desc')
                ->take('1')
                ->with(['transaction' => function ($query) {
                        $query->orderBy('created_at', 'desc')->take('1');
                    }])
                ->first();
               // dd($transaction);
            $wallet_request = new WalletRequest();  
            $wallet_request->amount = $request->session()->get('remaining_amount');
            $wallet_request->status = 'processed';
            $wallet_request->type   = 'offline_payment';
            $wallet_request->processed_by = Auth::user()->shopaholic->id;
            $wallet_request->user_id   = Auth::user()->id;
            $wallet_request->save();
            if ($transaction) {
                $transaction_obj = new WalletTransaction();
                if($wallet_request->type == "offline_payment")
                {
                    $transaction_obj->opening_balance   = $transaction->transaction->closing_balance;
                    $balance                            = $transaction_obj->opening_balance - $wallet_request->amount;
                    $transaction_obj->closing_balance   = $balance;
                    $transaction_obj->request_id        = $wallet_request->id;
                }
            }
                DB::transaction(function () use($transaction_obj){
                    $transaction_obj->save();
                });
        }
        $msg = [];
        if($is_saved){
            $this->packageCharges();
            $request->session()->forget('paymeny_charges');
            $request->session()->forget('paymeny_charges_type');
            $request->session()->forget('wallet_used');
            $request->session()->save();
            $res['approved_url'] = route('storage.index','list');
            echo json_encode($res);
            exit();
        }
        
       // return response()->json($msg);  
    }
    public function chargeCreditCard($amount,$cardNumber,$expirationDate,$cardCode,$user){
        $amount = number_format((float)$amount, 2, '.', '');
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        
        
        $merchantAuthentication->setName(Config::get('services.authorize_net.key'));  // Test
        $merchantAuthentication->setTransactionKey(Config::get('services.authorize_net.secret'));  // Test
        $refId = 'ref' . time();

        $exp=filter_var ( trim(2030)."-".trim(11), FILTER_SANITIZE_STRING);
    
        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($exp);
        $creditCard->setCardCode($cardCode);
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        $order = new AnetAPI\OrderType();
        $order->setDescription("Shipping Payment");

        $shipto = new AnetAPI\NameAndAddressType();
        $shipto->setFirstName($user->first_name);
        $shipto->setLastName($user->last_name);
        $shipto->setAddress($user->shopaholic->primaryAddress->street);
        $shipto->setCity($user->shopaholic->primaryAddress->city);     
        $shipto->setState($user->shopaholic->primaryAddress->state);    
        $shipto->setZip($user->shopaholic->primaryAddress->zip_code);
        $shipto->setCountry($user->country->name);   

        // Bill To
        $billto = new AnetAPI\CustomerAddressType();
        $billto->setFirstName($user->first_name);
        $billto->setLastName($user->last_name);      
        $billto->setAddress($user->shopaholic->primaryAddress->street);  
        $billto->setCity($user->shopaholic->primaryAddress->city);        
        $billto->setState($user->shopaholic->primaryAddress->state);         
        $billto->setZip($user->shopaholic->primaryAddress->zip_code);     
        $billto->setCountry($user->country->name);       


        //create a transaction
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType( "authCaptureTransaction");
        $transactionRequestType->setAmount($amount);
        $transactionRequestType->setOrder($order);
        $transactionRequestType->setBillTo($billto);
        $transactionRequestType->setCustomerIP($_SERVER['REMOTE_ADDR']);
        $transactionRequestType->setShipTo($shipto);
        $transactionRequestType->setPayment($paymentOne);

        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setTransactionRequest( $transactionRequestType);
        $controller = new AnetController\CreateTransactionController($request);

        //$response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION); // live
        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);  // test
         
        $responseData = [];
        if ($response != null) {
            if ($response->getMessages()->getResultCode() == "Ok") {
                $tresponse = $response->getTransactionResponse();
                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $responseData['success'] = 1;
                    $responseData['transactionID:'] = $tresponse->getTransId();

                } else {
                    if ($tresponse->getErrors() != null) {
                        $responseData['success']        = 0;
                        $responseData['errorCode']      = $tresponse->getErrors()[0]->getErrorCode();
                        $responseData['errorMessage']   = $tresponse->getErrors()[0]->getErrorText();
                    }
                }
            } else {
                $tresponse = $response->getTransactionResponse();
                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $responseData['success']        = 0;
                    $responseData['errorCode']      = $tresponse->getErrors()[0]->getErrorCode();
                    $responseData['errorMessage']   = $tresponse->getErrors()[0]->getErrorText();
                } else {
                    $responseData['success']        = 0;
                    $responseData['errorCode']      = $response->getMessages()->getMessage()[0]->getCode();
                    $responseData['errorMessage']   = $response->getMessages()->getMessage()[0]->getText();
                }
            }
        } else {
            $responseData['success']        = 0;
            $responseData['errorCode']      = "No response returned";
            $responseData['errorMessage']   = "No response returned";
        }

        if($responseData['success'] == 0){
            $failedTransaction                      = new ShopaholicFailedTransaction;
            $failedTransaction->shopaholic_id       = $user->shopaholic->id;
            $failedTransaction->error_msg           = $responseData['errorMessage'];
            $failedTransaction->error_code          = $responseData['errorCode'];
            $failedTransaction->payment_gateway     = "Authorize.net";
            $failedTransaction->save();

        }
        return $responseData;
        
    }
    public function handleCreditCard($response){
        if($response['success'] > 0){
            $paymentDetail = new ConsolidationRequestPaymentDetail();
            $paymentDetail->shipping_cost = request()->session()->get('shipping_cost');
            $paymentDetail->processing_charges = request()->session()->get('processing_charges');
            $process_charging = [];
            $globalCharges = Charge::whereJsonContains('applicable_module->name','consolidation')->get();
            $global = [];
            foreach ($globalCharges as $key => $value) {
                $global[$key][] = $value->title;
                $global[$key][] = $value->amount;
            }
            $process_charging = [
                'payment' => [
                    'via' => 'creditCard',
                    'transactionID' => $response['transactionID:']
                ],
                'chargesDetail' => [
                    'paymentProcessFee' => [
                        'amount' => '',
                        'type'   => '',
                        'wallet_uses' => [
                            'wallet_amount_deduct' =>  request()->session()->get('wallet_amount_deduct'),
                            'remaining_amount' => request()->session()->get('remaining_amount'),
                            'remaining_amount_type' => 'credit_card'
                        ],
                    ],
                    'service' => [
                        'amount' => request()->session()->get('service_total'), 
                    ],
                    'global' => $global,
                ]
            ];
            
            $paymentDetail->processing_charges_details = $process_charging;
            $paymentDetail->total_cost = (float)request()->session()->get('processing_charges') + (float)request()->session()->get('shipping_cost') + (float)request()->session()->get('service_total');
            $paymentDetail->paid_at = Carbon::now()->toDateTimeString();
            $paymentDetail->consolidation_request_id = request()->session()->get('consolidation_request_id');
            $paymentDetail->consolidation_courier_shipping_charge_id = request()->session()->get('consolidation_courier_shipping_charge_id');
            $is_saved = $paymentDetail->save();
            if(request()->session()->get('wallet_used') == 1){
                $transaction = WalletRequest::where('user_id', Auth::user()->id)
                    ->where('status', 'processed')
                    ->orderBy('created_at', 'desc')
                    ->take('1')
                    ->with(['transaction' => function ($query) {
                            $query->orderBy('created_at', 'desc')->take('1');
                        }])
                    ->first();
                   // dd($transaction);
                $wallet_request = new WalletRequest();  
                $wallet_request->amount = request()->session()->get('wallet_amount_deduct');
                $wallet_request->status = 'processed';
                $wallet_request->type   = 'offline_payment';
                $wallet_request->processed_by = Auth::user()->shopaholic->id;
                $wallet_request->user_id   = Auth::user()->id;
                $wallet_request->save();
                if ($transaction) {
                    $transaction_obj = new WalletTransaction();
                    if($wallet_request->type == "offline_payment")
                    {
                        $transaction_obj->opening_balance   = $transaction->transaction->closing_balance;
                        $balance                            = $transaction_obj->opening_balance - $wallet_request->amount;
                        $transaction_obj->closing_balance   = $balance;
                        $transaction_obj->request_id        = $wallet_request->id;
                    }
                }
                    DB::transaction(function () use($transaction_obj){
                        $transaction_obj->save();
                    });
            }
            $msg = [];
            if($is_saved){         
                $arr = [];

                $this->packageCharges();
                
                $msg['status'] = 1;
            }else{
                $msg['status'] = 0;
            }
        }elseif($response['errorCode'] == 11 && $response['success'] == 0){
            $msg['status'] = 0;
            $msg['errors']['message'] = 'A duplicate transaction has been submitted.';
        }
        elseif($response['errorCode'] == '6' && $response['success'] == 0){
            $msg['status'] = 0;
            $msg['errors']['message'] = 'Credit Card Number is Invalid.';
        }elseif($response['errorCode'] == 'E00003' && $response['success'] == 0){
            $msg['status'] = 0;
            $msg['errors']['message'] = 'Credit Card Number is Invalid.';
        }
        request()->session()->forget('paymeny_charges');
        request()->session()->forget('paymeny_charges_type');
        request()->session()->forget('wallet_used');
        request()->session()->save();
        return $msg;     
    }
    public function handleCreditCardWallet(){
            $paymentDetail = new ConsolidationRequestPaymentDetail();
            $paymentDetail->shipping_cost = request()->session()->get('shipping_cost');
            $paymentDetail->processing_charges = request()->session()->get('processing_charges');
            $process_charging = [];
            $globalCharges = Charge::whereJsonContains('applicable_module->name','consolidation')->get();
            $global = [];
            foreach ($globalCharges as $key => $value) {
                $global[$key][] = $value->title;
                $global[$key][] = $value->amount;
            }
            $process_charging = [
                'payment' => [
                    'via' => 'creditCard',
                    'transactionID' => ''
                ],
                'chargesDetail' => [
                    'paymentProcessFee' => [
                        'amount' => '',
                        'type'   => '',
                        'wallet_uses' => [
                            'wallet_amount_deduct' =>  request()->session()->get('remaining_amount'),
                            'remaining_amount' => request()->session()->get('wallet_amount_deduct'),
                            'remaining_amount_type' => 'credit_card'
                        ],
                    ],
                    'service' => [
                        'amount' => request()->session()->get('service_total'), 
                    ],
                    'global' => $global,
                ]
            ];
            $paymentDetail->processing_charges_details = $process_charging;
            $paymentDetail->total_cost = (float)request()->session()->get('processing_charges') + (float)request()->session()->get('shipping_cost') + (float)request()->session()->get('service_total');
            $paymentDetail->paid_at = Carbon::now()->toDateTimeString();
            $paymentDetail->consolidation_request_id = request()->session()->get('consolidation_request_id');
            $paymentDetail->consolidation_courier_shipping_charge_id = request()->session()->get('consolidation_courier_shipping_charge_id');
            $is_saved = $paymentDetail->save();
            if(request()->session()->get('wallet_used') == 1){
                $transaction = WalletRequest::where('user_id', Auth::user()->id)
                    ->where('status', 'processed')
                    ->orderBy('created_at', 'desc')
                    ->take('1')
                    ->with(['transaction' => function ($query) {
                            $query->orderBy('created_at', 'desc')->take('1');
                        }])
                    ->first();
                   // dd($transaction);
                $wallet_request = new WalletRequest();  
                $wallet_request->amount = request()->session()->get('remaining_amount');
                $wallet_request->status = 'processed';
                $wallet_request->type   = 'offline_payment';
                $wallet_request->processed_by = Auth::user()->shopaholic->id;
                $wallet_request->user_id   = Auth::user()->id;
                $wallet_request->save();
                if ($transaction) {
                    $transaction_obj = new WalletTransaction();
                    if($wallet_request->type == "offline_payment")
                    {
                        $transaction_obj->opening_balance   = $transaction->transaction->closing_balance;
                        $balance                            = $transaction_obj->opening_balance - $wallet_request->amount;
                        $transaction_obj->closing_balance   = $balance;
                        $transaction_obj->request_id        = $wallet_request->id;
                    }
                }
                    DB::transaction(function () use($transaction_obj){
                        $transaction_obj->save();
                    });
            }
            $msg = [];
            if($is_saved){         
                $arr = [];
                $this->packageCharges();
                $msg['status'] = 1;
            }else{
                $msg['status'] = 0;
            }
        return $msg;     
    }
    public function packageCharges(){
        $consolidationRequest = ConsolidationRequest::where('id',request()->session()->get('consolidation_request_id'))->with('packages.paidService.services')->first();
       // dd($consolidationRequest);
        foreach ($consolidationRequest->packages as $key => $package) {
            if($package->paidService){
                foreach ($package->paidService as $index => $value) {
                    $packageCharge = new PackageCharge();
                    $packageCharge->title = $value->services->title;
                    $packageCharge->action_type = $value->services->type;
                    $packageCharge->charges = $value->services->amount;
                    $packageCharge->package_id = $value->package_id;
                    $packageCharge->save();
                }
            }
            $free_services = $package->free_services;
            if($free_services){
                $serviceFree = PackageService::whereIn('id',$free_services)->get();
                if($serviceFree){
                    foreach ($serviceFree as $key => $value) {
                        $packageCharge = new PackageCharge();
                        $packageCharge->title = $value->title;
                        $packageCharge->action_type = $value->type;
                       // $packageCharge->charges = $value->amount;
                        $packageCharge->package_id = $package->id;
                        $packageCharge->save();
                    }
                }
            }
        }

        $consolidationRequest->status = 'processing';
        $is_saved  = $consolidationRequest->save();

        if($is_saved){
            $consolidationRequest->packages()->update(['status' => 'processing']);
        }

        event(new ConsolidationLogEvent($consolidationRequest,'processing'));
        ConsolidationRequestLabelGenerate::dispatch(request()->session()->get('consolidation_request_id'))->onConnection('database');
    }
}

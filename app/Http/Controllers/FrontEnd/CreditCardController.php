<?php

namespace App\Http\Controllers\FrontEnd;

require base_path().'/vendor/autoload.php';
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Illuminate\Http\Request;
use App\ShopaholicCreditInfo;
use App\ShopaholicFailedTransaction;
use App\User;
use App\WalletRequest;
use App\WalletTransaction;
use App\Shopaholic;
use App\Rules\TotalWithdraw;
use Auth;
use DB;
use Config;
use Helper;
use Session;
use App\Http\Controllers\Controller;

class CreditCardController extends Controller
{

	function __construct()
	{
		Config::set('services.authorize_net.key',Helper::dbConfigValue('authorize_net','api_login_id'));
		Config::set('services.authorize_net.secret',Helper::dbConfigValue('authorize_net','transaction_key'));
	}
	 

	public function AddCreditCard(){

		$this->validate(request(), [
		'number'				 => 'required',
		'name'					 => 'required',
		'expiry' 				 => 'required',
		'cvc'					 => 'required',
		'type'					 => 'required',
		'g-recaptcha-response'	 => 'required',
		]); 
		$cardNumber			=  request()->number; 
		$name           	=  request()->name;
		$expirationDate 	=  request()->expiry;
		$cardCode 			=  request()->cvc;
		$type 				=  request()->type; 
		$shopaholic_id  	=  Auth::user()->shopaholic->id;
		$stripped = preg_replace('/\s/', '', $cardNumber);
		$degit = substr($stripped,-4);

		$creditCardInfo = ShopaholicCreditInfo::where('shopaholic_id', $shopaholic_id)->where('digit', $degit)->first();
		if(!$creditCardInfo) {
	       	$credit_card_obj 					= new ShopaholicCreditInfo;
	       	$credit_card_obj->digit 			= $degit;
	       	$credit_card_obj->type				= $type;
	       	$credit_card_obj->shopaholic_id 	= $shopaholic_id;

	       	$user = Auth::user();
	       	for($i=0; $i<2; $i++){
	       		$amount = rand(1, 10) / 10;
	       		$responseData = $this->chargeCreditCard($amount,$stripped,$expirationDate,$cardCode,$user);

		       	if ($responseData['success'] == 1) {
		       		if($i == 0){
		       			$credit_card_obj->first_transec_amount = $amount;
		       		} else {
		       			$credit_card_obj->second_transec_amount = $amount;
		       		}
		       		$credit_card_obj->save();
		       		$responseData = [
		       			"success" => true,
		       			'data'    => $this->creditCardJson()
		       		];
		       	}else {
		       		$responseData = array("success"=>false, "errorMsg" => $responseData['errorMessage']);
		       	}
	       	}
		}else{
			$responseData = [
				"card_used" => 1,
				"errorMsg"=> "This Card have already been used."
			];
		}

     echo json_encode($responseData);
	}

	public function chargeCreditCard($amount,$cardNumber,$expirationDate,$cardCode,$user){

		$amount = number_format((float)$amount, 2, '.', '');
		// Common setup for API credentials
		$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
		//$merchantAuthentication->setName('643dHGpy'); // live
		//$merchantAuthentication->setTransactionKey('4KwP2A5n6XZsy879'); // live
		
		
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
		$order->setDescription("New Item");

		$shipto = new AnetAPI\NameAndAddressType();
		$shipto->setFirstName($user->first_name);
		$shipto->setLastName($user->last_name);
		$shipto->setAddress($user->shopaholic->address->street);
		$shipto->setCity($user->shopaholic->address->city);     
		$shipto->setState($user->shopaholic->address->state);    
		$shipto->setZip($user->shopaholic->address->zip_code);
		$shipto->setCountry($user->country->name);   

		// Bill To
		$billto = new AnetAPI\CustomerAddressType();
		$billto->setFirstName($user->first_name);
		$billto->setLastName($user->last_name);      
		$billto->setAddress($user->shopaholic->address->street);  
		$billto->setCity($user->shopaholic->address->city);        
		$billto->setState($user->shopaholic->address->state);         
		$billto->setZip($user->shopaholic->address->zip_code);     
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
	                	$responseData['success'] 		= 0;
	                	$responseData['errorCode'] 		= $tresponse->getErrors()[0]->getErrorCode();
	                	$responseData['errorMessage'] 	= $tresponse->getErrors()[0]->getErrorText();
	                }
	            }
	        } else {
	            $tresponse = $response->getTransactionResponse();
	            if ($tresponse != null && $tresponse->getErrors() != null) {
                	$responseData['success'] 		= 0;
                	$responseData['errorCode'] 		= $tresponse->getErrors()[0]->getErrorCode();
                	$responseData['errorMessage'] 	= $tresponse->getErrors()[0]->getErrorText();
	            } else {
	                $responseData['success'] 		= 0;
                	$responseData['errorCode'] 		= $response->getMessages()->getMessage()[0]->getCode();
                	$responseData['errorMessage'] 	= $response->getMessages()->getMessage()[0]->getText();
	            }
	        }
	    } else {
    		$responseData['success'] 		= 0;
        	$responseData['errorCode'] 		= "No response returned";
        	$responseData['errorMessage'] 	= "No response returned";
	    }

	    if($responseData['success'] == 0){
	    	$failedTransaction 						= new ShopaholicFailedTransaction;
	    	$failedTransaction->shopaholic_id 		= $user->shopaholic->id;
	    	$failedTransaction->error_msg 			= $responseData['errorMessage'];
	    	$failedTransaction->error_code 			= $responseData['errorCode'];
	    	$failedTransaction->payment_gateway 	= "Authorize.net";
	    	$failedTransaction->save();

	    }
		return $responseData;
	}

	public function creditCardJson(){
		return User::where('id',Auth::user()->id)->with(['shopaholic.creditCardInfo'])->get();
	}

	public function verifyCard(){
		$validatedData = request()->validate([
			'first_transaction_amount'  => 'required',
			'second_transaction_amount' => 'required',
			'last_four_digit'           => 'required|numeric'
		]);

		if(!Session::has('attempt_d')){
	 		Session::put('attempt_d', 1); 
	 	}

		$logged_id = Auth::user()->shopaholic->id;
		$shopaholic_credit_card_info = ShopaholicCreditInfo::where([
			['shopaholic_id' , $logged_id],
			['first_transec_amount' , request()->first_transaction_amount],
			['second_transec_amount' , request()->second_transaction_amount],
			['digit' , request()->last_four_digit],
		])->first();
		if($shopaholic_credit_card_info)
		{
			$shopaholic_credit_card_info->status = 'verified';
			$shopaholic_credit_card_info->verified_through = 'authorize_net';
			$is_update = $shopaholic_credit_card_info->update();
			if($shopaholic_credit_card_info) {
				$msg['status'] = 1;
				return json_encode($msg);
			} else {
				$msg['status'] = "0";
				return json_encode($msg);
			}
		}else{
			$shopaholic_credit_card_info_obj = ShopaholicCreditInfo::where('shopaholic_id' , $logged_id)->where('digit',request()->digit_attempt)->first();
		 	 
			if(Session::get('attempt_d') <= 2){
				if(Session::get('attempt_d') == 2){
					$shopaholic_credit_card_info_obj->status = 'blocked';
				}
				$shopaholic_credit_card_info_obj->attempt = Session::get('attempt_d');
				$shopaholic_credit_card_info_obj->update();
				if(Session::get('attempt_d') == 2){
					Session::forget('attempt_d');
					Session::save();
					$msg['status'] = '5';
					return json_encode($msg);
				}
				$a = Session::get('attempt_d')+1;
				Session::put('attempt_d',$a);
				
				$msg['status'] = '0';
				return json_encode($msg);

			}else{
					$msg['status'] = '5';
					return json_encode($msg);
				}
			
		} 
	}

	public function creditCardExist() {
		$id = Auth::user()->id; 
		$shopaholic = Shopaholic::where('user_id',$id)->with('creditCardExist')->first(); 
		if($shopaholic->creditCardExist->count() > 0) {
			$msg['data'] = $shopaholic->creditCardExist;
			$msg['status'] = 1;
			return $msg;
		}
		else {
			$msg['status'] = 0;
			return json_encode($msg);
		}
	}

	public function depositCreditCard() {

		$this->validate(request(), [
		'number'				 => 'required',
		'name'					 => 'required',
		'expiry' 				 => 'required',
		'cvc'					 => 'required',
		'amount'			     => ['required','numeric',new TotalWithdraw],
		'credit_card'			 => 'required',
		]);

		$cardNumber			=  request()->number; 
		$name           	=  request()->name;
		$expirationDate 	=  request()->expiry;
		$cardCode 			=  request()->cvc;
		$amount 			=  request()->amount;
		$lastFourDigit 		=  request()->credit_card;
		$stripped = preg_replace('/\s/', '', $cardNumber);
		$last_degit = substr($stripped,-4);
	 
		if($last_degit !== $lastFourDigit)
		{
			$msg['status'] = 'not_matched';
			$msg['message'] = 'Credit Card Number cannot matched...';
			return json_encode($msg);
			exit;
		}
 
		$shopaholic_credit_card_info = ShopaholicCreditInfo::where('digit',$lastFourDigit)->where('status','!=','blocked')->where('shopaholic_id',request()->shopaholic_id)->first();
		 

		if($shopaholic_credit_card_info) {
			$response = $this->chargeCreditCard($amount,$cardNumber,$expirationDate,$cardCode,Auth::user());
			  
			 

			if ($response['success'] == 1) {
		       	$transactionId = $response['transactionID:']; 
				$wallet_request = new WalletRequest();
				$wallet_request->type = 'deposit';
				$wallet_request->status = 'processed';
				$wallet_request->details = ['deposit' => ['transactionID' => $transactionId,'process_via' => 'authorize_net','credit_card_last_digit' => $lastFourDigit],'child_request_id' => "0",];
				$wallet_request->amount = $amount;
				$wallet_request->user_id = Auth::user()->id;
				$transaction = WalletRequest::where('user_id', Auth::user()->id)
				->where('status', 'processed')
				->orderBy('created_at', 'desc')
				->take('1')
				->with(['transaction' => function ($query) {
						$query->orderBy('created_at', 'desc')->take('1');
					}])
				->first(); 
				$transaction_obj = new WalletTransaction();
				if ($transaction) {
					$transaction_obj->opening_balance = $transaction->transaction->closing_balance;
					$balance = $transaction_obj->opening_balance + $amount;
					$transaction_obj->closing_balance = $balance;
					
				}
				else {

						$transaction_obj->opening_balance = 0;
						$transaction_obj->closing_balance = $amount;
						
					}
				

				DB::transaction(function () use($wallet_request,$transaction_obj){

						$wallet_request->save();
						$transaction_obj->request_id = $wallet_request->id;
						$transaction_obj->save();						
					}); 



		       		$msg['status'] = 1;
					$msg['message'] = 'Amount successfully deposit.';
					return json_encode($msg);
					exit;
		       	}
		       	//if credit card request again submit.
		       	elseif($response['errorCode'] == 11 && $response['success'] == 0)
		       	{

		       		$msg['status'] = 'not';
					$msg['message'] = 'A duplicate transaction has been submitted.';
					return json_encode($msg);
					exit;
		       	}
		       	//if credit card number is invalid
		       	if($response['errorCode'] == '6' && $response['success'] == 0)
		       	{

		       		$msg['status'] = 'not';
					$msg['message'] = 'Credit Card Number is Invalid.';
					return json_encode($msg);
					exit;
		       	}
		       	//If credit card length is incorrect 
		       	elseif($response['errorCode'] == 'E00003' && $response['success'] == 0)
		       	{
		       		$msg['status'] = 'not';
					$msg['message'] = 'Credit Card Number is Invalid.';
					return json_encode($msg);
					exit;
		       	}

		}else {
			$msg['status'] = 'not';
			$msg['message'] = ' Credit Card cannot exist...';
			return json_encode($msg);
		}
	}

	public function refundTransaction() {
		$request_id = request()->id;
		$wallet_request = WalletRequest::where('id',$request_id)->first();
		$walletBalance = WalletRequest::walletBalance(Auth::user()->id);

		if ($walletBalance && $walletBalance->transaction) {
			$balance = $walletBalance->transaction->closing_balance;
				if($balance > $wallet_request->amount || $balance == $wallet_request->amount)
				{
					if($wallet_request->details->deposit->process_via == 'authorize_net') {
						$response = $this->getTransactionDetails($wallet_request->details->deposit->transactionID);  
					if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
					{
					    if($response->getTransaction()->getTransactionStatus() == 'settledSuccessfully')
					    {
					    	$responseRefund = $this->refundTransactionOriginal($wallet_request); 
					    	 if($responseRefund['success'] == 1) { 
					    	 	$wallet_request_refunded = new WalletRequest();
					    	 	$wallet_request_refunded->amount = $wallet_request->amount;
					    	 	$wallet_request_refunded->status = 'processed';
					    	 	$wallet_request_refunded->user_id = $wallet_request->user_id; 
					    	 	$wallet_request_refunded->type = 'refunded';
					    	 	$wallet_request_refunded->details = ['refunded' => [
					    	 		'transactionId' =>  $responseRefund['transactionID:'],
					    	 		'parent_wallet_request_id' => $wallet_request->id,
					    	 		'process_via' => 'authorize_net'
					    	 	]];

					    	$transaction = WalletRequest::where('user_id', Auth::user()->id)
							->where('status', 'processed')
							->orderBy('created_at', 'desc')
							->take('1')
							->with(['transaction' => function ($query) {
									$query->orderBy('created_at', 'desc')->take('1');
								}])
							->first(); 
							$transaction_obj = new WalletTransaction();
							if ($transaction) {
								$transaction_obj->opening_balance = $transaction->transaction->closing_balance;
								$balance = $transaction_obj->opening_balance - $wallet_request->amount;
								$transaction_obj->closing_balance = $balance;
							}
							else{

									$transaction_obj->opening_balance = 0;
									$transaction_obj->closing_balance = 0;
							}
							

							DB::transaction(function () use($wallet_request_refunded,$transaction_obj,$wallet_request){

									$wallet_request_refunded->save();
									$wallet_request->update(['details->child_request_id' => $wallet_request_refunded->id]);
									$transaction_obj->request_id = $wallet_request_refunded->id;
									$transaction_obj->save();						
								}); 
					    	 	$msg['status'] = 1;
					    	 	$msg['Msg'] = 'Transaction Refund successfully...';
					    	 	return json_encode($msg);
					    	 	exit;
					    	}
					    	elseif($responseRefund['errorCode'] == 55){
					    	 	$msg['status'] = 0;
					    	 	$msg['Msg'] = $responseRefund['errorMessage'];
					    	 	return json_encode($msg);
					    	 	exit;
					    	}

							}else{
							$msg['status'] = 0;
					    	$msg['Msg'] = 'Transaction cannot setteled please wait 2 days...';
					    	return json_encode($msg);
					    	exit;
							}		
					}else{
							$msg['status'] = 0;
					    	$msg['Msg'] = 'Transaction Cannot process sucessfully please contact site admin...';
					    	return json_encode($msg);
					    	exit;
						}
					}
				}else{
						$msg['status'] = 0;
						$msg['Msg'] = 'Refund Amount is greater then wallet balance...';
						return json_encode($msg);
						exit;
					} 
		}
	}
	
	public function refundTransactionOriginal($wallet_request) {
		
		$refTransId = $wallet_request->details->deposit->transactionID;
		$amount = $wallet_request->amount;

	    /* Create a merchantAuthenticationType object with authentication details
	       retrieved from the constants file */
	    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
	   
		
		$merchantAuthentication->setName(Config::get('services.authorize_net.key'));  // Test
		$merchantAuthentication->setTransactionKey(Config::get('services.authorize_net.secret'));  // Test
	    
	    // Set the transaction's refId
	    $refId = 'ref' . time();
	    $exp=filter_var ( trim(2030)."-".trim(11), FILTER_SANITIZE_STRING);
	    // Create the payment data for a credit card
	    $creditCard = new AnetAPI\CreditCardType();
	    $creditCard->setCardNumber($wallet_request->details->deposit->credit_card_last_digit);
	    $creditCard->setExpirationDate($exp);
	    $paymentOne = new AnetAPI\PaymentType();
	    $paymentOne->setCreditCard($creditCard);
	    //create a transaction
	    $transactionRequest = new AnetAPI\TransactionRequestType();
	    $transactionRequest->setTransactionType( "refundTransaction"); 
	    $transactionRequest->setAmount($amount);
	    $transactionRequest->setPayment($paymentOne);
	    $transactionRequest->setRefTransId($refTransId);
	 

	    $request = new AnetAPI\CreateTransactionRequest();
	    $request->setMerchantAuthentication($merchantAuthentication);
	    $request->setRefId($refId);
	    $request->setTransactionRequest( $transactionRequest);
	    $controller = new AnetController\CreateTransactionController($request);
	    $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
	   $responseData = [];
        if ($response != null) {
	        if ($response->getMessages()->getResultCode() == "Ok") {
	            $tresponse = $response->getTransactionResponse();
	            if ($tresponse != null && $tresponse->getMessages() != null) {
	                $responseData['success'] = 1;
					$responseData['transactionID:'] = $tresponse->getTransId();

	            } else {
	                if ($tresponse->getErrors() != null) {
	                	$responseData['success'] 		= 0;
	                	$responseData['errorCode'] 		= $tresponse->getErrors()[0]->getErrorCode();
	                	$responseData['errorMessage'] 	= $tresponse->getErrors()[0]->getErrorText();
	                }
	            }
	        } else {
	            $tresponse = $response->getTransactionResponse();
	            if ($tresponse != null && $tresponse->getErrors() != null) {
                	$responseData['success'] 		= 0;
                	$responseData['errorCode'] 		= $tresponse->getErrors()[0]->getErrorCode();
                	$responseData['errorMessage'] 	= $tresponse->getErrors()[0]->getErrorText();
	            } else {
	                $responseData['success'] 		= 0;
                	$responseData['errorCode'] 		= $response->getMessages()->getMessage()[0]->getCode();
                	$responseData['errorMessage'] 	= $response->getMessages()->getMessage()[0]->getText();
	            }
	        }
	    } else {
    		$responseData['success'] 		= 0;
        	$responseData['errorCode'] 		= "No response returned";
        	$responseData['errorMessage'] 	= "No response returned";
	    } 
		return $responseData ;
	    //return $response;
	}


	 public function getTransactionDetails($transactionId) {
		/* Create a merchantAuthenticationType object with authentication details
		   retrieved from the constants file */
		$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
		
		
		$merchantAuthentication->setName(Config::get('services.authorize_net.key'));  // Test
		$merchantAuthentication->setTransactionKey(Config::get('services.authorize_net.secret'));  // Test
	    
	    // Set the transaction's refId
	    $refId = 'ref' . time();
	    $exp=filter_var ( trim(2030)."-".trim(11), FILTER_SANITIZE_STRING);

		$request = new AnetAPI\GetTransactionDetailsRequest();
		$request->setMerchantAuthentication($merchantAuthentication);
		$request->setTransId($transactionId);

		$controller = new AnetController\GetTransactionDetailsController($request);

		$response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
		return $response;
	}

}

<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
use App\WalletRequest;
use App\WalletTransaction;
use Auth;
use DB;
use App\Rules\TotalWithdraw;

class PaypalController extends Controller
{
	private $api_context;

	public function __construct()
    {
    	Config::set('services.paypal.client_id',Helper::dbConfigValue('paypal','client_id'));
		Config::set('services.paypal.secret',Helper::dbConfigValue('paypal','client_secret'));

        $this->api_context = new ApiContext(
            new OAuthTokenCredential(config('services.paypal.client_id'), config('services.paypal.secret'))
        );
        $this->api_context->setConfig(config('services.paypal.settings'));
    }

    public function createShopaholicDepositPayment(){
    	$this->validate(request(), [
		'amount'	=> ['required','numeric',new TotalWithdraw],
		]);
        $pay_amount = request()->amount;
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
			->setDescription("Deposit money in Shopaholic Wallet")
			->setInvoiceNumber(uniqid());
		//$baseUrl = getBaseUrl();
		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl(route('paypal.confirm_deposit'))
        ->setCancelUrl(route('paypal.confirm_deposit'));
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
	     	request()->session()->put('amount', $pay_amount);
            return redirect($approvalUrl);
        }else {			
        	return redirect()->route('wallet.index')->with( ['status' => 0,'paypal_res' => 1,'message' => 'Something went wrong...']);
        }
	}

    public function confirmShopaholicDepositPayment(Request $request)
    {
        if (empty($request->query('paymentId')) || empty($request->query('PayerID')) || empty($request->query('token')))
        {
        	return redirect()->route('wallet.index')->with( ['status' => 0,'paypal_res' => 1,'message' => 'Payment was not successfully Something went wrong...']);
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
		    if ($result->getState() != 'approved')
		    {
		    	return redirect()->route('wallet.index')->with( ['status' => 0,'paypal_res' => 1,'message' => 'Payment was not successfully Something went wrong...']);
		    }
		    $amount = request()->session()->get('amount');
		    request()->session()->forget('amount');
		    $wallet_request = new WalletRequest();
			$wallet_request->type = 'deposit';
			$wallet_request->status = 'processed';
			$wallet_request->details = ['deposit' => ['payerID' => $request->query('PayerID'),'process_via' => 'paypal','paymentID' => $request->query('paymentId')],'child_request_id' => "0",];
			$after_paypal_amount = ($amount/100)*4.4;
			$after_paypal_fee = $amount-$after_paypal_amount;
			$wallet_request->amount = $after_paypal_fee;
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
				$balance = $transaction_obj->opening_balance + $after_paypal_fee;
				$transaction_obj->closing_balance = $balance;
				
			}
			else{

					$transaction_obj->opening_balance = 0;
					$transaction_obj->closing_balance = $after_paypal_fee;
					
				}
			

			DB::transaction(function () use($wallet_request,$transaction_obj){

					$wallet_request->save();
					$transaction_obj->request_id = $wallet_request->id;
					$transaction_obj->save();						
				}); 
			return redirect()->route('wallet.index')->with( ['status' => 1,'paypal_res' => 1,'message' => 'Transaction successfully processed...']);
    }

    public function refundShopaholicDepositPayment()
    {

    	$request_id = request()->id;
    	$wallet_request = WalletRequest::where('id',$request_id)->first();
		$walletBalance = WalletRequest::walletBalance(Auth::user()->id);

		if ($walletBalance && $walletBalance->transaction) {
			$balance = $walletBalance->transaction->closing_balance;
				if($balance > $wallet_request->amount || $balance == $wallet_request->amount)
				{
					$payments = Payment::get($wallet_request->details->deposit->paymentID, $this->api_context); 
				    $payments->getTransactions();
				    $obj = $payments->toJSON();
				    $paypal_obj = json_decode($obj);
				    $sale_id = $paypal_obj->transactions[0]->related_resources[0]->sale->id;
					$amount = new Amount();
					$amount->setCurrency('USD')
			    		->setTotal($wallet_request->amount);
			    	$refundRequest = new RefundRequest();
					$refundRequest->setAmount($amount);
					$sale = new Sale();

					$sale->setId($sale_id);
					try { 
						//dd($refundRequest);
						$refundedSale = $sale->refundSale($refundRequest, $this->api_context);

						} catch (PayPalConnectionException $ex) {
							 dd("Refund Sale", "Sale", null, $refundRequest, $ex);
			    			//dd(1);
			    			exit;
			    		}
			    		
			    		$responseRefund = json_decode($refundedSale);
			    		if($responseRefund)
			    		{

			    		$wallet_request_refunded = new WalletRequest();
			    	 	$wallet_request_refunded->amount = $wallet_request->amount;
			    	 	$wallet_request_refunded->status = 'processed';
			    	 	$wallet_request_refunded->user_id = $wallet_request->user_id; 
			    	 	$wallet_request_refunded->type = 'refunded';
			    	 	$wallet_request_refunded->details = ['refunded' => [
			    	 		'transactionId' =>  $responseRefund->id,
			    	 		'parent_wallet_request_id' => $wallet_request->id,'process_via' => 'paypal',
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
			    	 }else{
			    	 	$msg['status'] = 0;
						$msg['Msg'] = 'Something Went Wrong...';
						return json_encode($msg);
						exit;
			    	 }

				}else{
						$msg['status'] = 0;
						$msg['Msg'] = 'Refund Amount is greater then wallet balance...';
						return json_encode($msg);
						exit;
					}
				}
    	
    }



}

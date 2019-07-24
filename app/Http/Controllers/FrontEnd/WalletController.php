<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Rules\TotalWithdraw;
use App\User;
use App\WalletRequest;
use Auth;
use Helper;
use DataTables;
use Config;
use Illuminate\Http\Request;

class WalletController extends Controller {
	public function index() {

		Config::set('captcha.sitekey', Helper::dbConfigValue('recaptcha','api_key'));
		Config::set('captcha.secret', Helper::dbConfigValue('recaptcha','api_secret'));
		$walletBalance = WalletRequest::walletBalance(Auth::user()->id);

		$deposits = WalletRequest::where('user_id',Auth::user()->id)->where('status','processed')->where('type','deposit')->sum('amount');
		$refunds = WalletRequest::where('user_id',Auth::user()->id)->where('status','processed')->where('type','refunded')->sum('amount');
		$withdrawals = WalletRequest::where('user_id',Auth::user()->id)->where('status','processed')->where('type','withdrawal')->sum('amount');
		

		if ($walletBalance && $walletBalance->transaction) {
			$balance = $walletBalance->transaction->closing_balance;
		} else {
			$balance = '0.00';
		}

		$wallet_requests = User::where('id', Auth::user()->id)->with(['walletRequests' => function ($query) {
			$query->where('user_id', Auth::user()->id)->where('status', 'processed')->orWhere('status', 'offline_payment');
		}, 'walletRequests.transaction'])->get();
		

		return view('frontend.dashboard.wallet.wallet', compact('balance', 'wallet_requests','refunds','withdrawals','deposits'));
	}

	/************  Fetch the all transaction record   ****************/
	public function getTransactionRecord() {
		$transactions_records = WalletRequest::where('status','processed')->Where('user_id',Auth::user()->id)->with('transaction')->orderBy('created_at','desc');
		
		return DataTables::of($transactions_records)
		
			->editColumn('created_at',function($transaction_rec){
				return Helper::formatDate($transaction_rec->created_at);
			})
			->addColumn('ref_code',function($transaction_rec){
				return @$transaction_rec->details->ref_code;
			})
			->addColumn('opening_balance',function($transaction_rec){
				return Helper::manipulateAmount($transaction_rec->transaction->opening_balance);
			})

			->editColumn('amount', function ($transaction_rec) {
				if($transaction_rec->type == 'withdrawal')
				{
					return '<span class="label label-danger">'.Helper::manipulateAmount($transaction_rec->amount).'</span>';
				}
				if($transaction_rec->type == 'deposit')
				{
					return '<span class="label label-success"><b>+</b>'.Helper::manipulateAmount($transaction_rec->amount).'</span>';
				}
				if($transaction_rec->type == 'refunded')
				{
					return '<span class="label label-warning"><b>-</b>'.Helper::manipulateAmount($transaction_rec->amount).'</span>';
						
					
				}
			})
			->addColumn('type',function($transaction_rec){
				return $transaction_rec->type;
			}) 
				 
			->addColumn('closing_balance',function($transaction_rec){
				return '<span>'.Helper::manipulateAmount($transaction_rec->transaction->closing_balance).'</span>';
			}) 
			->rawColumns(['closing_balance','created_at' ,'opening_balance','ref_code','amount'])->make(true);
	}






	public function depositMoney() {
		$validatedData = request()->validate([
			'transaction_id' => 'required',
			'transaction_amount' => 'required|numeric',
		]);
		
		//$ref_code = json_encode($value_tojson);
		$wallet_request = new WalletRequest();
		$wallet_request->type = 'deposit';
		$wallet_request->status = 'pending';
		$wallet_request->details = ['deposit' => ['ref_code' => request()->transaction_id,'process_via' => 'bank_transfer']];
		$wallet_request->amount = request()->transaction_amount;
		$wallet_request->user_id = Auth::user()->id;
		$request_saved = $wallet_request->save();
		if ($request_saved) {
			$msg['status'] = 1;
			$msg['msg'] = "Information has been saved successfully ...";
			return json_encode($msg);
		} else {
			$msg['status'] = 0;
			$msg['msg'] = "Some thing went wrong...";
			return json_encode($msg);
		}
	}

	public function withdrawMoney() {

		$validatedData = request()->validate([
			'first_name' => 'required',
			'last_name' => 'required',
			'bank_name' => 'required',
			'bank_transit_name' => 'required',
			'bank_account_no' => 'required|confirmed',
			'bank_address' => 'required',
			'total_withdraw' => ['required', 'numeric', new TotalWithdraw],
			'remarks' => 'required',
			'verification' => 'required',
		]);

		$details = [
		'withdrawal' => [
			'first_name' => request()->first_name,
			'last_name' => request()->last_name,
			'bank_name' => request()->bank_name,
			'bank_transit_name' => request()->bank_transit_name,
			'bank_account_no' => request()->bank_account_no,
			'bank_address' => request()->bank_address,
			'remarks' => request()->remarks,
		]
		];
		//$details = json_encode($value_tojson);
		$wallet_request = new WalletRequest();
		$wallet_request->type = 'withdrawal';
		$wallet_request->status = 'pending';
		$wallet_request->details = $details;
		$wallet_request->amount = request()->total_withdraw;
		$wallet_request->user_id = Auth::user()->id;
		$request_saved = $wallet_request->save();
		if ($request_saved) {
			$msg['status'] = 1;
			$msg['msg'] = "Information has been saved successfully ...";
			return json_encode($msg);
		} else {
			$msg['status'] = 0;
			$msg['msg'] = "Some thing went wrong...";
			return json_encode($msg);
		}
	}
	public function walletTransaction(){
		$transaction = WalletRequest::where('status','processed')->Where('user_id',Auth::user()->id)->with('transaction')->orderBy('created_at','desc')->get();
		if($transaction){
			return $transaction;
		}
	}



















}


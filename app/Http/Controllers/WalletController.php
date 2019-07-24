<?php

namespace App\Http\Controllers;

use App\User;
use App\WalletRequest;
use App\WalletTransaction;
use Auth;
use DB;
use DataTables;
use Illuminate\Http\Request;
use JavaScript;
use Helper;


class WalletController extends Controller {

	function __construct()
    {
    	JavaScript::put([
			'del_url' => route('wallet_request.process'),
		]);

    }

	public function depositRequest() {
		
		return view('wallet-requests.deposit-request');
	}

	/*public function getdepositRequest() {
				$deposits = WalletRequest::where('type', 'deposit')->with(['user', 'transaction'])->get();

				// dd($deposits);
				return DataTables::of($deposits)

		    	return view('wallet-requests.deposit-request');
	*/

	public function getdepositRequest() {
		$deposits = WalletRequest::where('type', 'deposit')->with(['user', 'transaction'])->orderBy('created_at','desc');

		//dd($deposits);
		return DataTables::of($deposits)

			->addColumn('name', function ($deposit) {
				return '<a href="javascript:;">' . $deposit->user->first_name . ' ' . $deposit->user->last_name . '<br/>  (<b>' . strtoupper($deposit->user->shopaholic->sn) . '</b>)</a>';
			})

			->filterColumn('name', function($query, $keyword) {
                $query->whereHas('user',function($qry) use($keyword)
                    {
                      $qry->where("first_name",'like','%'.$keyword.'%')
                          ->orWhere("last_name",'like','%'.$keyword.'%')
                          ->orWhere("email",'like','%'.$keyword.'%');
                    })
                ->orWhereHas('user.shopaholic',function($qry) use($keyword)
                    {
                      $qry->where("sn",'like','%'.$keyword.'%');
                    });         
                    
            })
			->addColumn('details', function ($deposit) {
				
				return @$deposit->details->deposit->ref_code;
			})
			->addColumn('amount', function ($deposit) {
				return Helper::manipulateAmount($deposit->amount);
			})
			->addColumn('wallet_balance', function ($deposit) use ($deposits) {

				$wallet_balance = WalletRequest::walletBalance($deposit->user_id);
				if ($wallet_balance) {

					return Helper::manipulateAmount($wallet_balance->transaction->closing_balance);

				} else {
					return Helper::manipulateAmount(0);
				}

			})
			->addColumn('status', function ($deposit) {
				if ($deposit->status == 'pending') {
					return '<label class="label label-primary">Pending</label>';
				}
				if ($deposit->status == 'processed') {
					return '<label class="label label-success">Processed</label>';
				}
				if ($deposit->status == 'rejected') {
					return '<label class="label label-danger">Rejected</label>';
				}

			})
			->addColumn('action', function ($deposit) {
				return view('wallet-requests.action-buttons', ['result' => $deposit, 'modal_id' => 'edit_warehouse_model'])->render();
			})
			->rawColumns(['name', 'action', 'details', 'amount', 'wallet_balance', 'status'])
			->make(true);

	}

	public function processRequest(Request $request) {
		$id = $request->id;
		if (!empty($id)) {
			$wallet_request = WalletRequest::where('id', $id)->first();
			$is_saved = false;
			if (request()->type == 'process') {
				$admin_remarks = ['admin_remarks' => request()->remarks];
				$wallet_request->remarks 		= $admin_remarks;
				$wallet_request->status  		= "processed";
				$wallet_request->processed_by 	= Auth::user()->id;
				$transaction 					= WalletRequest::where('user_id', $wallet_request->user_id)
				->where('status', 'processed')
				/*->where('type', 'deposit')
				->orWhere('type', 'offline_payment')
				->orWhere('type', 'withdrawal')*/
				->orderBy('created_at', 'desc')
				->take('1')
				->with(['transaction' => function ($query) {
						$query->orderBy('created_at', 'desc')->take('1');
					}])
				->first();

				$transaction_obj = new WalletTransaction();
				/***** means already there are transactions done before ***/
				if ($transaction) {
					if($wallet_request->type == "deposit")
						{
							$transaction_obj->opening_balance 	= $transaction->transaction->closing_balance;
							$balance 							= $transaction_obj->opening_balance + $wallet_request->amount;
							$transaction_obj->closing_balance 	= $balance;
							$transaction_obj->request_id 		= $wallet_request->id;
						}
						if($wallet_request->type == "withdrawal")
						{
							$transaction_obj->opening_balance 	= $transaction->transaction->closing_balance;
							$balance 							= $transaction_obj->opening_balance - $wallet_request->amount;
							$transaction_obj->closing_balance 	= $balance;
							$transaction_obj->request_id 		= $wallet_request->id;
						}
					} else {
						$transaction_obj->opening_balance = 0;
						$transaction_obj->closing_balance = $wallet_request->amount;
						$transaction_obj->request_id = $id;
					}
					 DB::transaction(function () use($wallet_request,$transaction_obj){
						$wallet_request->save();
						$transaction_obj->save();
					});
					$msg['status'] = 1;
					$msg['body'] = 'User request is processed Successfully.';
			}
			if (request()->type == 'reject') {
				$admin_remarks 					= ['admin_remarks' => request()->remarks];
				$wallet_request->remarks 		= $admin_remarks;
				$wallet_request->status 		= "rejected";
				$wallet_request->processed_by 	= Auth::user()->id;
				$is_saved 						= $wallet_request->save();
				$msg['status'] = 1;
				$msg['body']   = 'User request is rejected.';
			}
			return json_encode($msg);
		}
	}

	public function withDrawRequest() {
		JavaScript::put([
			'del_url' => route('wallet_request.process'),
		]);

		return view('wallet-requests.withdraw-request');
	}

	public function getwithdrawRequest() {


		$withdraws = WalletRequest::where('type', 'withdrawal')->with(['user', 'transaction']); 
		// dd($deposits);
		return DataTables::of($withdraws)
			->addColumn('name', function ($withdraw) {
				return '<a href="javascript:void(0);">' . $withdraw->user->first_name . ' ' . $withdraw->user->last_name . '<br/> (<b>' . strtoupper($withdraw->user->shopaholic->sn) . '</b>)</a>';
			})


			->filterColumn('name', function($query, $keyword) {
                $query->whereHas('user',function($qry) use($keyword)
                    {
                      $qry->where("first_name",'like','%'.$keyword.'%')
                          ->orWhere("last_name",'like','%'.$keyword.'%')
                          ->orWhere("email",'like','%'.$keyword.'%');
                    })
                ->orWhereHas('user.shopaholic',function($qry) use($keyword)
                    {
                      $qry->where("sn",'like','%'.$keyword.'%');
                    });         
                    
            })
			->addColumn('details', function ($withdraw) {
				

				return $withdraw->details->withdrawal->bank_name;
			})
			->addColumn('account_no', function ($withdraw) {
				
				return $withdraw->details->withdrawal->bank_account_no;
			})
			->addColumn('amount', function ($withdraw) {
				return Helper::manipulateAmount($withdraw->amount);
			})
			->addColumn('wallet_balance', function ($withdraw) use ($withdraws) {
				$wallet_balance = WalletRequest::walletBalance($withdraw->user_id);
				if ($wallet_balance) {
					return Helper::manipulateAmount($wallet_balance->transaction->closing_balance);
				} else {
					return Helper::manipulateAmount(0);
				}
			})
			->addColumn('status', function ($withdraw) {
				if ($withdraw->status == 'pending') {
					return '<label class="label label-primary">Pending</label>';
				}
				if ($withdraw->status == 'processed') {
					return '<label class="label label-success">Processed</label>';
				}
				if ($withdraw->status == 'rejected') {
					return '<label class="label label-danger">Rejected</label>';
				}

			})
			->addColumn('action', function ($withdraw) {
				$wallet_balance_rec = WalletRequest::walletBalance($withdraw->user_id);

				$wallet_balance = '0.00';
				if ($wallet_balance_rec) 
					$wallet_balance = $wallet_balance_rec->transaction->closing_balance;
				

				$wallet_info = json_encode(['wallet_balance' => $wallet_balance,
											'amount' => $withdraw->amount,
											'details' => $withdraw->details]);

				return view('wallet-requests.withdraw-action-buttons', ['result' => $withdraw, 'modal_id' => 'detailwithdraw', 'details' => $wallet_info])->render();
			})
			->rawColumns(['name', 'action', 'details', 'amount', 'wallet_balance', 'status'])
			->make(true);
	}


	public function getShopaholicWalletDetail(){
		$user_id = request()->id;
		$walletBalance = WalletRequest::walletBalance($user_id);

		if ($walletBalance && $walletBalance->transaction) {
			$balance['balance'] = $walletBalance->transaction->closing_balance;
		} else {
			$balance['balance'] = '0.00';
		}
		return json_encode($balance);
	}

	public function updateShopaholicWallet(){
		$validatedData 			= 	request()->validate([
			//'c_wallet_amount' 	=> 'required',
			'wallet_amount'	 	=> 'required',
			'remarks'	 		=> 'required',
		]);
		$u_id = request()->u_id;
		if (!empty($u_id)) {
			$wallet_request_obj = new WalletRequest;
			$wallet_request_obj->amount 	= request()->wallet_amount;
			$wallet_request_obj->status 	= 'pending';
			$wallet_request_obj->type 		= 'deposit';
			$wallet_request_obj->details 	= ['deposit' => ['process_via' => 'admin']];
			$wallet_request_obj->user_id 	= $u_id;
			$is_wallet_requet 				= $wallet_request_obj->save();
			$id = $wallet_request_obj->id;
			if($is_wallet_requet){
	  				$wallet_request = WalletRequest::where('id', $id)->first();
					$admin_remarks 	= ['admin_remarks' => request()->remarks];
					$wallet_request->remarks 		= $admin_remarks;
					$wallet_request->status 		= "processed";
					$wallet_request->processed_by	= Auth::user()->id;
					$transaction = WalletRequest::where('user_id', $wallet_request->user_id)
					->where('status', 'processed')
					->orderBy('created_at', 'desc')
					->take('1')
					->with(['transaction' => function ($query) {
							$query->orderBy('created_at', 'desc')->take('1');
						}])
					->first();
					$transaction_obj = new WalletTransaction(); 
					if ($transaction) {
						$transaction_obj->opening_balance 	= $transaction->transaction->closing_balance;
						$balance 							= $transaction_obj->opening_balance + $wallet_request->amount;
						$transaction_obj->closing_balance	= $balance;
						$transaction_obj->request_id		= $wallet_request->id;
						} else {
							$transaction_obj->opening_balance = 0;
							$transaction_obj->closing_balance = $wallet_request->amount;
							$transaction_obj->request_id 	  = $id;
						}
						 DB::transaction(function () use($wallet_request,$transaction_obj){
							$wallet_request->save();
							$transaction_obj->save();
						});
						 $msg['message'] = 'Wallet updated successfully...';
						 $msg['status']  = 1;
						 return json_encode($msg);	
				}
		}

			$msg['message'] = 'Some thing Went Wrong...';
			$msg['status']  = 0;
			return json_encode($msg);
	}

}

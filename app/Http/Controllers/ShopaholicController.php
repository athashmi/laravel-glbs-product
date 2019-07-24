<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shopaholic;
use DataTables;
use App\WalletRequest;
use App\User;
use App\Country;
use App\ShopaholicAddress;
use App\ShopaholicFailedTransaction;
use DB;
use Helper;
use Response;
use Intervention\Image\ImageManager;

class ShopaholicController extends Controller
{
    public function index() {
        return view('shopaholics.index');
    }

    public function getshopaholics(Request $request){


        $shopaholics = Shopaholic::with(['user'=>function($qry){
            $qry->select('id','first_name','last_name','email','created_at');
        },'user.walletBalance'])
       /* ->whereHas('user',function($qry){
            $qry->where('email','executive001@yahoo.com');
            })*/
        ->select('shopaholics.id AS shp_id', 'sn','user_id','type')
        //->where('user_id',27653)
        //->get()
         ;
        // /->orderBy('created_at','desc');
    //dd($shopaholics->get());
         

          

        return DataTables::of($shopaholics)
            ->editColumn('shopaholics.type', function ($shopaholic) {
                if($shopaholic->type == 'ordinary')
                {
                    return '<label class="label label-primary">Ordinary</label>';
                }
                if($shopaholic->type == 'corporate')
                {
                    return '<label class="label label-danger">Corporate</label>';
                }
            })
            ->addColumn('name', function($shopaholic) {
                return $shopaholic->user->first_name.' '. $shopaholic->user->last_name;
            })
            ->filterColumn('name', function($query, $keyword) {
                $query->whereHas('user',function($qry) use($keyword)
                    {
                      $qry->where("first_name",'like','%'.$keyword.'%')
                          ->orWhere("last_name",'like','%'.$keyword.'%')
                          ->orWhere("email",'like','%'.$keyword.'%');
                    });
                })
            ->editColumn('user.email',function($shopaholic){
                return $shopaholic->user->email;
            })
            ->addColumn('balance', function ($shopaholic) {

                if($shopaholic->user->walletBalance)
                {
                    return Helper::manipulateAmount($shopaholic->user->walletBalance->transaction->closing_balance);
                }
                else {
                    return Helper::manipulateAmount(0);
                }
               /* $wallet_balance = WalletRequest::walletBalance($shopaholic->user_id);

                $wallet_balance = WalletRequest::walletBalance($shopaholic->user_id);

                if ($wallet_balance) {
                    return Helper::manipulateAmount($wallet_balance->transaction->closing_balance);
                } else {
                    return Helper::manipulateAmount(0);

                }*/


           

            })
            ->editColumn('sn',function($shopaholic){
                return '<b>'.strtoupper($shopaholic->sn).'</b>';
            })
            ->editColumn('user.created_at',function($shopaholic){
                return date('F jS Y', strtotime($shopaholic->user->created_at));
            })          
            ->addColumn('action', function ($shopaholic) {
                return view('shopaholics.action-button', ['result' => $shopaholic,'modal_id' => 'update_wallet_modal'])->render();
            })
            ->setRowId(function ($shopaholic) {
                        return $shopaholic->shp_id;
                    })
            ->rawColumns(['name','shopaholics.type' ,'email','created_at','action','sn','balance'])
            ->make(true);
    }


    public function getCustomFilterData(Request $request){
        $users = DB::table('users')->select(['id', 'first_name', 'email', 'created_at', 'updated_at']);
        return Datatables::of($users)
            ->filter(function ($query) use ($request) {
                if ($request->has('id')) {
                    $id = explode('-',$request->id);
                    $query->where('id',$id[1]);
                }
            })
            ->make(true);
    }

    public function getShopaholicDetails($id){

        $user = User::where('id',Auth::user()->id)->with(['shopaholic.addresses.country','country'])->first();




        $countries = Country::all();
        return view('shopaholics.profile.details',compact('user','countries'));
    }

    public function shopaholicProfile($shopaholic_id) {

//        $tt =  DB::connection('mysql_old_data')->table('wallet')
//                             ->where('user_id',11149)
//                             ->first();
// dd($tt);

        $shopaholic = Shopaholic::where('id',$shopaholic_id)->with('user','addresses','primaryAddress')->first();
        $walletBalance = WalletRequest::walletBalance($shopaholic->user->id);
        

        $deposits = WalletRequest::where('user_id',$shopaholic->user_id)->where('status','processed')->where('type','deposit')->sum('amount');
        $refunds = WalletRequest::where('user_id',$shopaholic->user_id)->where('status','processed')->where('type','refunded')->sum('amount');
        $withdrawals = WalletRequest::where('user_id',$shopaholic->user_id)->where('status','processed')->where('type','withdrawal')->sum('amount');




        $countries = Country::all();
        if ($walletBalance && $walletBalance->transaction) {
            $balance = $walletBalance->transaction->closing_balance;
        } else {
            $balance = '0.00';
        }
        if($shopaholic) {
            return view('shopaholics.user-profile.profile',compact('shopaholic','transactions_rec','balance','countries','refunds','withdrawals','deposits'));
        }
        else {
        }
    }
  
    public function shopaholicAjaxAddress(){
        $q = request()->text;
        $shopaholic_id = request()->shopaholic_id;
    

        if(!empty($q)){
            
             $addresses  = ShopaholicAddress::where('shopaholic_id',$shopaholic_id)
                ->where(function($query) use($q){
                    $query->orWhere('name','like',"%$q%")
                    ->orWhere('phone','like',"%$q%")
                    ->orWhere('street','like',"%$q%")
                    ->orWhere('city','like',"%$q%")
                    ->orWhere('state','like',"%$q%")
                    ->orWhere('zip_code','like',"%$q%")
                    ->orWhereHas('country', function($query) use ($q) {
                        return $query->where('name', 'LIKE', '%' . $q . '%');
                     });
                })
                    ->with('country')
                    ->paginate(9);         
        }
        else
        {
            //dd('lll');
            $addresses = ShopaholicAddress::where('shopaholic_id',$shopaholic_id)->with('country')->paginate(9);
        }
        $results = $addresses;

        //dd($results);
        
        $msg['status'] = 1;
        
        $msg['no_of_page'] = request()->page;
        $msg['data'] = $results;
        return json_encode($msg);
    }    

    public function editShopaholicPrimaryInfo(){
        $id = request()->id;
        $shopaholic = Shopaholic::where('id',$id)->with('user.country','primaryAddress')->first();
        if($shopaholic){
            $msg['status'] = 1;
            $msg['data']   = $shopaholic;
            $msg['date_for'] = date('m/d/Y', strtotime($shopaholic->user->dob));
            return json_encode($msg);
        }
    }
    public function editShopaholicAddres(){
        $id = request()->id;
        $shopaholic = ShopaholicAddress::where('id',$id)->first();
        if($shopaholic){
            $msg['status'] = 1;
            $msg['data']   = $shopaholic;
            return json_encode($msg);
        }
    }
    public function updateShopaholicProfileAddress(){
        $id = request()->id;
        $shopaholicAddress = ShopaholicAddress::find($id);
        $is_updated = $shopaholicAddress->update(request()->all());
        if($is_updated){
            $msg['status'] = 1;
            return json_encode($msg);
        }else{
            $msg['status'] = 0;
            return json_encode($msg);
        }
    }
    public function updateShopaholicPrimaryInfo(){

        $validatedData = request()->validate([          
            'address.*' => 'required',
            'country' => 'required', // coutry name means coutry id
        ]);
       // dd(request()->all());
        $id = request()->shopaholic_id;
        if(!empty($id)){
            $shopaholic = Shopaholic::find($id);
            $shopaholic->user->dob = date('Y-m-d', strtotime(request()->dob));
           $shopaholic->user->gender = request()->gender;
            $shopaholic->user->country_id = request()->country;

            
            if (request()->hasFile('files')) {
                $file = request()->file("files");
                $file_unique_name = request()->first_name . '-' . time() . '-' . date("Ymdhis") . rand(0, 999) . '.' . $file->guessExtension();
                $file_unique_name_resized = time() . '-' . date("Ymdhis") . rand(0, 999) . '.' . $file->guessExtension();
                $file->storeAs(config('constants.img_folder'), $file_unique_name);
                $ImageManager = new ImageManager();
                $ImageManager->make( \Storage::get(config('constants.img_folder') . '/' . $file_unique_name))->resize(268, 247)->save(storage_path('app/'.config('constants.img_folder').'/' . $file_unique_name_resized));
                $shopaholic->user->picture = $file_unique_name_resized;
            }
            $shopaholic->update();
            $is_updated = $shopaholic->user->update();

            $shopaholic->update();

            if(request()->address_id !='')
                $address =  ShopaholicAddress::find(request()->address_id);
            else
            {
                $address = new ShopaholicAddress;
                $address->type = 'primary';
            }

            //if(request()->address_id !=''):

            $address =  ShopaholicAddress::find(request()->address_id);
            $address->street = request()->address['street'];
            $address->city = request()->address['city'];
            $address->zip_code = request()->address['zip_code'];
            $address->country_id = request()->country;
            $address->state = request()->address['state'];
            $address->street = request()->address['street'];
            $address->save();
           

            if($is_updated){
                $msg['status'] = 1;
                return json_encode($msg);
            }else{
                $msg['status'] = 0;
                return json_encode($msg);
            }
        }
    }

    public function ajaxGetShopaholicTransactions($user_id){

        $transactions_records = WalletRequest::where('status','processed')->Where('user_id',$user_id)->with(['transaction','processedBy']);
        
       //dd($transactions_records);

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
            ->editColumn('processed_by',function($transaction_rec){
                if($transaction_rec->processedBy)
                {

                    return $transaction_rec->processedBy->first_name.' '.$transaction_rec->processedBy->last_name;
                }
                else
                    {
                       // dd($transaction_rec->details);
                        
                        return $transaction_rec->details->{$transaction_rec->type}->process_via;
                    }


            })
                 
            ->addColumn('closing_balance',function($transaction_rec){
                return '<span>'.Helper::manipulateAmount($transaction_rec->transaction->closing_balance).'</span>';
            }) 
            ->rawColumns(['closing_balance','created_at' ,'opening_balance','ref_code','amount'])
            ->make(true);



        /*$transactions_rec  = WalletRequest::where('status','processed')->Where('user_id',$user_id)->with('transaction')->orderBy('created_at','desc')->paginate(Helper::paginatePerPage());
        return view('shopaholics.user-profile.partial.wallet-info', compact('transactions_rec'));*/
    }
    public function failedTransaction()
    {
        return view('failed-transactions.index');
    }
    public function getFailedTransaction(){
         $failed_transactions = ShopaholicFailedTransaction::with('shopaholic.user');
         return DataTables::of($failed_transactions)
        
            ->addColumn('name',function($failed_transaction){

                return $failed_transaction->shopaholic->user->first_name.' '.$failed_transaction->shopaholic->user->last_name.'<br/>(<b>'.strtoupper($failed_transaction->shopaholic->sn).'</b>)';
            })

             ->filterColumn('name', function($query, $keyword) {
                $query->whereHas('shopaholic.user',function($qry) use($keyword)
                    {
                      $qry->where("first_name",'like','%'.$keyword.'%')
                          ->orWhere("last_name",'like','%'.$keyword.'%')
                          ->orWhere("email",'like','%'.$keyword.'%');
                    })
                ->orWhereHas('shopaholic',function($qry) use($keyword)
                    {
                      $qry->where("sn",'like','%'.$keyword.'%');
                    });         
                    
            })

            ->editColumn('created_at',function($failed_transaction){
                return Helper::formatDate($failed_transaction->created_at);
            })
            ->rawColumns(['name'])
            ->make(true);

    }


}

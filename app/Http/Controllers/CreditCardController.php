<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Shopaholic;
use App\ShopaholicCreditInfo;
use Auth;

class CreditCardController extends Controller
{
    public function index(){
    	return view('credit-card-info.index');
    }
    public function getCreditCardinfo(){

    	$credit_card_infos 	= ShopaholicCreditInfo::with('shopaholic.user')->orderBy('shopaholic_credit_infos.created_at','desc');




		return DataTables::of($credit_card_infos)

             ->addColumn('name', function ($credit_card_info) {
               
                 return '<a href="'.route('shopaholic.shopaholic-profile',$credit_card_info->shopaholic->id).'">'.$credit_card_info->shopaholic->user->first_name.' '.$credit_card_info->shopaholic->user->last_name.' <br/>(<b>'.strtoupper($credit_card_info->shopaholic->sn).'</b>)</a>';
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

            ->addColumn('status', function ($credit_card_info) {
				 if($credit_card_info->status == 'verified'){
				 	return '<label class="label label-success">Verified</label>';
				 }
				 if($credit_card_info->status == 'unverified'){
				 	return '<label class="label label-warning">Unverified</label>';
				 }
				 if($credit_card_info->status == 'blocked'){
				 	return '<label class="label label-danger">Blocked</label>';	
				 }
			})
			->rawColumns(['status', 'action','shopaholic.user.first_name','name'])
			->addColumn('action', function ($credit_card_info) {
				return view('credit-card-info.action-buttons', ['result' => $credit_card_info, 'modal_id' => 'EditCountryModel'])->render();
			})->make(true);
    }

    public function verifyCreditCard(){
    	$id = request()->id;
    	$credit_card = ShopaholicCreditInfo::find($id);
    	$credit_card->verified_through = 'manual';
    	$credit_card->status = 'verified';
    	$credit_card->verified_by = Auth::user()->id;
    	$is_updated = $credit_card->update();
    	if($is_updated){
    		$msg['status'] = 1;
    		return json_encode($msg);
    	}else{
    		$msg['status'] = 0;
    		return json_encode($msg);
    	}
    }

    public function blockCreditCard(){
    	$id = request()->id;
    	$credit_card = ShopaholicCreditInfo::find($id);
    	$credit_card->verified_through = Null;
    	$credit_card->status = 'blocked';
    	$credit_card->verified_by = Auth::user()->id;
    	$is_updated = $credit_card->update();
    	if($is_updated){
    		$msg['status'] = 1;
    		return json_encode($msg);
    	}else{
    		$msg['status'] = 0;
    		return json_encode($msg);
    	}
    }
}

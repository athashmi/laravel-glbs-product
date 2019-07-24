<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShopaholicGroup;
use App\Country;
use App\Shopaholic;
use DataTables;

class GroupController extends Controller
{
    public function shopaholicIndex(){
    	
    	return view('groups.shopaholic.index');
    }
    public function shopaholicGetGroup(Request $request){ 
		$shopaholic_relations = ShopaholicGroup::with('postRelation.post')->where('type','shopaholic');
		return DataTables::of($shopaholic_relations)
			 
			->editColumn('type', function ($shopaholic_relation) {
				if ($shopaholic_relation->type == 'shopaholic') {
					return '<label class="label label-primary">Shopaholic Group</label>';
				}
			}) 
			->addColumn('ctry', function ($shopaholic_relation) {
				$ctry_ids = $shopaholic_relation->details->shopaholic_option->countries_ids;

				 	if($ctry_ids){
					$countries = Country::whereIn('id', $ctry_ids)
        			->get();
        			
        			$html 	= '';
        			foreach($countries as $ctry):

   					$html .='<button type="button" class="btn btn-block btn-default btn-word-wrap">
						<span class="pull-right m-l-5">
						</span>'.$ctry->nice_name.'</button>';
        			endforeach;
        			

					return $html;
				}else{
					return '';
				}
			})
			->addColumn('in_shopaholics', function ($shopaholic_relation) {
				$shopaholic_ids = $shopaholic_relation->details->ids;

				 	if($shopaholic_ids){
					$shopaholics = Shopaholic::whereIn('id', $shopaholic_ids)->with('user')
        			->get();
        			$html 	='';
        			foreach($shopaholics as $shopaholic):
   					$html .='<button type="button" class="btn btn-block btn-default btn-word-wrap">
						<span class="pull-right m-l-5">
						</span>'.$shopaholic->user->first_name.' '.$shopaholic->user->last_name.'</button>';
        			endforeach;
					return $html;
				}else{
					return 'No';
				}
				 
			})
			
			->rawColumns(['action','type','ctry','in_shopaholics'])
			->addColumn('action', function ($shopaholic_relation) {
				return view('groups.shopaholic..action-buttons', ['result' => $shopaholic_relation, 'modal_id' => 'EditCourierZoneModel','import_modal_id'=>'Importrate'])->render();
			})->make(true); 
    }
    public function shopaholicCreate(){
    	$countries = Country::all();
    	$shopaholic_types = Shopaholic::select('type')->distinct()->get(); 
    	
    	return view('groups.shopaholic.add-shopaholic-group',compact('countries','shopaholic_types'));
    }
    public function shopaholicStore(){
     
    	$type_data 			= request()->select_type_shopaholic;
    	$shopaholic_filter 	= request()->shopaholics;
    	$country  			= request()->countries;
    	$validate_data 		= [
    		'title' 		=> 'required',
			'name' 			=> 'required|unique:shopaholic_groups',
    	];
    	if(empty($type_data)){
    		$validate_data['select_type_shopaholic'] = 'required';
    	}else{
			if($type_data == 1){
				$validate_data['shopaholic'] 	= 'required';
			}
			elseif($type_data == 2){
				if(empty($shopaholic_filter)){
					$validate_data['mn'] 	= 'required';
				}
				elseif($shopaholic_filter == 'all'){
					$option_field_data['shopaholic_option']['all'] = '1';
					$option_field_data['shopaholic_option']['gender'] = '';
					$option_field_data['shopaholic_option']['age']['min'] = '0';
					$option_field_data['shopaholic_option']['age']['max'] = '0';
					$option_field_data['shopaholic_option']['type'] = '';
					$option_field_data['shopaholic_option']['countries_ids'] = '';
				}elseif($shopaholic_filter == 'filtered'){
					
						$option_field_data['shopaholic_option']['all'] = '0';
						if(empty(request()->gender_select) && empty(request()->age_select) && empty(request()->type_select) && empty(request()->countries_select)){
							$validate_data['no_select'] = 'required';
						}else{
							if(!empty(request()->gender_select)  && request()->gender_select == 'yes'){
								$validate_data['gender'] 	= 'required';
								$option_field_data['shopaholic_option']['gender'] = request()->gender;
							}else{
								$option_field_data['shopaholic_option']['gender'] = '';
							}
							if(!empty(request()->age_select)  && request()->age_select == 'yes'){
								$validate_data['min'] 	= 'required';
								$validate_data['max'] 	= 'required';
								$option_field_data['shopaholic_option']['age']['min'] = request()->min;
								$option_field_data['shopaholic_option']['age']['max'] = request()->max;
							}else{
								$option_field_data['shopaholic_option']['age']['min'] = '0';
								$option_field_data['shopaholic_option']['age']['max'] = '0';
							}
							if(!empty(request()->type_select)  && request()->type_select == 'yes'){
								$validate_data['shopaholic_type'] 	= 'required';
								$option_field_data['shopaholic_option']['type'] = request()->shopaholic_type;
							}else{
								$option_field_data['shopaholic_option']['type'] = '';
							}
							if(!empty(request()->countries_select)  && request()->countries_select == 'yes'){
								$validate_data['countries'] 	= 'required'; 
								$option_field_data['shopaholic_option']['countries_ids'] = request()->countries;
							}else{
								$option_field_data['shopaholic_option']['countries_ids'] = '';
							}
						}
				}
			}
		}
		$validatedData = request()->validate($validate_data);

		$group_shopaholic = new ShopaholicGroup;
		$group_shopaholic->title = request()->title;
		$group_shopaholic->name  = request()->name;
		$group_shopaholic->type  = 'shopaholic';
		if($type_data == 1){
			$shopaholic_ids = request()->shopaholic;
			$group_shopaholic->details = [
				'ids' => $shopaholic_ids,
				'shopaholic_option' => [
					'all' => '0',
					'age' => [
						'min' => '0',
						'max' => '0'
					],
					'gender' => '',
					'type'   => '',
					'countries_ids' => [],
				]
			];
			
		}elseif($type_data == 2){
			$option_field_data['ids'] = [];
			$group_shopaholic->details = $option_field_data;
			 
		}

		$is_saved = $group_shopaholic->save();
			if($is_saved){
				$msg['status'] = 1;
				return json_encode($msg);
				exit;
			}else{
				$msg['status'] = 0;
				return json_encode($msg);
				exit;
			}
    }
    public function shopaholicStoree(){ 
    	dd(request()->all());
    	$type_data 			= request()->select_type_shopaholic;
    	$option_filter 		= request()->option;
    	$country  			= request()->countries;
    	$validate_data 		= [
    		'title' 		=> 'required',
			'name' 			=> 'required',
    	];
    	if(empty($type_data)){
    		$validate_data['select_type_shopaholic'] = 'required';
    	}
    	
		if($type_data == 1){
			$validate_data['shopaholic'] 	= 'required';
		}elseif($type_data == 2){
			if($option_filter == 'all' && !empty($country)){
				$validate_data['er'] 		= 'required';
			}
			if(empty($option_filter) && empty($country)){
				$validate_data['option'] 	= 'required';
			}
			if($option_filter == 'age'){
				$validate_data['age_min'] = 'required';
				$validate_data['age_max'] = 'required';
			}

		}
		$validatedData = request()->validate($validate_data);
		$title = request()->title;
		$name  = request()->name;
		if($type_data == 1){
			$shopaholic_ids = request()->shopaholic;
			$group_shopaholic = new ShopaholicGroup;
			$group_shopaholic->title = $title;
			$group_shopaholic->name  = $name;
			$group_shopaholic->type  = 'shopaholic';
			$group_shopaholic->details = [
				'ids' => $shopaholic_ids,
				'shopaholic_option' => [
					'all' => '0',
					'age' => [
						'min' => '0',
						'max' => '0'
					],
					'gender' => '',
					'countries_ids' => [],
				]
			];
			$is_saved_individual_shopaholic = $group_shopaholic->save();
			if($is_saved_individual_shopaholic){
				$msg['status'] = 1;
				return json_encode($msg);
				exit;
			}else{
				$msg['status'] = 0;
				return json_encode($msg);
				exit;
			}
		}elseif($type_data == 2){
			$group_shopaholic = new ShopaholicGroup;
			$group_shopaholic->title = $title;
			$group_shopaholic->name  = $name;
			$group_shopaholic->type  = 'shopaholic'; 
			if($option_filter == 'all'){
				$option_field_data['shopaholic_option']['all'] = '1';
			}else{
				$option_field_data['shopaholic_option']['all'] = '0';
			}
			if($option_filter == 'age'){
				$option_field_data['shopaholic_option']['age']['min'] = request()->age_min;
				$option_field_data['shopaholic_option']['age']['max'] = request()->age_max;
			 }else{
			 	$option_field_data['shopaholic_option']['age']['min'] = '0';
				$option_field_data['shopaholic_option']['age']['max'] = '0';
			 }
			 $ar = explode('_', $option_filter);
			 if($ar[0] == 'gender'){
				$na = $ar[1];
				$option_field_data['shopaholic_option']['gender'] =$na;
			}else{
				$option_field_data['shopaholic_option']['gender'] = '';
			}
			if(request()->countries){
				$option_field_data['shopaholic_option']['countries_ids'] = request()->countries;
			}else{
				$option_field_data['shopaholic_option']['countries_ids'] = '';
			}

			$option_field_data['ids'] = [];
			$group_shopaholic->details = $option_field_data;
			$is_saved_individual_shopaholic = $group_shopaholic->save();
			if($is_saved_individual_shopaholic){
				$msg['status'] = 1;
				return json_encode($msg);
				exit;
			}else{
				$msg['status'] = 0;
				return json_encode($msg);
				exit;
			}
		}
    }
}

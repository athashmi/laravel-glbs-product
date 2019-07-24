<?php

namespace App;
use App\Shopaholic;

use Illuminate\Database\Eloquent\Model;

class ShopaholicGroup extends Model
{
    protected $table = "shopaholic_groups";

    protected $casts = [
        'details' => 'object'
    ];

    public function shopaholic($shopaholic_id){
    	$shopaholic = Shopaholic::where('id',$shopaholic_id)->first();
    	if($shopaholic){
    		return $shopaholic->user->first_name.' '.$shopaholic->user->last_name;
    	}else{
    		return 'No Assign';
    	}
    }

    public function postRelation(){
    	return $this->hasMany(BlogPostRelationship::class,'object_id','id')->where('type','shopaholic_group');
    }
}

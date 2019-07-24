<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopaholicCreditInfo extends Model
{
	use SoftDeletes;

    protected $table = "shopaholic_credit_infos";
    protected $guarded = ['id'];
    public $timestamps = true;

    protected $dates = ['deleted_at'];

    public function shopaholic(){
    	return $this->belongsTo(Shopaholic::class,'shopaholic_id','id');
    }
}

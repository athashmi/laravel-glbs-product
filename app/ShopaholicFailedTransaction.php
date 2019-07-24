<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopaholicFailedTransaction extends Model
{
    //protected $table ="shopaholic_failed_transaction";
    protected $guarded = ['id'];
    public $timestamps = true;

    public function shopaholic(){
    	return $this->belongsTo(Shopaholic::class,'shopaholic_id','id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsolidationRequest extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'address' => 'object',
        'request_infos' => 'object',
        'goods_description_ids' => 'object',
    ];
    public function shopaholic(){
    	return $this->belongsTo(Shopaholic::class,'shopaholic_id','id');
    }
    public function packagePreparing(){
    	return $this->hasMany(Package::class,'consolidation_request_id','id')->where('status','review');
    }

     public function packages(){
        return $this->hasMany(Package::class,'consolidation_request_id','id');
    }


    public function packagePendingPayment(){
        return $this->hasMany(Package::class,'consolidation_request_id','id')->where('status','payment_pending');
    }

    public function packageProcessing(){
        return $this->hasMany(Package::class,'consolidation_request_id','id')->where('status','processing');
    }

    public function boxDetail(){
        return $this->hasMany(ConsolidationBoxDetail::class,'consolidation_request_id','id');
    }
    
    public function fetchLocation(){
        return $this->hasOne(ConsolidationBoxDetail::class,'consolidation_request_id','id');
    }
    
    public function employee(){
        return $this->belongsTo(Employee::class,'assigned_to','id');
    }
    public function requestDetail(){
        return $this->hasMany(ConsolidationRequestActionDetail::class,'consolidation_request_id','id');
    }
    public function shippingCharges(){
        return $this->hasMany(ConsolidationCourierShippingCharges::class,'consolidation_request_id','id');
    }
    public function paymentDetail(){
        return $this->hasOne(ConsolidationRequestPaymentDetail::class , 'consolidation_request_id','id');
    }
   
     

   
}

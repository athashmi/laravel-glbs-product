<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsolidationCourierShippingCharges extends Model
{
    protected $table = "consolidation_courier_shipping_charges";
    protected $casts = [
        'charges' => 'object'
    ];
    public function courier(){
    	return $this->belongsTo(Courier::class,'courier_id','id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsolidationRequestPaymentDetail extends Model
{
    protected $casts = [
        'processing_charges_details' => 'object',
    ];
    public function shippingCharges(){
    	return $this->belongsTo(ConsolidationCourierShippingCharges::class,'consolidation_courier_shipping_charge_id','id');
    }
}

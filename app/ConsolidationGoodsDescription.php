<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsolidationGoodsDescription extends Model
{
	protected $guarded = ['id'];
    protected $casts = [
        'allowed_carriers' => 'object'
    ];

    public function couriers(){
    	return $this->belongsTo(Courier::class);
    }
}

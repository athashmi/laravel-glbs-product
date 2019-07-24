<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsolidationBoxDetail extends Model
{
	protected $casts = [
        'created_at' => 'datetime:F m,Y',
        'details' => 'object'
    ];
    public function location(){
    	return $this->belongsTo(WarehouseShelf::class,'consolidation_location_id','id')->where('usage_type','consolidated');
    }
}

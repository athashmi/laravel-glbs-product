<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Country;
use App\Courier;

class CourierZone extends Model{
    protected $guarded = ['id'];
    public $timestamps = true;
	protected $casts = [
        'country_ids' => 'json'
    ];
    
    public function country($country_id){
    	$country = Country::where('id',$country_id)->first();
    	if($country){
    		return $country->nice_name;
    	}else{
    		return 'Country Not Found';
    	}
    }


    
    public function courierRate(){
        return $this->hasMany(CourierRate::class,'courier_zone_id','id');
    }

    public function courier(){
        return $this->belongsTo(Courier::class);
    }

    public function domesticCourier(){
        return $this->belongsTo(Courier::class)->where('type','domestic');
    }

     
}

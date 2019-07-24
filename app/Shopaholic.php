<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shopaholic extends Model {
	protected $guarded = ['id'];
	public $timestamps = true;

	 protected $casts = [
        'address' => 'object'
    ];

	public function user() {
		return $this->belongsTo(User::class, 'user_id','id');
	}
	/*public function shopaholicAddresses() {
		return $this->hasMany(ShopaholicAddress::class, 'shopaholic_id','id');
	}*/

	public function addresses() {
		return $this->hasMany(ShopaholicAddress::class, 'shopaholic_id','id');
	}

	public function primaryAddress() {
		return $this->hasOne(ShopaholicAddress::class, 'shopaholic_id','id')->where('type','primary')->limit(1);
	}

	/*public function shopaholicAddressesFilteration($q) {
		return $this->hasMany(ShopaholicAddress::class, 'shopaholic_id','id')
					->where(function($query) use ($q){
                    $query->orWhere('name','like',"%$q%")
                     ->orWhere('phone','like',"%$q%")
                     ->orWhere('street','like',"%$q%")
                     ->orWhere('city','like',"%$q%")
                     ->orWhere('state','like',"%$q%")
                     ->orWhere('zip_code','like',"%$q%")
                     ->orWhereHas('country', function($qq) use ($q) {
			        	return $qq->where('name', 'LIKE', '%' . $q . '%');
			    	 });
                });
	}*/

	public function creditCardInfo() {
		return $this->hasMany(ShopaholicCreditInfo::class, 'shopaholic_id','id');
	}
	 
	public function creditCardExist() {
		return $this->hasMany(ShopaholicCreditInfo::class, 'shopaholic_id','id')->where('status','verified');
	}

	

}

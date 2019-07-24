<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopaholicAddress extends Model
{
    protected $table = "shopaholic_addresses";
    protected $guarded = ['id'];
    public $timestamps = true;

    public function country()
    {
    	return $this->belongsTo(Country::class);
    }
}

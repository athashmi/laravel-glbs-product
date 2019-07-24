<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = "warehouses";
    protected $guarded = ['id'];
    public $timestamps = true;

    public function country()
    {
    	return $this->belongsTo(Country::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageCustomDetail extends Model
{
    public function category(){
    	return $this->belongsTo(PackageCustomCategory::class,'custom_category_id','id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class PackageServiceRequests extends Model
{
    protected $casts = [
        'details' => 'object'
    ];


    public function routeNotificationFor($notification)
    {
        return Auth::user()->email;
    }

    public function services(){
    	return $this->belongsTo(PackageService::class,'package_service_id','id');
    }
    
}

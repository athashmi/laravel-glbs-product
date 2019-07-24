<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
   protected $table = "couriers";
   protected $guarded = ['id'];
   public $timestamps = true;
    protected $casts = [
        'details' => 'object'
    ];

   public function courier_zone(){
   		return $this->hasMany(CourierZone::class);
   }
   public function domesticCourier(){
        return $this->hasOne(CourierZone::class);
    }
}

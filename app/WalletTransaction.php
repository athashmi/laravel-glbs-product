<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    protected $table = "wallet_transactions";
    protected $guarded = ['id'];
    public $timestamps = true;


    public function walletRequest() {
    	return $this->belongsTo(WalletRequest::class,'request_id','id');
    }
 
}

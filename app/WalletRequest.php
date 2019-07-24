<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\WalletTransaction;


class WalletRequest extends Model
{
    protected $table = "wallet_requests";
    protected $guarded = ['id'];
    public $timestamps = true;

     protected $casts = [
        'remarks' => 'object',
        'details' => 'object'
    ];

    
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
    public function transaction()
    {
    	return $this->hasOne(WalletTransaction::class,'request_id','id');
    }
     
    public function closingbalance()
    {
    	return $this->hasOne(WalletTransaction::class,'request_id','id');
    } 


    

     static function walletBalance($user_id)
    {
        return static::where('user_id',$user_id)->where('status','processed')->orWhere('status','offline_payment')->orderBy('created_at','desc')->take(1)->with(['transaction'=> function($query){
                        $query->orderBy('created_at', 'desc')->take('1');
                    }])->first();
    }

     



    public function processedBy()
    {
        return $this->belongsTo(User::class,'processed_by','id');
    }   
}

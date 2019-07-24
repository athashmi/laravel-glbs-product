<?php

namespace App;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;


use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable implements MustVerifyEmail {
	use Notifiable;

	use EntrustUserTrait;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];
	// protected $fillable = [
	// 	'first_name', 'email', 'password',
	// ];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function employee() {
		return $this->hasOne(Employee::class);
	}
	public function shopaholic() {
		return $this->hasOne(Shopaholic::class);
	}
	public function wallet() {
		return $this->hasOne(WalletRequest::class);
	}

	public function walletRequests() {
		return $this->hasMany(WalletRequest::class, 'user_id');
	}

	public function walletBalance() {
		return $this->hasOne(WalletRequest::class, 'user_id')->where('status','processed')->orderBy('created_at','desc')
		->take(1)
		->with(['transaction'=> function($query){
                        $query->orderBy('created_at', 'desc')->take('1');
                    }])->limit(1)
		;
	}


	public function country() {
		return $this->belongsTo(Country::class);
	}
	

	public function sendPasswordResetNotification($token)
		{
				//dd($token);

				$this->notify(new ResetPasswordNotification($token));

			//$this->notify(new App\Notifications\MailResetPasswordNotification($token));
		}

		 public function getFullNameAttribute() {
        return $this->attributes['first_name']. ' ' .$this->attributes['last_name'];
    }
	
}

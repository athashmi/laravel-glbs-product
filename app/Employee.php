<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {
	protected $guarded = ['id'];
	public $timestamps = false;

	public function managedBy() {
		return $this->belongsTo(User::class, 'managed_by');
	}

	public function user() {
		return $this->belongsTo(User::class, 'user_id');
	}

}

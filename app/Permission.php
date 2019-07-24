<?php
namespace App;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission {

	protected $fillable = array('display_name', 'name', 'description');
	public $timestamps = true;
}
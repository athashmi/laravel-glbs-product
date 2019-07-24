<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected $global_user;

	function __construct() {
		//dd('lll');
		//dd(Auth::User());
		/*if (Auth::user()) {
			dd(Auth::user());
			$this->global_user = Auth::user();
		}

		\View::share('global_user', $this->global_user);*/
	}
}

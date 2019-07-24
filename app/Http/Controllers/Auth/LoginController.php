<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Request;

class LoginController extends Controller {
	/*
		    |--------------------------------------------------------------------------
		    | Login Controller
		    |--------------------------------------------------------------------------
		    |
		    | This controller handles authenticating users for the application and
		    | redirecting them to your home screen. The controller uses a trait
		    | to conveniently provide its functionality to your applications.
		    |
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest')->except('logout');
	}
	public function showLoginForm() {
		$current_url = Request::path();
		//if ($current_url == 'admin/login' || $current_url == 'admin') {
		if (Request::is('admin/*')) {
			return view('auth.login');
		}
		if ($current_url == 'login') {
			return view('frontend.auth.login');
		}
	}
	protected function authenticated($request, $user) {
		if ($user->hasRole(['owner', 'admin', 'manager'])) {
			return redirect()->route('admin_dashboard');
		}
		if ($user->hasRole(['employee','worker'])) {

			
			return redirect()->route('employee.employee_dashboard');
		}
		if ($user->hasRole(['shopaholic'])) {
			return redirect()->route('client_dashboard');
		}
	}

}

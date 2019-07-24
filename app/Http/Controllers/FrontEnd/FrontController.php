<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class FrontController extends Controller {

	public function index() {
		$user_type = 0;
		if (Session::has('shopaholic_id')) {
			$user_type = 2;
			$shopaholic = Shopaholic::where('id', Session::get('shopaholic_id'))->first();
		} else {
			$shopaholic = array();
		}
		if (Session::has('shopper_id')) {
			$user_type = 1;
			$shopper = Shopper::where('id', Session::get('shopper_id'))->first();
		} else {
			$shopper = array();
		}
		return view('frontend.index')->with('shopaholic', $shopaholic)->with('shopper', $shopper)->with('user_type', $user_type);
	}

	function maintenance() {
		return view('frontend.maintenance');
	}
	public function aboutUs() {
		return view('frontend.about_us');
	}
	public function accountAddress() {
		return view('frontend.account_address');
	}
	public function myTickets() {
		return view('frontend.tickets');
	}
	public function assistedPurchase() {
		return view('frontend.assisted_purchase');
	}
	public function blogs() {
		return view('frontend.blogs');
	}
	public function businessSolutions() {
		return view('frontend.business-solution.business-solution');
	}
	public function faqs() {
		return view('frontend.faqs.faqs');
	}
	public function forgotPassword() {
		if (Session::has('shopaholic_id')) {
			return Redirect::to('/');
		} else {
			return view('frontend.auth.forgot_password');
		}
	}
	public function myProfile() {
		return view('frontend.my_profile');
	}
	public function orderList() {
		return view('frontend.order_list');
	}
	public function wishList() {
		return view('frontend.wish_list');
	}
	public function shippingRates() {
		return view('frontend.shipping_rates');
	}
	public function loginRegister() {
		if (Session::has('shopaholic_id')) {
			return Redirect::to('/');
		} else {
			return view('frontend.register');
		}
	}
	public function user_login() {
		if (Session::has('shopaholic_id')) {
			return Redirect::to('/');
		} else {
			// return view('frontend.user_login');
		}
	}
	public function submitFraudi() {
		return view('frontend.fraudi');
	}
	public function logout() {
		session::flush();
		return view('frontend.index');
	}

	public function sendContactUs() {
		$data = array();
		$data['name'] = Input::get('name');
		$data['type'] = "Contact Us";
		$data['email'] = Input::get('email');
		$data['phone'] = Input::get('phone');
		$data['volume'] = Input::get('volume');
		$data['requirments'] = Input::get('requirments');
		$data['country'] = Input::get('country');
		$data['sn_number'] = Input::get('sn_number');
		$data['website'] = Input::get('website');
		$msg = send_contact_us_mail($data);
		if ($msg == "success") {
			$error_message = 'Thank You! Our Team will Contact you Shortly';
		} else {
			$error_message = 'Sorry! Your we have small problem this time. Please try again later';
		}
		return Redirect::back()->with('error', $error_message);
	}

	public function sendFraudi() {
		$data = array();
		$data['name'] = Input::get('name');
		$data['type'] = "Frundi";
		$data['email'] = Input::get('email');
		$data['phone'] = Input::get('phone');
		$data['requirments'] = Input::get('requirments');
		$data['country'] = Input::get('country');
		$data['sn_number'] = Input::get('sn_number');
		$data['website'] = Input::get('website');
		$msg = send_fraudi_mail($data);
		if ($msg == "success") {
			$error_message = 'Thank You! Our Team will Contact you Shortly';
		} else {
			$error_message = 'Sorry! Your we have small problem this time. Please try again later';
		}
		return Redirect::back()->with('error', $error_message);
	}

	public function loadZones() {

	}
	public function loadShipppingRates() {
		$country_code = Input::get('country');
		$country_code = strtoupper($country_code);
		$zip = Input::get('zip');
		$unit = Input::get('unit');
		$weight = Input::get('weight');
		$length = Input::get('length');
		$height = Input::get('height');
		$width = Input::get('width');
		if (!isset($weight)) {
			$weight = 0;
		} else {
			$weight = (float) $weight;
		}
		if (!isset($height)) {
			$height = 0;
		} else {
			$height = (float) $height;
		}
		if (!isset($length)) {
			$length = 0;
		} else {
			$length = (float) $length;
		}
		if (!isset($width)) {
			$width = 0;
		} else {
			$width = (float) $width;
		}
		$data = array();
		$zone = "";

		if ($unit == "kg") {
			$weight = ceil(kg_to_pounds($weight));
			$length = cm_to_inches($length);
			$width = cm_to_inches($width);
			$height = cm_to_inches($height);
		}
		$c = Countries::select('*')->where('iso', $country_code)->first();
		$country = $c->nicename;

		if ($country_code == "CA") {
			$data = CountryZones::select('*')->where('country', $country)->where('zip', $zip)->first();
			if (count($data) > 0) {
				$zone = "a";
			} else {
				$zone = "b";
			}
		} else {
			$data = CountryZones::select('*')->where('country', $country)->first();
			$zone = $data->zone;
		}

		$dimension_weight = ($length * $width * $height) / 138.4;

		$diff = $dimension_weight - $weight;

		if ($diff > 15 && $diff < 24) {
			$dimension_weight = ($length * $width * $height) / 166;
		} else if ($diff > 24) {
			$dimension_weight = ($length * $width * $height) / 194;
		}

		if ($dimension_weight > $weight) {
			$weight = $dimension_weight;
		}
		$dweight = $weight;

		$rate = "";
		$rates = array();

		if ($country_code == "SA") {
			$result = AirbnRate::where('weight', round($weight))->first();
			if ($result) {
				$rates['airbn_direct'] = $result->direct;
				$rates['airbn_ex'] = $result->indirect;
			}

		}

		$zone = strtolower($zone);
		$result = FedexRate::where('weight', $weight)->get();
		if (count($result) > 0) {
			foreach ($result as $r) {
				$type = $r->type;
				$rates[$type] = $r->$zone;
			}
			$rates['fedex_economy'] = getWithTax($rates['fedex_economy'], "Fedex_Economy");
			$rates['fedex_priority'] = getWithTax($rates['fedex_priority'], "Fedex_Priority");
			$rates['fedex_economy'] = manipulateFedexRates($rates['fedex_economy'], $zone, "economy", $weight);
			$rates['fedex_priority'] = manipulateFedexRates($rates['fedex_priority'], $zone, "priority", $weight);

			// FedEx rates increasted by 10%
			$rates['fedex_economy'] = $rates['fedex_economy'] + $rates['fedex_economy'] * .1;
			$rates['fedex_priority'] = $rates['fedex_priority'] + $rates['fedex_priority'] * .1;
		} else {
			$rates['fedex_priority'] = 0.00;
			$rates['fedex_economy'] = 0.00;
		}

		$dweight = round($dweight);
		$z = DHLZone::select('*')->where('code', $country_code)->first();
		$zone = strtolower($z->zone);
		if ($dweight > 150) {
			if ($dweight > 150 && $dweight <= 331) {
				$result = DHLRate::where('weight', 151)->first();
				$r = $result->$zone;
			} else if ($dweight > 331 && $dweight <= 660) {
				$result = DHLRate::where('weight', 331)->first();
				$r = $result->$zone;
			} else if ($dweight > 661 && $dweight <= 2199) {
				$result = DHLRate::where('weight', 661)->first();
				$r = $result->$zone;
			} else if ($dweight > 2199) {
				$result = DHLRate::where('weight', 2199.1)->first();
				$r = $result->$zone;
			}
			$rates['dhl_rates'] = $r * $dweight;
		} else {
			$result = DHLRate::where('weight', $dweight)->first();
			$rates['dhl_rates'] = $result->$zone;
		}
		$rates['dhl_rates'] = getWithTax($rates['dhl_rates'], "Dhl_Express");
		$rates['dhl_rates'] = manipulateDHLRates($rates['dhl_rates'], $dweight);

		$country = strtolower($country);
		$data = UPSZone::select('*')->where('country', $country)->first();
		$zone = $data->priority;
		$saver = $data->saver;
		$express = $data->express;

		if ($weight > 150) {
			$r = 0;
			$result = UPSExpediteRate::where('weight', 151)->first();
			$result = $result->toArray();
			foreach ($result as $key => $value) {
				if ($key == $zone) {
					$r = $value;
				}
			}
			$rates['ups_rate'] = $r * $weight;
		} else {
			$result = UPSExpediteRate::where('weight', $weight)->first();
			if ($result) {
				$result = $result->toArray();
				foreach ($result as $key => $value) {
					if ($key == $zone) {
						$rates['ups_rate'] = $value;
					}
				}
			}
			if ($result) {
				$rates['ups_rate'] = getWithTax($rates['ups_rate'], "Ups_Expedite");
				$rates['ups_rate'] = manipulateUPSExpediteRates($rates['ups_rate'], $weight);
			}
		}

		if ($saver != 0) {
			if ($weight > 150) {
				$r = 0;
				$result = UPSSaverRate::where('weight', 151)->first();
				$result = $result->toArray();
				foreach ($result as $key => $value) {
					if ($key == $saver) {
						$r = $value;
					}
				}
				$rates['ups_saver_rate'] = $r * $weight;
			} else {
				$result = UPSSaverRate::where('weight', $weight)->first();
				if ($result) {
					$result = $result->toArray();
					foreach ($result as $key => $value) {
						if ($key == $saver) {
							$rates['ups_saver_rate'] = $value;
						}
					}

					$rates['ups_saver_rate'] = getWithTax($rates['ups_saver_rate'], "Ups_Saver");
					$rates['ups_saver_rate'] = manipulateUPSSaverRates($rates['ups_saver_rate'], $weight);
				}

			}
		} else {
			$rates['ups_saver_rate'] = 0;
		}
		if ($express != 0) {
			if ($weight > 150) {
				$r = 0;
				$result = UPSExpressRate::where('weight', 151)->first();
				$result = $result->toArray();
				foreach ($result as $key => $value) {
					if ($key == $express) {
						$r = $value;
					}
				}
				// dd($express);
				$rates['ups_express_rate'] = $r * $weight;
			} else {
				$result = UPSExpressRate::where('weight', ceil($weight))->first();
				$result = $result->toArray();
				foreach ($result as $key => $value) {
					if ($key == $express) {
						$rates['ups_express_rate'] = $value;
					}
				}
			}
		} else {
			$rates['ups_express_rate'] = 0;
		}

		$rates['ups_express_rate'] = getWithTax($rates['ups_express_rate'], "Ups_Express");
		$rates['ups_express_rate'] = manipulateUPSExpressRates($rates['ups_express_rate'], $weight);

		$country = strtoupper($country);
		$result = AramexRate::where('country', $country)->first();
		if ($weight > 1) {
			$remain = $weight - 1;
			$p1 = $result['first_pound'];
			$p2 = $result['per_pound'] * $remain;
			$rates['aramex_rate'] = $p1 + $p2;
		} else if ($weight != 0 || $weight != "") {
			$rates['aramex_rate'] = $result['first_pound'];
		}
		if ($weight > 2) {
			$rates['aramex_rate'] = getWithTax($rates['aramex_rate'], "Aramax_Express");
		} else {
			$rates['aramex_rate'] = addFuelSurcharges($rates['aramex_rate'], "Aramax_Express");
		}

		foreach ($rates as $key => $rate) {
			if ($key == 'ups_express_rate' || $key == "ups_saver_rate" || $key == "ups_rate") {
				if ($rate != 0) {
					$rates[$key] = $rate + 3.25;
				}
			}
		}
		// $rates = $this->updateRates($weight, $country_code, $rates);

		return Response::json($rates);
	}

	function updateRates($weight, $country_code, $rates) {
		$round_weight = ceil($weight);
		$toCountry = Countries::select('isK')->where('iso', $country_code)->first();
		$fedExRates = FedExRates::where('weight', $round_weight)->first();

		foreach ($rates as $key => $rate) {

			// FedEx
			if ($key == 'fedex_economy' && $toCountry->isK == 1) {
				if ($round_weight < 99) {
					$updated_rate = $rate + ($fedExRates->economyZoneK);
				} else {
					$updated_rate = $rate * 2;
				}
			} else if ($key == 'fedex_priority' && $toCountry->isK == 1) {
				if ($round_weight < 99) {
					$updated_rate = $rate + ($fedExRates->priorityZoneK);
				} else {
					$updated_rate = $rate + ($rate * 77) / 100;
				}
			} else if ($key == 'fedex_economy' && $toCountry->isK == 0) {
				if ($round_weight < 99) {
					$updated_rate = $rate + ($fedExRates->economyZoneR);
				} else {
					$updated_rate = $rate + ($rate * 77) / 100;
				}
			} else if ($key == 'fedex_priority' && $toCountry->isK == 0) {
				if ($round_weight < 65) {
					$updated_rate = $rate + ($fedExRates->priorityZoneR);
				} else {
					$updated_rate = $rate * 1.5;
				}
			} else if ($key == 'FEDEX_GROUND') {
				$updated_rate = $rate + ($rate * 30) / 100;
			}

			// UPS
			if ($key == 'ups_rate' && $toCountry->isK == 1) {
				if ($round_weight < 99) {
					$updated_rate = $rate + ($fedExRates->economyZoneK);
				} else {
					$updated_rate = $rate * 2;
				}
			} else if (($key == 'ups_saver_rate' || $key == 'Ups_Express') && $toCountry->isK == 1) {
				if ($round_weight < 99) {
					$updated_rate = $rate + ($fedExRates->priorityZoneK);
				} else {
					$updated_rate = $rate + ($rate * 77) / 100;
				}
			} else if ($key == 'ups_rate' && $toCountry->isK == 0) {
				if ($round_weight < 99) {
					$updated_rate = $rate + ($fedExRates->economyZoneR);
				} else {
					$updated_rate = $rate + ($rate * 77) / 100;
				}
			} else if (($key == 'ups_saver_rate' || $key == 'Ups_Express') && $toCountry->isK == 0) {
				if ($round_weight < 65) {
					$updated_rate = $rate + ($fedExRates->priorityZoneR);
				} else {
					$updated_rate = $rate * 1.5;
				}
			}

			// USPS
			if ($key == 'USPS') {
				$updated_rate = $rate + ($rate * 30) / 100;
			}

			//Aramex
			if ($key == 'aramex_rate') {
				if (floatval($weight) >= 3) {
					$updated_rate = $rate + ($rate * 25) / 100;
				}
			}

			// DHL
			if ($key == 'dhl_rates') {
				if ($round_weight < 65) {
					$updated_rate = $rate + ($fedExRates->priorityZoneR);
				} else {
					$updated_rate = $rate * 1.5;
				}
			}
			$rates[$key] = $updated_rate;
		}
		return $rates;
	}

	//login with facebook
	public function loginWithFacebook(Request $request) {

		// get data from input
		$code = $request->code;
		// get fb service
		$fb = OAuth::consumer('Facebook');
		// dd($fb);

		// check if code is valid

		// if code is provided get user data and sign in
		if (!empty($code)) {

			// This was a callback request from facebook, get the token
			$token = $fb->requestAccessToken($code);

			// Send a request with it
			$result = json_decode($fb->request('/me'), true);

			$message = 'Your unique facebook user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
			echo $message . "<br/>";

			//Var_dump
			//display whole array().
			// dd($result);
			$email = "";
			if (isset($result['email'])) {
				$email = $result['email'];
			} else {
				$email = $result['id'];
			}
			$old = Shopaholic::where('email', $email)->first();
			if (count($old) > 0) {
				$error_message = 'Email is Already Exists Please login to Continue';
				return Redirect::to('login')->with('error', $error_message);
			} else {
				$shopaholic = new Shopaholic;
				$shopaholic->first_name = $result['name'];
				$shopaholic->last_name = "";
				$shopaholic->email = $email;
				$shopaholic->email_verify_code = "";
				$shopaholic->is_email_verified = 1;
				$shopaholic->password = Hash::make("123456");
				$shopaholic->ip_address = $_SERVER['REMOTE_ADDR'];
				$shopaholic->save();

				$data['name'] = $result['name'];
				$data['email'] = $email;
				$data['password'] = "123456";
				$user_id = $shopaholic->id;
				$error_message = 'Thank you for registering. Please Check your email for Username and Password. You can use that for next time login';
				//send email varification mail

				$wallet = new Wallet;
				$wallet->user_id = $shopaholic->id;
				$wallet->user_type = 2;
				$wallet->save();
				if (isset($result['email'])) {
					send_email_username_password($data);
				}
				$shopaholic->is_logged_in = 1;
				$shopaholic->update();
				Session::put('shopaholic_id', $shopaholic->id);
				return Redirect::route('shopaholic_dashboard')->with('error', $error_message);
			}
		}
		// if not ask for permission first
		else {
			// get fb authorization
			$url = $fb->getAuthorizationUri();

			// return to facebook login url
			return Redirect::to((string) $url);
		}

	}

//login with google
	public function loginWithGoogle() {

		// get data from input
		$code = Input::get('code');

		// get google service
		$googleService = OAuth::consumer('Google');
		// check if code is valid

		// if code is provided get user data and sign in
		if (!empty($code)) {

			// This was a callback request from google, get the token
			$token = $googleService->requestAccessToken($code);

			// Send a request with it
			$result = json_decode($googleService->request('https://www.googleapis.com/oauth2/v1/userinfo'), true);

			$message = 'Your unique Google user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
			echo $message . "<br/>";

			//Var_dump
			//display whole array().
			// dd($result);

			$old = Shopaholic::where('email', $result['email'])->first();
			if (count($old) > 0) {
				$error_message = 'Email is Already Exists Please login to Continue';
				return Redirect::to('login')->with('error', $error_message);
			} else {
				$shopaholic = new Shopaholic;
				$shopaholic->first_name = $result['name'];
				$shopaholic->last_name = "";
				$shopaholic->email = $result['email'];
				$shopaholic->email_verify_code = "";
				$shopaholic->is_email_verified = 1;
				$shopaholic->password = Hash::make("123456");
				$shopaholic->ip_address = $_SERVER['REMOTE_ADDR'];
				$shopaholic->save();

				$data['name'] = $result['name'];
				$data['email'] = $result['email'];
				$data['password'] = "123456";
				$user_id = $shopaholic->id;
				$error_message = 'Thank you for registering. Please Check your email for Username and Password. You can use that for next Time login.';
				//send email varification mail

				$wallet = new Wallet;
				$wallet->user_id = $shopaholic->id;
				$wallet->user_type = 2;
				$wallet->save();

				send_email_username_password($data);
				$shopaholic->is_logged_in = 1;
				$shopaholic->update();
				Session::put('shopaholic_id', $shopaholic->id);
				return Redirect::route('shopaholic_dashboard')->with('error', $error_message);
			}
		}
		// if not ask for permission first
		else {
			// get googleService authorization
			$url = $googleService->getAuthorizationUri();
			// return to google login url
			return Redirect::to((string) $url);
		}
	}

	public function loginWithTwitter() {

		// get data from input
		$token = Input::get('oauth_token');
		$verify = Input::get('oauth_verifier');

		// get twitter service
		$tw = OAuth::consumer('Twitter');

		// check if code is valid

		// if code is provided get user data and sign in
		if (!empty($token) && !empty($verify)) {
			// This was a callback request from twitter, get the token
			$token = $tw->requestAccessToken($token, $verify);

			// Send a request with it
			$result = json_decode($tw->request('account/verify_credentials.json'), true);

			$message = 'Your unique Twitter user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
			echo $message . "<br/>";
			$email = "";
			if (isset($result['email'])) {
				$email = $result['email'];
			} else {
				$email = $result['id'];
			}
			$old = Shopaholic::where('email', $email)->first();
			if (count($old) > 0) {
				$error_message = 'Email is Already Exists Please login to Continue';
				return Redirect::to('login')->with('error', $error_message);
			} else {
				$shopaholic = new Shopaholic;
				$shopaholic->first_name = $result['name'];
				$shopaholic->last_name = "";
				$shopaholic->email = $email;
				$shopaholic->email_verify_code = "";
				$shopaholic->is_email_verified = 1;
				$shopaholic->password = Hash::make("123456");
				$shopaholic->ip_address = $_SERVER['REMOTE_ADDR'];
				$shopaholic->save();

				$data['name'] = $result['name'];
				$data['email'] = $email;
				$data['password'] = "123456";
				$user_id = $shopaholic->id;
				$error_message = 'Thank you for registering. Please Check your email for Username and Password. You can use that for next time login';
				//send email varification mail

				$wallet = new Wallet;
				$wallet->user_id = $shopaholic->id;
				$wallet->user_type = 2;
				$wallet->save();
				if (isset($result['email'])) {
					send_email_username_password($data);
				}
				$shopaholic->is_logged_in = 1;
				$shopaholic->update();
				Session::put('shopaholic_id', $shopaholic->id);
				return Redirect::route('shopaholic_dashboard')->with('error', $error_message);
			}
		}
		// if not ask for permission first
		else {
			// get request token
			$reqToken = $tw->requestRequestToken();

			// get Authorization Uri sending the request token
			$url = $tw->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));

			// return to twitter login url
			return Redirect::to((string) $url);
		}
	}

}

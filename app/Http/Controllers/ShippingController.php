<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;
use Config;
use App\Country;
use App\RateManipulation;

class ShippingController extends Controller
{
    public function __construct(){
		Config::set('services.easypost.api_key', Helper::dbConfigValue('easypost','api_key') );
	}

	public function shippingCalculator(){
		$countries = Country::all();
		return view('shipping.calculator',compact('countries'));
	}

	public function ajaxShippingCalculator() {

		//dd(request()->all());
    	$to_country 		= request()->to_country;
		$to_city    		= request()->to_city;
		$to_zip     		= request()->to_zip;
		$call_from     		= request()->call_from;

		$parcel_length  	= request()->parcel_length;
		$parcel_width 		= request()->parcel_width;
		$parcel_height  	= request()->parcel_height;
		$parcel_weight  	= request()->parcel_weight;

		\EasyPost\EasyPost::setApiKey(Config::get('services.easypost.api_key'));
		$from_adrs = array(
			"name"    => "Safian Hafeez",
			"street1" => "601 carnell Drive Unit G11",
			"street2" => "Global Shopaholics",
			"city"    => "Wilmington",
			"state"   => "DE",
			"zip"     => "19713",
			'country' => "US"
			);

		$to_adrs = array(
			"name"    		=> "Sawyer Bateman",
			"street1" 		=> "1A Larkspur Cres",
			'residential' 	=> true,
			"city"    		=> $to_city,
			"zip"     		=> $to_zip,
			"country" 		=> $to_country
			);
		$from_address = \EasyPost\Address::create($from_adrs);
		$to_address = \EasyPost\Address::create($to_adrs);

		$customs_item_params = array(
			"description"      => "Many, many EasyPost stickers.",
			"hs_tariff_number" => '620520000000',
			"origin_country"   => "US",
			"quantity"         => 1,
			"value"            => '1',
			"weight"           => 14,
			"code"             => 1234,
			"manufacturer"     => "Sony"
		);

		$customs_item = \EasyPost\CustomsItem::create($customs_item_params);
		$customs_info_params = array(
			"customs_certify"      => true,
			"customs_signer"       => "Borat Sagdiyev",
			"contents_type"        => "gift",
		    "contents_explanation" => "",
		    "eel_pfc"              => "NOEEI 30.37(a)",
		    "non_delivery_option"  => "abandon",
		    "restriction_type"     => "none",
		    "restriction_comments" => "",
		    "customs_items"        => array($customs_item)
		);
		$customs_info = \EasyPost\CustomsInfo::create($customs_info_params);
		$customs_items = [];
		$contents_explanation = [];
		for ($i=0;$i<count($parcel_length);$i++) {
				$customs_item_params = array(
					"description"      => "T-Shirt.",
	                "hs_tariff_number" => '620520000000',
	                "origin_country"   => "US",
	                "quantity"         => 1,
	                "value"            => 1.23,
	                "weight"           => 3
				);
				$customs_items[] = \EasyPost\CustomsItem::create($customs_item_params);
				$contents_explanation[] = preg_replace('/[^A-Za-z0-9\-\(\) ]/', '', "T-Shirt");
		}
		$contents_type = 'Merchandise';
		$contents_explanation = implode(",", $contents_explanation);
		$contents_explanation = substr($contents_explanation, 0, 200);
		$customs_info_params = array(
			"customs_certify"      => true,
			"customs_signer"       => "Global Shopaholic",
			"contents_type"        => $contents_type,
		    "contents_explanation" => removeSpecialChar($contents_explanation),
		    "eel_pfc"              => "NOEEI 30.37(a)",
		    "non_delivery_option"  => "return",
		    "restriction_type"     => "none",
		    "restriction_comments" => "",
		    "customs_items"        => $customs_items
		);
		$customs_info = \EasyPost\CustomsInfo::create($customs_info_params);
		$shipments = [];
		$round_weight = 0;

		for ($i=0;$i<count($parcel_length);$i++) {
			if($_POST['measurement_unit'] == 2 ){
				$parcel_length[$i] 	= cm_to_inches($parcel_length[$i]);
				$parcel_width[$i]  	= cm_to_inches($parcel_width[$i]);
				$parcel_height[$i] 	= cm_to_inches($parcel_height[$i]);
				$parcel_weight[$i]  = kg_to_pounds($parcel_weight[$i]);
			}

			$parcel['length'] 	= $parcel_length[$i];
			$parcel['width']  	= $parcel_width[$i];
			$parcel['height'] 	= $parcel_height[$i];
			$dimension_weight   = ($parcel_length[$i] * $parcel_width[$i] * $parcel_height[$i])/138.4;
			$diff = $dimension_weight - $parcel_weight[$i];
			if($diff > 15 && $diff < 25){
				$dimension_weight = ($parcel_length[$i] * $parcel_width[$i] * $parcel_height[$i])/166;
			}else if($diff > 24){
				$dimension_weight = ($parcel_length[$i] * $parcel_width[$i] * $parcel_height[$i])/194;
			}
			if($dimension_weight > $parcel_weight[$i] ) {
				$parcel['weight'] 	= pounds_to_ounces($dimension_weight);
			}else {
				$parcel['weight'] 	= pounds_to_ounces($parcel_weight[$i]);
			}
			$round_weight += $parcel['weight'];
			$shipments[$i]['parcel']  = $parcel;
			$shipments[$i]['customs_info'] = $customs_info;
			$shipments[$i]['reference'] 	= "Calculate Shipment";
			$shipments[$i]['options']       = array('incoterm' => "DDU");
		}

		$round_weight = ounces_to_pounds($round_weight);
		$shipments = \EasyPost\Order::create(array(
		    "from_address" 	=> $from_address,
		    "to_address" 	=> $to_address,
		    "shipments"		=> $shipments
		));
		$ins_amount = 0;
		$responseData = [];

		//dd($shipments->rates);
		foreach ($shipments->rates as $rate) {
			$rateArr 			= [];
			$rateArr['id'] 		= $rate->id;
			$rateArr['carrier'] = $rate->carrier;
			$rateArr['service'] = $rate->service;
			$rateArr['rate'] 	= $rate->rate + $ins_amount;
			$rateArr['actaul_rate'] 	= $rate->rate + $ins_amount;
			$_SESSION[$rateArr['service']] = $rate->delivery_date;
			$toCountry 		= Country::select('isK')->where('iso', $to_country)->first();
			$fedExRates 	= RateManipulation::where('weight', ceil($round_weight))->first();
			if($rateArr['carrier'] == 'FedEx'){
				if($rateArr['service'] == 'INTERNATIONAL_ECONOMY' && $toCountry->isK == 1) {
					if($round_weight < 99){
						$rateArr['rate'] = $rateArr['rate'] + ($fedExRates->economyZoneK);
					}else {
						$rateArr['rate'] = $rateArr['rate'] * 2 ;
					}
				} else if($rateArr['service'] == 'INTERNATIONAL_PRIORITY' && $toCountry->isK == 1) {
					if($round_weight < 99){
						$rateArr['rate'] = $rateArr['rate'] + ($fedExRates->priorityZoneK);
					}else {
						$rateArr['rate'] = $rateArr['rate'] + ($rateArr['rate'] * 77)/100 ;
					}
				}else if($rateArr['service'] == 'INTERNATIONAL_ECONOMY' && $toCountry->isK == 0) {
					if($round_weight < 99){
						$rateArr['rate'] = $rateArr['rate'] + ($fedExRates->economyZoneR);
					}else {
						$rateArr['rate'] = $rateArr['rate'] + ($rateArr['rate'] * 77)/100 ;
					}
				}else if($rateArr['service'] == 'INTERNATIONAL_PRIORITY' && $toCountry->isK == 0) {
					if($round_weight < 65){

						$rateArr['rate'] = $rateArr['rate'] + ($fedExRates->priorityZoneR);
					}else {
						$rateArr['rate'] = $rateArr['rate'] * 1.5 ;
					}
				}else if($rateArr['service'] == 'FEDEX_GROUND' || $rateArr['service'] == 'FIRST_OVERNIGHT' || $rateArr['service'] == 'PRIORITY_OVERNIGHT' || $rateArr['service'] == 'STANDARD_OVERNIGHT' || $rateArr['service'] == 'FEDEX_2_DAY_AM' || $rateArr['service'] == 'FEDEX_2_DAY' || $rateArr['service'] == 'FEDEX_EXPRESS_SAVER' || $rateArr['service'] == 'GROUND_HOME_DELIVERY') {
					$rateArr['rate'] = $rateArr['rate'] + ($rateArr['rate'] * 50)/100 ;
				}

				// $rateArr['rate'] =  $rateArr['rate'] + $rateArr['rate'] * .15;
			}else if($rateArr['carrier'] == 'UPS'){
				if($rateArr['service'] == 'Ground' || $rateArr['service'] == '3DaySelect' || $rateArr['service'] == '2ndDayAir' || $rateArr['service'] == 'NextDayAirSaver' || $rateArr['service'] == 'NextDayAirEarlyAM' || $rateArr['service'] == 'NextDayAir'){
					$rateArr['rate'] = $rateArr['rate'] + ($rateArr['rate'] * 30)/100 ;
				}else if($rateArr['service'] == 'Expedited' && $toCountry->isK == 1) {
					if($round_weight < 99){
						$rateArr['rate'] = $rateArr['rate'] + ($fedExRates->economyZoneK);
					}else {
						$rateArr['rate'] = $rateArr['rate'] * 2 ;
					}
				} else if($rateArr['service'] != 'Expedited' && $toCountry->isK == 1) {
					if($round_weight < 99){
						$rateArr['rate'] = $rateArr['rate'] + ($fedExRates->priorityZoneK);
					}else {
						$rateArr['rate'] = $rateArr['rate'] + ($rateArr['rate'] * 77)/100 ;
					}
				}else if($rateArr['service'] == 'Expedited' && $toCountry->isK == 0) {
					if($round_weight < 99){
						$rateArr['rate'] = $rateArr['rate'] + ($fedExRates->economyZoneR);
					}else {
						$rateArr['rate'] = $rateArr['rate'] + ($rateArr['rate'] * 77)/100 ;
					}
				}else if($rateArr['service'] != 'Expedited' && $toCountry->isK == 0) {
					if($round_weight < 65){
						$rateArr['rate'] = $rateArr['rate'] + ($fedExRates->priorityZoneR);
					}else {
						$rateArr['rate'] = $rateArr['rate'] * 1.5 ;
					}
				}
			}else if($rateArr['carrier'] == 'USPS'){
				$rateArr['rate'] = $rateArr['rate'] + ($rateArr['rate'] * 30)/100 ;
			}else if($rateArr['carrier'] == 'Aramex'){
				if(floatval($round_weight) >= 3){
					$rateArr['rate'] = $rateArr['rate'] + ($rateArr['rate'] * 25)/100 ;
				}
			}else if($rateArr['carrier'] == 'DHLExpress') {
			    if($round_weight < 65){
					$rateArr['rate'] = $rateArr['rate'] + ($fedExRates->priorityZoneR);
				}else {
					$rateArr['rate'] = $rateArr['rate'] * 1.5 ;
				}
			}

			$rateArr['est_delivery_days'] = $rate->est_delivery_days;
			$rateArr['shipment_id']       = $shipments->id;

			// Update rate 4.4 %
			$rateArr['rate'] = $rateArr['rate'] +  $rateArr['rate'] * 0.044 ;

			if($rate->carrier == 'DHLExpress'){
				if($rate->service == "ExpressWorldwideNonDoc"){ $responseData[] = $rateArr; }
			}elseif($rate->carrier == 'Aramex'){
				if($rate->service == "PriorityParcelExpress"){
				// $responseData[] = $rateArr;
				 }
			}else{
				$responseData[] = $rateArr;
			}
		}

		echo json_encode($responseData);
	}
}

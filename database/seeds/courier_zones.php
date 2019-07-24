<?php


use App\Country;
use App\CourierZone;
use App\CourierRate;
use App\Courier;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class courier_zones extends Seeder {
	private $zone_countries_lookup = [];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */

	

	public function run() {

		$this->courier();

		$this->dhl_zone_seeder();
		$this->fedex_priority_zone_seeder();
		$this->fedex_economy_zone_seeder();	
		$this->ups_expedited_zone_seeder();
		$this->ups_saver_zone_seeder();	
		$this->ups_express_zone_seeder();	

		$this->dhl_rates_seeder();		
		$this->fedex_priority_rates_seeder();
		$this->fedex_economy_rates_seeder();
		
		$this->ups_expedited_rates_seeder();

		$this->ups_express_rates_seeder();
		$this->ups_saver_rates_seeder();


		$this->airbnx_direct_zone_seeder();
		$this->airbnx_indirect_zone_seeder();

		$this->airbnx_direct_rates_seeder();
		$this->airbnx_indirect_rates_seeder();
		$this->aramax_zone_rate_seeder();
		
		//$this->printLookUp();
		echo "Couriers & Zones : Done";

	}

	public function courier(){
		$couriers = [
			[
				'title' => 'DHL',
				'status' => 'active',
				'name' => 'dhl',
			],
			[
				'title' => 'Fedex Priority',
				'status' => 'active',
				'name' => 'fedex_priority',
			],
			[
				'title' => 'Fedex Economy',
				'status' => 'active',
				'name' => 'fedex_economy',
			],
			[
				'title' => 'UPS Expedited',
				'status' => 'active',
				'name' => 'ups_expedited',
			],
			[
				'title' => 'UPS Saver',
				'status' => 'active',
				'name' => 'ups_saver',
			],
			[
				'title' => 'UPS Express',
				'status' => 'active',
				'name' => 'ups_express',
			],
			[
				'title' => 'Airbnex Direct',
				'status' => 'active',
				'name' => 'airbnx_direct',
			],
			[
				'title' => 'Airbnex In-Direct',
				'status' => 'active',
				'name' => 'airbnx_indirect',
			],
			[
				'title' => 'Aramax First Pound',
				'status' => 'active',
				'name' => 'aramax_first_pound',
			],
			[
				'title' => 'Aramax Per Pound',
				'status' => 'active',
				'name' => 'aramax_per_pound',
			],


			 

			
		];

		foreach ($couriers as $key => $value) {
			$courier = Courier::create($value);
			
			
		}

		
		
	}

	public function dhl_zone_seeder(){

		$rcrd = Courier::where('name','dhl')->first();
		$id = $rcrd->id;

		$dhl_zones = DB::connection('mysql_old_data')->table('dhl_zones')
							->selectRaw('ANY_VALUE(zone) as dhl_zone,GROUP_CONCAT(code) as ctry_code')
							->groupBy('zone')
							->get();
		

		//dd($dhl_zones);

		foreach($dhl_zones as $dhl_zone)
		{
			$zone_countries = [];
			//dd($dhl_zone);
			$ctry_arr = explode(',',$dhl_zone->ctry_code);
			foreach ($ctry_arr as $ctry_code) {

				
				$ctry = Country::where('iso',$ctry_code)->select('id')->first();

				if($ctry):
					$zone_countries [] = $ctry->id;
				endif;
						
			}
			//dd($zone_countries);
			

			/*echo 'zone----'.$dhl_zone->code.'----        ';

			print_r($ctry->id);*/

			$courier_zone = new CourierZone;
			$courier_zone->title = strtolower($dhl_zone->dhl_zone);
			$courier_zone->country_ids = $zone_countries;
			// $courier_zone->type = 'dhl';
			//$courier_zone->status = $ctry->id;
			$courier_zone->courier_id = $id;

			$courier_zone->save();

		
		}
	}


	public function dhl_rates_seeder(){

		$dhl_rates = DB::connection('mysql_old_data')->table('dhl_rates')->get();

		$dhl_rates = collect($dhl_rates)->map(function($data){ return (array) $data; })->toArray();
		 
		
		
		foreach($dhl_rates as $dhl_rate)
		{
			//dd(array_keys($dhl_rate));
			$keys = array_except(array_keys($dhl_rate),[0,18,19]);
			//dd($keys);

			foreach ($keys as $value) {
				if($value != 'weight'):

				
				$courier = Courier::with(['courier_zone'=>function($qry) use ($value){
					$qry->where('title',$value)->first();
				}])->where('name','dhl')->select('id')->first();

				if(!$courier->courier_zone->isEmpty()):

				//$courier_zone_ids = Courier::with('courier_zone')->where('name','dhl')->select('id')->get();
				//dd($courier_zone_ids);
				
					
					$courier_rate = new CourierRate;
					$courier_rate->courier_zone_id = $courier->courier_zone[0]->id;
					$courier_rate->weight = $dhl_rate['weight'];
					$courier_rate->amount = $dhl_rate[$value];

					//dd($courier_rate);

					$courier_rate->save();
				endif;
			endif;
				
				
			}


			
		}

		//dd('doneeeeeeeee');
	}



	public function fedex_priority_zone_seeder(){


		$rcrd = Courier::where('name','fedex_priority')->first();
		$id = $rcrd->id;


		$fedex_zones = DB::connection('mysql_old_data')->table('country_zones')->selectRaw('ANY_VALUE(zone) as fedex_zone,GROUP_CONCAT(DISTINCT country) as country')->groupBy('zone')->get();

		

		//dd($fedex_zones);

		
		foreach($fedex_zones as $fedex_zone)
		{
			$zone_countries = [];
			
			//dd($fedex_zone);
			$ctry_arr = explode(',',$fedex_zone->country);
				foreach ($ctry_arr as $ctry_name) {
				
					$ctry_exist = $this->getCountryIDByCountryMatch($ctry_name,'--fedex-priority',$fedex_zone->fedex_zone);

						if($ctry_exist)						
							$zone_countries[] = $ctry_exist;
				}

					$courier_zone = new CourierZone;
					$courier_zone->title = strtolower($fedex_zone->fedex_zone);
					$courier_zone->country_ids = $zone_countries;
					//$courier_zone->type = 'fedex_priority';
					//$courier_zone->status = $ctry->id;
					$courier_zone->courier_id = $id;
					$courier_zone->save();

					
		}	

		
	}

	public function fedex_priority_rates_seeder(){


		$fedex_rates = DB::connection('mysql_old_data')->table('fedex_rate')->where('type','fedex_priority')->get();

		$fedex = collect($fedex_rates)->map(function($data){ return (array) $data; })->toArray();
		 
	
		
		foreach($fedex as $fedex_rate)
		{ 
			$keys = array_except(array_keys($fedex_rate),[0,2,18,19]);
			//dd($keys);

			foreach ($keys as $value) {
				if($value != 'weight'):

				
				$courier = Courier::with(['courier_zone'=>function($qry) use ($value){
					$qry->where('title',$value)->first();
				}])->where('name','fedex_priority')->select('id')->first();

				if(!$courier->courier_zone->isEmpty()):

					
					$courier_rate = new CourierRate;
					$courier_rate->courier_zone_id = $courier->courier_zone[0]->id;
					$courier_rate->weight = $fedex_rate['weight'];
					$courier_rate->amount = $fedex_rate[$value];

					//dd($courier_rate);

					$courier_rate->save();
				endif;
			endif;
				
			}


			
		}

		//dd('doneeeeeeeee');
	}

	public function fedex_economy_zone_seeder(){

		$rcrd = Courier::where('name','fedex_economy')->first();
		$id = $rcrd->id;

		$fedex_zones = DB::connection('mysql_old_data')->table('country_zones')->selectRaw('ANY_VALUE(zone) as fedex_zone,GROUP_CONCAT(DISTINCT country) as country')->groupBy('zone')->get();
		//dd($fedex_zones);

		
		foreach($fedex_zones as $fedex_zone)
		{
			$zone_countries = [];
			
			//dd($fedex_zone);
			$ctry_arr = explode(',',$fedex_zone->country);
				foreach ($ctry_arr as $ctry_name) {
					
					$ctry_exist = $this->getCountryIDByCountryMatch($ctry_name,'--fedex-economy',$fedex_zone->fedex_zone);

						if($ctry_exist)						
							$zone_countries[] = $ctry_exist;
					
				}

					$courier_zone = new CourierZone;
					$courier_zone->title = strtolower($fedex_zone->fedex_zone);
					$courier_zone->country_ids = $zone_countries;
					//$courier_zone->type = 'fedex_priority';
					//$courier_zone->status = $ctry->id;
					$courier_zone->courier_id = $id;
					$courier_zone->save();

					
		}	

		
	}

	public function fedex_economy_rates_seeder(){

		$fedex_rates = DB::connection('mysql_old_data')->table('fedex_rate')->where('type','fedex_economy')->get();
		//dd($fedex_rates);
		$fedex = collect($fedex_rates)->map(function($data){ return (array) $data; })->toArray();
		 
	//dd($fedex );
		
		foreach($fedex as $fedex_rate)
		{ 
			$keys = array_except(array_keys($fedex_rate),[0,2,18,19]);
			//dd($keys);

			foreach ($keys as $value) {

				if($value != 'weight'):

				
				$courier = Courier::with(['courier_zone'=>function($qry) use ($value){
					$qry->where('title',$value)->first();
				}])->where('name','fedex_economy')->select('id')->first();

				if(!$courier->courier_zone->isEmpty()):

				//$courier_zone_ids = Courier::with('courier_zone')->where('name','fedex_economy')->select('id')->get();
				
					
					$courier_rate = new CourierRate;
					$courier_rate->courier_zone_id = $courier->courier_zone[0]->id;
					$courier_rate->weight = $fedex_rate['weight'];
					$courier_rate->amount = $fedex_rate[$value];

					//dd($courier_rate);

					$courier_rate->save();
				endif;
			endif;
				
				
			}


			
		}

		
	}



	function ups_expedited_zone_seeder()
	{

		$rcrd = Courier::where('name','ups_expedited')->first();
		$id = $rcrd->id;


		$ups_expedited_zones = DB::connection('mysql_old_data')->table('ups_zones')->selectRaw('ANY_VALUE(priority) as ups_expedited,GROUP_CONCAT(DISTINCT country) as country')->groupBy('priority')->get();



		
		foreach($ups_expedited_zones as $ups_expedited_zone)
		{
			$zone_countries = [];
			
			//dd($ups_expedited_zone);
			$ctry_arr = explode(',',$ups_expedited_zone->country);
				foreach ($ctry_arr as $ctry_name) {

					$ctry_exist = $this->getCountryIDByCountryMatch($ctry_name,'--ups-expedited',$ups_expedited_zone->ups_expedited);

						if($ctry_exist)						
							$zone_countries[] = $ctry_exist;
				}

					$courier_zone = new CourierZone;
					$courier_zone->title = $ups_expedited_zone->ups_expedited;
					$courier_zone->country_ids = $zone_countries;
					//$courier_zone->type = 'fedex_priority';
					//$courier_zone->status = $ctry->id;
					$courier_zone->courier_id = $id;
					$courier_zone->save();

					
		}	

	}


	function ups_saver_zone_seeder()
	{

		$rcrd = Courier::where('name','ups_saver')->first();
		$id = $rcrd->id;

		$ups_saver_zones = DB::connection('mysql_old_data')->table('ups_zones')->selectRaw('ANY_VALUE(saver) as ups_saver,GROUP_CONCAT(DISTINCT country) as country')->groupBy('saver')->get();



		
		foreach($ups_saver_zones as $ups_saver_zone)
		{
			$zone_countries = [];
			
			//dd($ups_saver_zone);
			$ctry_arr = explode(',',$ups_saver_zone->country);
				foreach ($ctry_arr as $ctry_name) {
					$ctry_exist = $this->getCountryIDByCountryMatch($ctry_name,'--ups-saver',$ups_saver_zone->ups_saver);

						if($ctry_exist)						
							$zone_countries[] = $ctry_exist;
				}

					$courier_zone = new CourierZone;
					$courier_zone->title = $ups_saver_zone->ups_saver;
					$courier_zone->country_ids = $zone_countries;
					//$courier_zone->type = 'fedex_priority';
					//$courier_zone->status = $ctry->id;
					$courier_zone->courier_id = $id;
					$courier_zone->save();

					
		}	

	}


	function ups_express_zone_seeder()
	{

		$rcrd = Courier::where('name','ups_express')->first();
		$id = $rcrd->id;

		$ups_express_zones = DB::connection('mysql_old_data')->table('ups_zones')->selectRaw('ANY_VALUE(express) as ups_express,GROUP_CONCAT(DISTINCT country) as country')->groupBy('express')->get();



		

		//dd($ups_express_zones);
		foreach($ups_express_zones as $ups_express_zone)
		{
			if(!$ups_express_zone->ups_express == 0.0):
				

				$zone_countries = [];
			
				//dd($ups_express_zone);
				$ctry_arr = explode(',',$ups_express_zone->country);
					foreach ($ctry_arr as $ctry_name) {
						// if($ctry_name == 'Vatican City')

						$ctry_exist = $this->getCountryIDByCountryMatch($ctry_name,'--ups-express',$ups_express_zone->ups_express);

						if($ctry_exist)						
							$zone_countries[] = $ctry_exist;
					}

					//dd($zone_countries);

					$courier_zone = new CourierZone;
					$courier_zone->title = $ups_express_zone->ups_express;
					$courier_zone->country_ids = $zone_countries;
					//$courier_zone->type = 'fedex_priority';
					//$courier_zone->status = $ctry->id;
					$courier_zone->courier_id = $id;
					$courier_zone->save();
			endif;	
		}


	}

	function printLookUp(){

		var_dump($this->zone_countries_lookup);
	}

	function getCountryIDByCountryMatch($ctry_name,$courier_typ,$zone=NULL)
	{
		

		$ctry_arr = [
			'AG' =>'Antigua & Barbuda',
			'BQ' => 'Sint Eustatius and Saba',
			'VG' => 'British Virgin Islands',
			'MS' => 'Monserrat',
			'KN' => ['St. Kitts and Nevis','ST KITTS & NEVIS'],
			'SX' => 'St. Maarten',
			'TT' => 'Trinidad & Tobago',
			'TC' =>  ['Turks & Caicos Islands','TURKS & CAICOS IS'],
			'VI' => 'U.S. Virgin Islands',
			'MO' => 'Macau',
			'VN' => 'Vietnam',
			'BA' => ['Bosnia-Herzegovina','BOSNIA & HERZEGOVINA'],
			'CF' => 'Central African  Republic',
			'CD' => ['Dem Rep Of','DEM REP OF THE CONGO'],
			'GW' => 'GUINEA BISSAU',
			'CC' => 'COCOS KEELING IS',
			'CI' => ["Côte D'ivoire (Ivory Coast)",'IVORY COAST'],
			'TL' => 'East Timor',
			'LA' => 'Laos',
			'MP' => 'Saipan',
			'WF' => ['Wallis & Futuna','WALLIS & FUTUNA IS'],
			'BL' => 'st. barthelemy',
			'LC' => ['st. lucia','ST LUCIA'],
			'ES' => 'canary islands',
			'LI' => 'lichtenstein',
			'RE' => 'REUNION IS',
			'XK' => 'REPUBLIC OF KOSOVO',
			'KR' => 'KOREA SOUTH',
			'RS' => 'REPUBLIC OF SERBIA',
			'PT' => ['AZORES','MADEIRA IS'],
			'PN' => 'PITCAIRN IS',
			'PS' => ['Palestine Authority','PALESTINE'],
			'PM' => 'ST PIERRE & MIQUELON',
			'JP' => ['JAPAN (Excluding Okinawa)','JAPAN (Okinawa)'],
			'ES' => ['SPAIN ( CEUTA & MELILA )','CANARY IS'],
			'MT' => ['MALTA (Excluding Gozo & Comino Isl)','MALTA Islands (Gozo & Comino)'],
			'GB' => ['NORTHERN IRELAND','SCOTLAND','WALES','CHANNEL ISLANDS'],
			'VC' => ['st. vincent and the grenadines','St. Vincent & the Grenadines','ST VINCENT & GRENADINE'],
			/*'' => '',
			'' => '',*/
		];


		$ctry = Country::where('name','like','%'.$ctry_name.'%')->select('id')->first();


		
		if($ctry):
			//echo $ctry_name.'---fountd**';

			return $ctry->id;
		else:
			//echo $ctry_name.'----not**';
			foreach ($ctry_arr as $iso => $name) {

				if(is_array($name))
				{
					foreach ($name as $new_name) {

						if(ltrim(strtolower($ctry_name)) == strtolower($new_name))
						{
							
							$ctry = Country::where('iso',$iso)->select('id')->first();

							//echo '--Zone----'.$zone.'----ctry----'.$ctry_name.'----'.$ctry->id.'|||||||--------------------';
							return $ctry->id;
						}
					}

				}
				else
				{	
					if(ltrim(strtolower($ctry_name)) == strtolower($name))
					{
						
						$ctry = Country::where('iso',$iso)->select('id')->first();

						//echo '--Zone----'.$zone.'----ctry----'.$ctry_name.'----'.$ctry->id.'|||||||--------------------';
						return $ctry->id;
					}
				}
				
			}

			$this->zone_countries_lookup[$zone.'---'.$courier_typ][] = $ctry_name;
			
		endif;


		
	}





	public function ups_expedited_rates_seeder(){


		$ups_rates = DB::connection('mysql_old_data')->table('ups_expedite_rates')->get();

		$ups = collect($ups_rates)->map(function($data){ return (array) $data; })->toArray();
		 
	
		//dd($ups);
		foreach($ups as $ups_rate)
		{ 
			$keys = array_except(array_keys($ups_rate),[0,2,31,32]);
			
			//dd($keys);


			foreach ($keys as $value) {
				if($value != 'weight'):

				//dd($value);
				$courier = Courier::with(['courier_zone'=>function($qry) use ($value){
					$qry->where('title',$value)->first();
				}])->where('name','ups_expedited')->select('id')->first();

				if(!$courier->courier_zone->isEmpty()):
								
					$courier_rate = new CourierRate;
					$courier_rate->courier_zone_id = $courier->courier_zone[0]->id;
					$courier_rate->weight = $ups_rate['weight'];
					$courier_rate->amount = $ups_rate[$value];

					//dd($courier_rate);

					$courier_rate->save();

				endif;
			endif;
				
				
			}


			
		}

		//dd('doneeeeeeeee');
	}

	public function ups_express_rates_seeder(){


		$ups_rates = DB::connection('mysql_old_data')->table('ups_express_rates')->get();

		$ups = collect($ups_rates)->map(function($data){ return (array) $data; })->toArray();
		 
	
		//dd($ups);
		foreach($ups as $ups_rate)
		{ 
			$keys = array_except(array_keys($ups_rate),[0,19,20]);
			
			//dd($keys);


			foreach ($keys as $value) {
				if($value != 'weight'):

				//dd($value);
				$courier = Courier::with(['courier_zone'=>function($qry) use ($value){
					$qry->where('title',$value)->first();
				}])->where('name','ups_express')->select('id')->first();

				if(!$courier->courier_zone->isEmpty()):
								
					$courier_rate = new CourierRate;
					$courier_rate->courier_zone_id = $courier->courier_zone[0]->id;
					$courier_rate->weight = $ups_rate['weight'];
					$courier_rate->amount = $ups_rate[$value];

					//dd($courier_rate);

					$courier_rate->save();

				endif;
			endif;
				
				
			}


			
		}

		//dd('doneeeeeeeee');
	}


	public function ups_saver_rates_seeder(){


		$ups_rates = DB::connection('mysql_old_data')->table('ups_saver_rates')->get();

		$ups = collect($ups_rates)->map(function($data){ return (array) $data; })->toArray();
		 
	
		
		foreach($ups as $ups_rate)
		{ 
			$keys = array_except(array_keys($ups_rate),[0,19,20]);
			
			//dd($keys);


			foreach ($keys as $value) {
				if($value != 'weight'):

				//dd($value);
				$courier = Courier::with(['courier_zone'=>function($qry) use ($value){
					$qry->where('title',$value)->first();
				}])->where('name','ups_saver')->select('id')->first();

				if(!$courier->courier_zone->isEmpty()):
								
					$courier_rate = new CourierRate;
					$courier_rate->courier_zone_id = $courier->courier_zone[0]->id;
					$courier_rate->weight = $ups_rate['weight'];
					$courier_rate->amount = $ups_rate[$value];

					//dd($courier_rate);

					$courier_rate->save();

				endif;
			endif;
				
				
			}


			
		}

		//dd('doneeeeeeeee');
	}

	function airbnx_direct_zone_seeder(){

		$countries = Country::pluck('id')->toArray();

		//dd(json_encode($countries));

		$airbnx_direct_id = Courier::where('name','airbnx_direct')->first();

		$courier_zone = new CourierZone;
		$courier_zone->title = 'direct';
		$courier_zone->country_ids = $countries;
		//$courier_zone->type = 'fedex_priority';
		//$courier_zone->status = $ctry->id;
		$courier_zone->courier_id = $airbnx_direct_id->id;
		$courier_zone->save();

	}



	function airbnx_indirect_zone_seeder(){

		$countries = Country::pluck('id')->toArray();

		//dd(json_encode($countries));

		$airbnx_direct_id = Courier::where('name','airbnx_indirect')->first();

		$courier_zone = new CourierZone;
		$courier_zone->title = 'indirect';
		$courier_zone->country_ids = $countries;
		//$courier_zone->type = 'fedex_priority';
		//$courier_zone->status = $ctry->id;
		$courier_zone->courier_id = $airbnx_direct_id->id;
		$courier_zone->save();

	}

	function airbnx_direct_rates_seeder()
	{

		$airbn_rates = DB::connection('mysql_old_data')->table('airbn_rates')->get();

		$airbn = collect($airbn_rates)->map(function($data){ return (array) $data; })->toArray();

		//dd($airbn);

		foreach($airbn as $airbn_rate)
		{ 
			$keys = array_except(array_keys($airbn_rate),[0,3,4,5]);
			
			//dd($keys);


			foreach ($keys as $value) {
				if($value != 'weight'):

				//dd($value);
				$courier = Courier::with(['courier_zone'=>function($qry) use ($value){
					$qry->where('title',$value)->first();
				}])->where('name','airbnx_direct')->select('id')->first();
				//dd($courier);
				if(!$courier->courier_zone->isEmpty()):
								
					$courier_rate = new CourierRate;
					$courier_rate->courier_zone_id = $courier->courier_zone[0]->id;
					$courier_rate->weight = $airbn_rate['weight'];
					$courier_rate->amount = $airbn_rate[$value];

					//dd($courier_rate);

					$courier_rate->save();

				endif;
			endif;
				
				
			}


			
		}


	}

	function airbnx_indirect_rates_seeder()
	{

		$airbn_rates = DB::connection('mysql_old_data')->table('airbn_rates')->get();

		$airbn = collect($airbn_rates)->map(function($data){ return (array) $data; })->toArray();

		//dd($airbn);

		foreach($airbn as $airbn_rate)
		{ 
			$keys = array_except(array_keys($airbn_rate),[0,2,4,5]);
			
			//dd($keys);


			foreach ($keys as $value) {
				if($value != 'weight'):

				//dd($value);
				$courier = Courier::with(['courier_zone'=>function($qry) use ($value){
					$qry->where('title',$value)->first();
				}])->where('name','airbnx_indirect')->select('id')->first();
				//dd($courier);
				if(!$courier->courier_zone->isEmpty()):
								
					$courier_rate = new CourierRate;
					$courier_rate->courier_zone_id = $courier->courier_zone[0]->id;
					$courier_rate->weight = $airbn_rate['weight'];
					$courier_rate->amount = $airbn_rate[$value];

					//dd($courier_rate);

					$courier_rate->save();

				endif;
			endif;
				
				
			}


			
		}


	}



	function aramax_zone_rate_seeder(){

		$aramax_first_arr = DB::connection('mysql_old_data')->table('aramex_rate')
		                  ->select(['id','country','first_pound'])
		                  ->get();
		//dd(json_encode($countries));

		$aramax_first = Courier::where('name','aramax_first_pound')->first();


		foreach ($aramax_first_arr as $aramax) {
			$zone_countries = [];

			$ctry_exist = $this->getCountryIDByCountryMatch($aramax->country,'--aramax--','aramax-first');

			if($ctry_exist)						
				$zone_countries[] = $ctry_exist;
			else
				dd($aramax->country);
				
		$courier_zone = new CourierZone;
		$courier_zone->title = 'aramax_first';
		$courier_zone->country_ids = $zone_countries;
		//$courier_zone->type = 'fedex_priority';
		//$courier_zone->status = $ctry->id;
		$courier_zone->courier_id = $aramax_first->id;
		$courier_zone->save();

		$courier_rate = new CourierRate;
		$courier_rate->courier_zone_id = $courier_zone->id;
		$courier_rate->weight = 1;
		$courier_rate->amount = $aramax->first_pound;

		//dd($courier_rate);

		$courier_rate->save();
		}



		$aramax_per_arr = DB::connection('mysql_old_data')->table('aramex_rate')
		                  ->select(['id','country','per_pound'])
		                  ->get();
		//dd(json_encode($countries));

		$aramax_per = Courier::where('name','aramax_per_pound')->first();


		foreach ($aramax_per_arr as $aramax) {
			$zone_countries = [];

			$ctry_exist = $this->getCountryIDByCountryMatch($aramax->country,'--aramax--','aramax-per');

			if($ctry_exist)						
				$zone_countries[] = $ctry_exist;
			else
				dd($aramax->country);
				
		$courier_zone = new CourierZone;
		$courier_zone->title = 'aramax_per';
		$courier_zone->country_ids = $zone_countries;
		//$courier_zone->type = 'fedex_priority';
		//$courier_zone->status = $ctry->id;
		$courier_zone->courier_id = $aramax_per->id;
		$courier_zone->save();

		$courier_rate = new CourierRate;
		$courier_rate->courier_zone_id = $courier_zone->id;
		$courier_rate->weight = 1;
		$courier_rate->amount = $aramax->per_pound;

		//dd($courier_rate);

		$courier_rate->save();
		}



	}

	
}

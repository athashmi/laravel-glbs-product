<?php

namespace App\Http\Controllers\FrontEnd;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Helper;
use App\User;
use App\Shopaholic;
use App\Country;
use App\ShopaholicAddress;
use JavaScript;
use Intervention\Image\ImageManager;

class ProfileController extends Controller
{

	function __construct()
    {
    	JavaScript::put([
			'del_url' => route('profile.address_delete'),
		]);
    }

    
    public function index(){

    	

    	
    	$user = User::where('id',Auth::user()->id)->with(['shopaholic.addresses.country','country','shopaholic.primaryAddress'])->first();

		//dd($user);
    	//dd(is_object($user->shopoholic));
    	$json_user = $user->toJson();
    	//dd($json_user);
    	$countries = Country::all();
    	return view('frontend.profile.profile',compact('user','countries','json_user'));
    }



    public function addressStore(){
    	$validatedData = request()->validate([
			'name' => 'required',
			'phone' => 'required',
			'zip_code' => 'required',
			'street' => 'required',
			'city' => 'required',
			'state' => 'required',
			'country_name' => 'required', // coutry name means coutry id
		]);
		$shopaholic = ShopaholicAddress::create([
			'name' => request()->name,
			'phone' => request()->phone,
			'street' => request()->street,
			'city'  => request()->city,
			'state'  => request()->state,
			'zip_code' => request()->zip_code,
			'country_id' => request()->country_name,
			'shopaholic_id' => Auth::user()->shopaholic->id,

		]);
		if($shopaholic){
			$msg['status'] = 1;
			// $user = User::where('id',Auth::user()->id)->with('shopaholic.addresses.country')->first();
			// $msg['html']   = view('frontend.profile.addresses',compact('user'))->render();
			$msg['msg']    = 'Information has been saved successfully...';
			return $msg;
		}else{
			$msg['status'] = 0;
			$msg['error']  = 'Some thing went Worng ...';
			return json_encode($msg);
		}

    }


    public function primaryInfoUpdate(){

    	$validatedData = request()->validate([			
			'address.*' => 'required',
			'phone'		=> 'required',
			'country' => 'required', // coutry name means coutry id
		]);

    	//dd(request()->all());

    	$user = User::where('id',request()->user_id)->first();
    	$shopaholic = Shopaholic::where('user_id',request()->user_id)->first();

    	$user->dob = date('Y-m-d', strtotime(request()->dob));
    	$user->gender = request()->gender;
    	
    	$user->country_id = request()->country;



    	if (request()->hasFile('files')) {

			$file = request()->file("files");

			$file_unique_name = request()->first_name . '-' . time() . '-' . date("Ymdhis") . rand(0, 999) . '.' . $file->guessExtension();
			$file_unique_name_resized = time() . '-' . date("Ymdhis") . rand(0, 999) . '.' . $file->guessExtension();

			$file->storeAs(config('constants.img_folder'), $file_unique_name);
		//dd(storage_path(config('constants.img_folder') .'/'. $file_unique_name_resized));
			$ImageManager = new ImageManager();

			$ImageManager->make( \Storage::get(config('constants.img_folder') . '/' . $file_unique_name))->resize(268, 247)->save(storage_path('app/'.config('constants.img_folder').'/' . $file_unique_name_resized));
			

			

			$user->picture = $file_unique_name_resized;

			//$user->picture = request()->gender;
		}

		$user->update();


    	$shopaholic->update();

    	if(request()->address_id !='')
            $address =  ShopaholicAddress::find(request()->address_id);
        else
        {
        	$address = new ShopaholicAddress;
        	$address->type = 'primary';
        }

        	
            $address->street = request()->address['street'];
            $address->city = request()->address['city'];
            $address->zip_code = request()->address['zip_code'];
            $address->country_id = request()->country;
            $address->state = request()->address['state'];
            $address->street = request()->address['street'];
            $address->phone  = request()->phone;
            $address->shopaholic_id = Auth::user()->shopaholic->id;
            $address->save();
           
    		$msg['status'] = 1;
			
			return json_encode($msg);
		
    }

    public function ajaxAddressEdit() {
    	$id = request()->id;
		//dd($id);
		if (!empty($id)) {
			$address = ShopaholicAddress::find($id);
			if (isset($address->id)) {
				$msg['status'] = 1;
				$msg['data'] = $address;
				return json_encode($msg);
			} else {
				$msg['status'] = 0;
				$msg['data'] = "Data not found...";
				return json_encode($msg);
			}
		}

    }

    public function addressUpdate(){
    	$id = request()->id;
		$validatedData = request()->validate([
			'zip_code' => 'required',
			'street' => 'required',
			'city' => 'required',
			'state' => 'required',
			'phone' => 'required',

		]);
		if (!empty($id)) {
			$address = ShopaholicAddress::find($id);
			$is_update = $address->update(request()->all());
			if ($is_update) {
				$msg['status'] = 1;
				$msg['msg'] = "Information has been update successfully ...";
				return json_encode($msg);
			} else {
				$msg['status'] = 0;
				$msg['msg'] = "Some thing went wrong...";
				return json_encode($msg);
			}
		} else {
			$msg['status'] = 0;
			$msg['msg'] = "Some thing went wrong...";
			return json_encode($msg);
		}
    }

 public function ajaxAddressDelete() {
    	$id = request()->id;
		//dd($id);
		if (!empty($id)) {
			$add_obj = ShopaholicAddress::where('id', $id)->delete();
			if ($add_obj) {
				$msg['status'] 	= "1";
				$msg['data'] 	= "Record deleted successfully ...";
				return json_encode($msg);
			} else {
				$msg['status'] = 0;
				$msg['data'] = "Data not found...";
				return json_encode($msg);
			}
		}
    }


}

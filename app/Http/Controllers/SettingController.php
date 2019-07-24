<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Option;

class SettingController extends Controller
{
    
    public function socialLogins(){
    	$facebook = Option::where('module','facebook_api')->get(); 
        $option_arr['facebook_api'] = $facebook;
	      

		$twitter = Option::where('module','twitter_api')->get();
        $option_arr['twitter_api'] = $twitter;
		     

	    $googleplus = Option::where('module','googleplus_api')->get(); 

        $option_arr['googleplus_api'] = $googleplus;
		     
        //dd($option_arr);
    	return view('settings.social-logins.index')->with('options',$option_arr);
    }

    public function updateSocialLogins(Request $request)
    {
    	$arr_name = $request->type;
        //dd($request->all());
    	if(!empty($request->$arr_name['client_id'])){
    		$api_key = $request->$arr_name['client_id'];
    	}else{
    		$error['error']   = "Client ID is Missing";
    		$error['status']  = 'error';
    		return response($error);exit;
    	}
    	if(!empty($request->$arr_name['client_secret'])){
    		$api_secret= $request->$arr_name['client_secret'];
    	}else{
    		$error['error']   = "Client Secret is Missing";
    		$error['status']  = 'error';
    		return response($error);exit;
    	}
    	if(!empty($request->$arr_name['client_callback_url'])){
    		$api_callback_url = $request->arr_name['client_callback_url'];
    	}else{
    		$error['error']   = "Call Back Url is Missing";
    		$error['status']  = 'error';
    		return response($error);
    		exit;
    	}
    	$option_delete = Option::where('module',$arr_name)->delete();
    	if($option_delete)
    	{
    		foreach($request->$arr_name as $key => $value)
    		{
                $title_arr = explode('_', $key);
                $title = implode(' ',$title_arr);


    			$option = Option::create([
    				'module'     => $request->type,
                    'title'       => ucwords($title),
    				'key'       => $key,
    				'value'     => $value,
    				'status'    => 'active'
    			]);	
    		}
    		if($option){
    			$msg['status'] = 1;
    			return json_encode($msg);
    		}
    	}
    }

    public function paymentGateways(){
        $authorize_net = Option::where('module','authorize_net')->get(); 
        $option_arr['authorize_net'] = $authorize_net;
         
        $paypal = Option::where('module','paypal')->get();
        $option_arr['paypal'] = $paypal;

        return view('settings.payment-gateway.index')->with('options',$option_arr);
    }

    public function updatePaymentGateways(Request $request) {
        $arr_name = $request->type;

        //dd(request()->all());
        if($request->type == 'authorize_net'){
            if(!empty($request->$arr_name['api_login_id'])){
                $api_key = $request->$arr_name['api_login_id'];
            }else{
                $error['error']     = "Api Login ID is Missing";
                $error['status']    = 'error';
                return response($error);
                exit;
            }
            if(!empty($request->$arr_name['transaction_key'])){
                $api_key = $request->$arr_name['transaction_key'];
            }else{
                $error['error']     = "Transaction Key is Missing";
                $error['status']    = 'error';
                return response($error);
                exit;
            }
            $option_delete = Option::where('module',$arr_name)->delete();
            if($option_delete){
                foreach($request->$arr_name as $key => $value){

                    $title_arr = explode('_', $key);
                    $title = implode(' ',$title_arr);

                    $option = Option::create([
                        'module'     => $request->type,
                        'title'     => ucwords($title),
                        'key'       => $key,
                        'value'     => $value,
                        'status'    => 'active'
                ]);   
            }
                if($option){
                    $msg['status'] = 1;
                    return json_encode($msg);
                }
            }
        }

         //dd(request()->all());
        if($request->type == 'paypal'){
            if(!empty($request->$arr_name['client_id'])){
                $api_key = $request->$arr_name['client_id'];
            }else{
                $error['error']     = "Client ID is Missing";
                $error['status']    = 'error';
                return response($error);
                exit;
            }
            if(!empty($request->$arr_name['client_secret']))
            {
                $api_key = $request->$arr_name['client_secret'];
            }else{
                $error['error']     = "Client Secret is Missing";
                $error['status']    = 'error';
                return response($error);
                exit;
            }
            $option_delete = Option::where('module',$arr_name)->delete();
            if($option_delete){
                foreach($request->$arr_name as $key => $value){

                     $title_arr = explode('_', $key);
                    $title = implode(' ',$title_arr);

                    $option         =   Option::create([
                         'module'     => $request->type,
                        'title'     => ucwords($title),
                        'key'       =>  $key,
                        'value'     =>  $value,
                        'status'    =>  'active'
                    ]); 
                }
                if($option){
                    $msg['status'] = 1;
                    return json_encode($msg);
                }
            }
        }
    }

    public function recaptcha() {
        $recaptcha = Option::where('module','recaptcha')->get();
        $option_arr['recaptcha'] = $recaptcha;

         
        return view('settings.recaptcha.index')->with('options',$option_arr);
    }

    public function updateRecaptcha(Request $request){
        $arr_name = $request->type;

        //dd(request()->all());
        if(!empty($request->$arr_name['api_key'])){
            $api_key = $request->$arr_name['api_key'];
        }else{
            $error['error']     = "Api Key is Missing";
            $error['status']    = 'error';
            return response($error);
            exit;
        }
        if(!empty($request->$arr_name['api_secret'])){
            $api_secret = $request->$arr_name['api_secret'];
        }else{
            $error['error']     = "Api Secret is Missing";
            $error['status']    = 'error';
            return response($error);
            exit;
        }
        $option_delete = Option::where('module',$arr_name)->delete();
        if($option_delete){
            foreach($request->$arr_name as $key => $value){
                 $title_arr = explode('_', $key);
                    $title = implode(' ',$title_arr);

                $option         = Option::create([
                    'module'     => $request->type,
                    'title'     => ucwords($title),
                    'key'       => $key,
                    'value'     => $value,
                    'status'    => 'active'
                ]);  
            }
            if($option){
                    $msg['status'] = 1;
                    return json_encode($msg);
            }
        }
    }
}
